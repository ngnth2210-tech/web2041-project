<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new DashboardController)->index(),

    // QUẢN TRỊ SẢN PHẨM
    'list-product'   => (new ProductController)->index(),
    'show-product'   => (new ProductController)->show(),
    'create-product' => (new ProductController)->create(),
    'store-product'  => (new ProductController)->store(),
    'edit-product'   => (new ProductController)->edit(),
    'update-product' => (new ProductController)->update(),
    'toggle-product' => (new ProductController)->toggleStatus(),

    // QUẢN TRỊ DANH MỤC
    'list-category'   => (new CategoryController)->index(),
    'create-category' => (new CategoryController)->create(),
    'store-category'  => (new CategoryController)->store(),
    'edit-category'   => (new CategoryController)->edit(),
    'update-category' => (new CategoryController)->update(),
    'toggle-category' => (new CategoryController)->toggleStatus(),

    // QUẢN TRỊ NGƯỜI DÙNG
    'list-user'   => (new UserController)->index(),
    'show-user'   => (new UserController)->show(),
    'lock-user'   => (new UserController)->lock(),
    'unlock-user' => (new UserController)->unlock(),

    // QUẢN TRỊ BÌNH LUẬN
    'list-comment'   => (new CommentController)->index(),
    'update-comment' => (new CommentController)->updateStatus(),
    'delete-comment' => (new CommentController)->destroy(),

    // QUẢN TRỊ ĐƠN HÀNG
    'list-order'          => (new AdminOrderController)->index(),
    'show-order'          => (new AdminOrderController)->show(),
    'update-order-status' => (new AdminOrderController)->updateStatus(),
    'delete-order'        => (new AdminOrderController)->delete(),

    default => require_once PATH_VIEW_ADMIN . '404.php',
};