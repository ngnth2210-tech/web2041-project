<?php

session_start();

require_once './configs/env.php';
require_once './configs/helper.php';

require_once PATH_MODEL . 'BaseModel.php';

// Xác định mode TRƯỚC khi autoload
$mode = $_GET['mode'] ?? 'client';

spl_autoload_register(function ($class) use ($mode) {
    $fileName = "$class.php";

    $fileModel            = PATH_MODEL . $fileName;
    $fileControllerAdmin  = PATH_CONTROLLER_ADMIN . $fileName;
    $fileControllerClient = PATH_CONTROLLER_CLIENT . $fileName;

    // 1. Model luôn ưu tiên đầu
    if (is_readable($fileModel)) {
        require_once $fileModel;
        return;
    }

    if ($mode == 'admin') {
        // Admin: load admin controller trước
        if (is_readable($fileControllerAdmin)) {
            require_once $fileControllerAdmin;
            return;
        }
        if (is_readable($fileControllerClient)) {
            require_once $fileControllerClient;
            return;
        }
    } else {
        // Client: load client controller trước
        if (is_readable($fileControllerClient)) {
            require_once $fileControllerClient;
            return;
        }
        if (is_readable($fileControllerAdmin)) {
            require_once $fileControllerAdmin;
            return;
        }
    }
});

// Điều hướng
if ($mode == 'admin') {
    require_once './routes/admin.php';
} else {
    require_once './routes/client.php';
}