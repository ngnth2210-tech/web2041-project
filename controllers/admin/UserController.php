<?php
class UserController
{
    public $modelUser;

    public function __construct() {
        $this->modelUser = new User();
    }

    public function index() {
        $view = 'user/index';
        $title = 'Danh sách Người dùng';
        $data = $this->modelUser->getAll();
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    // Chỉ xem thông tin (không edit email, chỉ xem sđt nếu có)
    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL_ADMIN . '&action=list-user');
            exit;
        }
        $user = $this->modelUser->find($id);
        if (empty($user)) {
            header('Location: ' . BASE_URL_ADMIN . '&action=list-user');
            exit;
        }
        $view = 'user/show';
        $title = 'Thông tin: ' . $user['username'];
        $data = $user;
        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function lock(): void {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $user = $this->modelUser->find((int)$id);
            // Không cho khóa tài khoản admin chính
            if ($user && $user['is_main'] != 1) {
                $this->modelUser->updateStatus((int)$id, 0);
            } else {
                $_SESSION['error'] = "Không thể khóa tài khoản Admin chính!";
            }
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=list-user');
        exit();
    }

    public function unlock() {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $this->modelUser->updateStatus((int)$id, 1);
        }
        header('Location: ' . BASE_URL_ADMIN . '&action=list-user');
        exit();
    }
}
