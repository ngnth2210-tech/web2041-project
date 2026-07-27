<?php

class DashboardController
{
    public function index()
    {
        $title = 'Bảng điều khiển';
        $view  = 'dashboard';

        require_once PATH_VIEW_MAIN_ADMIN;
    }

    public function notFound()
    {
        http_response_code(404);

        $title = 'Không tìm thấy trang';
        $view  = '404';

        require_once PATH_VIEW_MAIN_ADMIN;
    }
}
