<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'     => (new DashboardController)->index(),

    default => (new DashboardController)->notFound(),
};
