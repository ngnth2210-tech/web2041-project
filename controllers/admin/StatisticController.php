<?php
class StatisticController
{
    private $model;

    public function __construct()
    {
        $this->model = new Statistic();
    }

    public function index()
    {
        $title             = 'Thống kê & Báo cáo';
        $totalRevenue      = $this->model->getTotalRevenue();
        $totalOrders       = $this->model->getTotalOrders();
        $totalProducts     = $this->model->getTotalProducts();
        $totalUsers        = $this->model->getTotalUsers();
        $revenueToday      = $this->model->getRevenueToday();
        $revenueThisMonth  = $this->model->getRevenueThisMonth();
        $ordersByStatus    = $this->model->getOrdersByStatus();
        $revenueByMonth    = $this->model->getRevenueByMonth();
        $ordersByDay       = $this->model->getOrdersByDay();
        $productsByCategory = $this->model->getProductsByCategory();
        $topProducts       = $this->model->getTopProducts(5);
        $latestOrders      = $this->model->getLatestOrders(8);
        $view = 'statistic/index';
        require_once PATH_VIEW_MAIN_ADMIN;
    }
}
