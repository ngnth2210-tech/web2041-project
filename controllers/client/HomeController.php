<?php

class HomeController
{
    public function index()
    {
        $title = 'Trang chủ';
        $view  = 'home';

        require_once PATH_VIEW_MAIN_CLIENT;
    }

    public function notFound()
    {
        http_response_code(404);

        $title = 'Không tìm thấy trang';
        $view  = '404';

        require_once PATH_VIEW_MAIN_CLIENT;
    }
}
