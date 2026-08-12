<?php

/**
 * Các trang nội dung tĩnh: Về chúng tôi, Khuyến mãi, Liên hệ.
 * Không dùng model vì nội dung không lấy từ CSDL.
 */
class PageController
{
    public function about()
    {
        $view  = 'page/about';
        $title = 'Về chúng tôi';
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    public function promotion()
    {
        $view  = 'page/promotion';
        $title = 'Khuyến mãi';
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    public function contact()
    {
        $view  = 'page/contact';
        $title = 'Liên hệ';
        require_once PATH_VIEW_MAIN_CLIENT;
    }
}
