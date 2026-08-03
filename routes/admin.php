<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'     => (new DashboardController)->index(),
    // DANH MỤC
    'list-category'       => (new CategoryController)->index(),
    'create-category'     => (new CategoryController)->create(),
    'store-category'      => (new CategoryController)->store(),
    'edit-category'       => (new CategoryController)->edit(),
    'update-category'     => (new CategoryController)->update(),
    'toggle-category'     => (new CategoryController)->toggleStatus(),

    default => (new DashboardController)->notFound(),
};
