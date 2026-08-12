<?php

class CommentController
{
    public $modelComment;

    public function __construct()
    {
        $this->modelComment = new Comment();
    }

    // Danh sách bình luận trong admin
    public function index()
    {
        $view = 'comment/index';
        $title = 'Danh sách Bình luận';

        $data = $this->modelComment->getAll();

        require_once PATH_VIEW_MAIN_ADMIN;
    }

    // Thêm bình luận từ phía client
    public function storeComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->modelComment->insertComment(
                $_POST['id_san_pham'],
                $_SESSION['user']['id'],
                $_POST['noi_dung']
            );

            header(
                'Location: ?action=detail-product&id=' .
                $_POST['id_san_pham']
            );

            exit();
        }
    }

    // Xóa bình luận
    public function destroy()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->modelComment->delete($id);
        }

        header('Location: ?mode=admin&action=list-comment');
        exit();
    }

    // Ẩn / hiện bình luận
    public function updateStatus()
    {
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? 0;

        if ($id) {
            $this->modelComment->update($id, $status);
        }

        header('Location: ?mode=admin&action=list-comment');
        exit();
    }
}