<?php 
class AuthController {
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }


    public function loginForm() {
        if(isset($_SESSION['user_id'])) {
            header('Location:' . BASE_URL);
            exit();
        }
        $view = 'auth/login';
        $title = 'Đăng nhập hệ thống';
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    public function registerForm() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }
        $view = 'auth/register';
        $title = 'Đăng ký tài khoản';
        require_once PATH_VIEW_MAIN_CLIENT;
    }

    //xử lí post

    public function loginProcess() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '?action=login');
        exit;
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $this->userModel->getUserByUsername($username);

    if($user && password_verify($password, $user['password']) && $user['status'] == 1) {

            //đăng nhập thành công lưu vào session

            $_SESSION['user_id'] = $user['id'];

            $_SESSION['user_name'] = $user['username'];

            $_SESSION['user_role'] = $user['is_main'] == 1 ? 'admin' : 'client'; 



            if ($_SESSION['user_role'] == 'admin') {

                header('Location: ' . BASE_URL_ADMIN);

            } else {

                header('Location: ' . BASE_URL);

            }

            exit();

        } elseif ($user && $user['status'] == 0) {

            $error = 'Tài khoản của bạn đã bị khóa.';

        } else {

            $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';

        }



        $view = 'auth/login';

        $title = 'Đăng nhập hệ thống';

        require_once PATH_VIEW_MAIN_CLIENT;

    
}


    public function registerProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?action=register');
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $passwordConfirm = trim($_POST['password_confirm'] ?? '');
        $error = '';

        //validate

        if(empty($username) || empty($email) || empty($password)) {
            $error = "Vui lòng điền đầy đủ thông tin";
        } elseif ($password !== $passwordConfirm) {
            $error = "Xác nhận mật khẩu không khớp";
        } elseif($this->userModel->checkUserExists($username, $email)) {
            $error = "Tên đăng nhập hoặc email đã tồn tại";
        }

        if ($error) {
            $view = 'auth/register';
            $title = 'Đăng ký tài khoản';
            require_once PATH_VIEW_MAIN_CLIENT;
            return;
        }

        //đăng ký thành công
        $this->userModel->insertUser($username, $email, $password);
        
        $_SESSION['success_message'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        header('Location: ' . BASE_URL . '?action=login');
        exit();
    
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL);
        exit();
    }
}
?>