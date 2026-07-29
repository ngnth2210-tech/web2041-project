<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'              => (new HomeController)->index(),
    'list-product'   => (new ProductController)->index(),
    'show-product'   => (new ProductController)->show(),
    'detail-product' => (new DetailProductController)->show(),

    // Bình luận
    'store-comment'  => (new DetailProductController)->storeComment(),

    // Đăng nhập / Đăng ký
    'login'           => (new AuthController)->loginForm(),
    'handle-login'    => (new AuthController)->loginProcess(),
    'register'        => (new AuthController)->registerForm(),
    'handle-register' => (new AuthController)->registerProcess(),
    'logout'          => (new AuthController)->logout(),

    // Đặt hàng
    'order-create'      => (new ClientOrderController)->create(),
    'order-store'       => (new ClientOrderController)->store(),
    'order-success'     => (new ClientOrderController)->success(),
    'order-create-cart' => (new ClientOrderController)->createFromCart(),

    // Lịch sử đơn hàng
    'order-history' => (new OrderHistoryController)->index(),
    'order-detail'  => (new OrderHistoryController)->detail(),
    'order-cancel'  => (new OrderHistoryController)->cancel(),

    // MoMo Payment
    'momo-pay'    => (new MomoController)->pay(),
    'momo-return' => (new MomoController)->returnUrl(),
    'momo-notify' => (new MomoController)->notify(),

    // Giỏ hàng
    'cart'        => (new CartController)->index(),
    'cart-add'    => (new CartController)->add(),
    'cart-update' => (new CartController)->update(),
    'cart-remove' => (new CartController)->remove(),
    'cart-clear'  => (new CartController)->clear(),
};
