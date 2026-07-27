<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'     => (new HomeController)->index(),

    default => (new HomeController)->notFound(),
};
