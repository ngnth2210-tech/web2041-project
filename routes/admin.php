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
     // Quản trị người dùng
     'list-user'   => (new UserController)->index(),
     'show-user'   => (new UserController)->show(),
     'lock-user'   => (new UserController)->lock(),
     'unlock-user' => (new UserController)->unlock(),
    default => require_once PATH_VIEW_ADMIN . '404.php',
};