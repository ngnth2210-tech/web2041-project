<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'                => (new ProductController)->index(),
    'list-product'     => (new ProductController)->index(),
    'show-product'     => (new ProductController)->show(),
    'create-product'   => (new ProductController)->create(),
    'store-product'    => (new ProductController)->store(),
    'edit-product'     => (new ProductController)->edit(),
    'update-product'   => (new ProductController)->update(),
    'toggle-product'   => (new ProductController)->toggleStatus(),

    default => require_once PATH_VIEW_ADMIN . '404.php',
};