
1. composer install : Cài đặt các gói phụ thuộc của PHP (vendor)
2. cp .env.example .env : Tạo file môi trường .env
3. php artisan key:generate : Tạo Khóa Ứng Dụng (Application Key)


Mở file .env bằng trình soạn thảo

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lanvitura
DB_USERNAME=root
DB_PASSWORD=

4. php artisan migrate : Chạy Migrations (để tạo bảng trong database)
5. npm install : Cài đặt các gói phụ thuộc Frontend
6. npm run dev : Biên dịch tài nguyên Frontend (Assets)

Sử dụng git

1. git config --global user.name "phantrithien" : Cấu hình Git
2. git config --global user.email "ph.trithien@gmail.com" : Cấu hình Git
3. git init : Khởi tạo Git Repository
4. git add . : thêm tất cả
5. git status : Kiểm tra trạng thái
6. git commit -m "mô tả" : Commit thay đổi
7. git remote add origin https://github.com/phantrithien/lanvitura.git : Kết nối với GitHub
8. git push -u origin <main> : Đẩy mã lên remote