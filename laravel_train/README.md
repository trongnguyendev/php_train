# Laravel User Management CRUD

Ứng dụng quản lý người dùng đơn giản được xây dựng với Laravel và Tailwind CSS.

## Tính năng

- **Create**: Tạo người dùng mới với validation
- **Read**: Hiển thị danh sách và chi tiết người dùng
- **Update**: Chỉnh sửa thông tin người dùng
- **Delete**: Xóa người dùng với xác nhận
- **Pagination**: Phân trang danh sách người dùng
- **Validation**: Kiểm tra dữ liệu đầu vào
- **Responsive Design**: Giao diện đẹp và responsive

## Cài đặt

1. Clone repository:
```bash
git clone <repository-url>
cd laravel_train
```

2. Cài đặt dependencies:
```bash
composer install
npm install
```

3. Tạo file .env:
```bash
cp .env.example .env
```

4. Cấu hình database trong file .env

5. Chạy migration và seeder:
```bash
php artisan migrate:fresh --seed
```

6. Build assets:
```bash
npm run build
```

7. Chạy server:
```bash
php artisan serve
```

## Sử dụng

### Routes

- `GET /` - Chuyển hướng đến danh sách users
- `GET /users` - Hiển thị danh sách tất cả users
- `GET /users/create` - Form tạo user mới
- `POST /users` - Lưu user mới
- `GET /users/{user}` - Hiển thị chi tiết user
- `GET /users/{user}/edit` - Form chỉnh sửa user
- `PUT /users/{user}` - Cập nhật user
- `DELETE /users/{user}` - Xóa user

### Dữ liệu mẫu

Seeder sẽ tạo các user mẫu:
- Admin: admin@example.com / password123
- Nguyễn Văn A: nguyenvana@example.com / password123
- Trần Thị B: tranthib@example.com / password123
- Lê Văn C: levanc@example.com / password123

## Cấu trúc

```
app/
├── Http/Controllers/
│   └── UserController.php    # Controller xử lý CRUD
├── Models/
│   └── User.php             # Model User
resources/
└── views/
    ├── layouts/
    │   └── app.blade.php    # Layout chính
    └── users/
        ├── index.blade.php   # Danh sách users
        ├── create.blade.php  # Form tạo user
        ├── show.blade.php    # Chi tiết user
        └── edit.blade.php    # Form chỉnh sửa user
```

## Validation Rules

- **Name**: Bắt buộc, tối đa 255 ký tự
- **Email**: Bắt buộc, định dạng email, duy nhất
- **Password**: Bắt buộc khi tạo mới, tối thiểu 8 ký tự, cần xác nhận
- **Password Confirmation**: Bắt buộc khi tạo mới

## Giao diện

- Sử dụng Tailwind CSS cho styling
- Responsive design
- Navigation menu
- Flash messages cho thông báo
- Confirmation dialog cho xóa
- Pagination cho danh sách dài

## Bảo mật

- CSRF protection
- Password hashing
- Input validation
- SQL injection protection (Eloquent ORM)
- XSS protection (Blade templating)

## Phát triển thêm

Để mở rộng ứng dụng, bạn có thể:

1. Thêm authentication và authorization
2. Thêm roles và permissions
3. Thêm profile picture upload
4. Thêm email verification
5. Thêm password reset functionality
6. Thêm API endpoints
7. Thêm unit tests và feature tests
