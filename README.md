# web2041-project

Ứng dụng web PHP thuần theo mô hình MVC, chạy trên Laragon (Apache + MySQL).

## Yêu cầu

- PHP 8.1 trở lên (cần cú pháp `match`)
- MySQL / MariaDB
- Laragon (hoặc Apache + MySQL tương đương)

## Cài đặt

1. Clone dự án vào document root của Laragon:

   ```
   git clone <url-repo> web2041-project
   ```

2. Tạo file cấu hình từ file mẫu:

   ```
   cp configs/env.example.php configs/env.php
   ```

   Sau đó sửa `DB_NAME`, `DB_USERNAME`, `DB_PASSWORD` và `BASE_URL` cho khớp máy bạn.

3. Đặt mật khẩu MySQL cho khớp cấu hình chung của nhóm (`root` / `123456`):

   ```sql
   ALTER USER 'root'@'localhost' IDENTIFIED BY '123456';
   ```

4. Tạo cơ sở dữ liệu bằng cách chạy `database.sql`.

5. Reload Apache trong Laragon rồi truy cập `http://web2041-project.test`.

## Cấu trúc thư mục

```
├── assets/            Tài nguyên tĩnh
│   ├── css/           Stylesheet
│   └── uploads/       File người dùng tải lên (không commit)
├── configs/
│   ├── env.php        Cấu hình thật (KHÔNG commit)
│   ├── env.example.php Cấu hình mẫu
│   └── helper.php     Hàm tiện ích dùng chung
├── controllers/
│   ├── admin/         Controller khu vực quản trị
│   └── client/        Controller khu vực người dùng
├── models/            Model, kế thừa BaseModel
├── routes/
│   ├── admin.php      Định tuyến ?mode=admin
│   └── client.php     Định tuyến mặc định
├── views/
│   ├── admin/         Giao diện quản trị (layout main.php)
│   └── client/        Giao diện người dùng (layout main.php)
├── database.sql       Script tạo CSDL
└── index.php          Front controller + autoload
```

## Cách hoạt động

Mọi request đều đi qua `index.php`. Front controller sẽ:

1. Nạp cấu hình và hàm tiện ích.
2. Đọc `?mode=` để xác định khu vực (`client` mặc định, hoặc `admin`).
3. Đăng ký autoload — ưu tiên model, sau đó tới controller của đúng khu vực.
4. Nạp file route tương ứng, route đọc `?action=` và gọi đúng controller.

## Thêm chức năng mới

1. Tạo model trong `models/`, kế thừa `BaseModel` để có sẵn kết nối `$this->pdo`, rồi tự viết các hàm truy vấn cần dùng.
2. Tạo controller trong `controllers/client/` hoặc `controllers/admin/`.
3. Khai báo action mới trong file route tương ứng.
4. Tạo view trong `views/client/` hoặc `views/admin/`; layout sẽ tự nạp qua biến `$view`.

## Quy ước URL

| URL | Ý nghĩa |
| --- | --- |
| `/` | Trang chủ người dùng |
| `/?action=ten-action` | Action phía người dùng |
| `/?mode=admin` | Tổng quan quản trị |
| `/?mode=admin&action=ten-action` | Action phía quản trị |
