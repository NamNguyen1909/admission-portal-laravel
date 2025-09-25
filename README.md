# Admission Portal - Laravel

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
</p>

<p align="center">
  <strong>🎓 Hệ thống quản lý quy trình tuyển sinh cho trường đại học</strong>
</p>

<p align="center">
  Bao gồm 2 module chính:<br>
  <strong>Registration</strong>: Quản lý thông tin đăng ký của thí sinh<br>
  <strong>Application</strong>: Quản lý hồ sơ tuyển sinh được tạo từ Registration
</p>

## Yêu cầu hệ thống

### Bắt buộc
- **PHP >= 8.1** (có thể cài standalone hoặc qua XAMPP)
- **Composer** (PHP package manager)
- **Git** (để clone project)

### Database
- **MySQL** (cài standalone hoặc qua XAMPP)

### Tùy chọn
- **Node.js & NPM** (chỉ cần nếu muốn build frontend assets)

## Cách setup database

### Bước 1: Clone project
```bash
git clone <repository-url>
cd admission-portal
```

### Bước 2: Cài đặt dependencies
```bash
composer install
```

### Bước 3: Tạo file .env
```bash
# Copy file .env.example thành .env
copy .env.example .env

# Hoặc trên Linux/Mac
cp .env.example .env
```

### Bước 4: Cấu hình database trong .env
```env
# Cấu hình MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admission_portal
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Bước 5: Tạo database MySQL

**Cách 1: Sử dụng MySQL Workbench (UI)**
1. Mở MySQL Workbench
2. Connect đến MySQL server
3. Tạo database mới: `CREATE DATABASE admission_portal;`
4. Hoặc right-click → Create Schema → đặt tên `admission_portal`

**Cách 2: Sử dụng command line**
```bash
# Đăng nhập MySQL
mysql -u root -p

# Tạo database
CREATE DATABASE admission_portal;

# Thoát MySQL
exit;
```

### Bước 6: Generate application key
```bash
php artisan key:generate
```

## Cách chạy migration + seeder

### Chạy migration để tạo bảng
```bash
php artisan migrate
```

### Chạy seeder để tạo dữ liệu mẫu
```bash
php artisan db:seed
```

### Hoặc chạy cả migration và seeder cùng lúc
```bash
php artisan migrate:fresh --seed
```

## Cách start server

### Khởi động Laravel development server
```bash
php artisan serve
```

Server sẽ chạy tại: **http://127.0.0.1:8000**

### Hoặc chỉ định port khác
```bash
php artisan serve --port=8001
```

## Cấu trúc hệ thống

### Registration Module
- **URL**: `/registrations`
- **Chức năng**: 
  - Tạo form đăng ký thí sinh
  - Danh sách registrations
  - Xem chi tiết registration
  - Upload profile picture và passport file

### Application Module  
- **URL**: `/applications`
- **Chức năng**:
  - Danh sách applications với filter
  - Tự động tạo application từ registration
  - Cập nhật status và payment status
  - Xem chi tiết application

## Dữ liệu mẫu

Sau khi chạy seeder, hệ thống sẽ có:
- **4 registrations mẫu** (Van A, Thi B, Van C, Thi D)
- **4 applications mẫu** được tự động tạo từ mỗi registration


## Tính năng chính

### Registration
- ✅ Form đăng ký với đầy đủ thông tin cá nhân
- ✅ Upload profile picture và passport file
- ✅ Validation form đầy đủ
- ✅ Responsive UI với Bootstrap 5

### Application
- ✅ Tự động sinh Application ID (APP-YYYY-####)
- ✅ Lấy thông tin từ Registration
- ✅ Filter theo program, date range, application number
- ✅ Quản lý status và payment status
- ✅ Pagination và search

## Demo URLs

- **Homepage**: http://127.0.0.1:8000
- **Registration Form**: http://127.0.0.1:8000/registrations/create
- **Registration List**: http://127.0.0.1:8000/registrations  
- **Application List**: http://127.0.0.1:8000/applications

## Troubleshooting

### Cấu hình PHP Extensions (quan trọng!)
Nếu mới cài PHP, cần mở các extensions trong `php.ini`:

**Tìm file php.ini:**
```bash
# Kiểm tra vị trí php.ini
php --ini
```

**Mở các extensions sau (bỏ dấu `;` ở đầu dòng):**
```ini
extension=pdo_mysql     ; Cho MySQL
extension=pdo_sqlite    ; Cho SQLite  
extension=mbstring      ; Xử lý chuỗi
extension=openssl       ; HTTPS/SSL
extension=fileinfo      ; Upload file
extension=gd            ; Xử lý ảnh
extension=curl          ; HTTP requests
extension=zip           ; Giải nén composer packages
```

**Restart web server sau khi chỉnh sửa php.ini**

### Lỗi permission

#### Linux/Mac
```bash
chmod -R 775 storage bootstrap/cache
```

#### Windows (nếu gặp lỗi quyền)
```bash
# Chạy CMD/PowerShell với quyền Administrator
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

### Lỗi database connection
- Kiểm tra file `.env` có đúng cấu hình MySQL
- Đảm bảo database `admission_portal` đã được tạo
- Kiểm tra MySQL service đang chạy
- Kiểm tra username/password MySQL đúng

### Lỗi Composer
```bash
# Nếu composer install bị lỗi
composer install --ignore-platform-reqs

# Hoặc update composer
composer self-update
```

### Clear cache nếu cần
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Lỗi thường gặp khác

#### "Class not found" errors
```bash
composer dump-autoload
```

#### "Key not found" errors  
```bash
php artisan key:generate
```

#### Upload file không hoạt động
- Kiểm tra `php.ini`: `file_uploads = On`
- Kiểm tra `upload_max_filesize` và `post_max_size`
- Tạo symbolic link: `php artisan storage:link`
