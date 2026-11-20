CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(150) NOT NULL,
email VARCHAR(150) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
phone VARCHAR(20) DEFAULT NULL,
address VARCHAR(255) DEFAULT NULL,
role ENUM('admin','staff','customer') NOT NULL DEFAULT
'customer',
status ENUM('active','locked') NOT NULL DEFAULT 'active',
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- ----------------------------------------------------------------
-- Bang categories
-- ----------------------------------------------------------------
CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(150) NOT NULL,
slug VARCHAR(160) NOT NULL UNIQUE,
status ENUM('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- ----------------------------------------------------------------
-- Bang products (KHONG co cot anh)
-- ----------------------------------------------------------------
CREATE TABLE products (
id INT AUTO_INCREMENT PRIMARY KEY,
category_id INT NOT NULL,
sku VARCHAR(50) NOT NULL UNIQUE,
name VARCHAR(200) NOT NULL,
brand VARCHAR(100) DEFAULT NULL,
description TEXT,
price DECIMAL(12,0) NOT NULL,
stock INT NOT NULL DEFAULT 0,
is_featured TINYINT(1) NOT NULL DEFAULT 0,
status ENUM('active','inactive') NOT NULL DEFAULT 'active',
sold_count INT NOT NULL DEFAULT 0,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_products_category
FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- ----------------------------------------------------------------
-- Bang product_images: 1 san pham - N anh
-- ----------------------------------------------------------------
CREATE TABLE product_images (
id INT AUTO_INCREMENT PRIMARY KEY,
product_id INT NOT NULL,

file_name VARCHAR(255) NOT NULL,
original_name VARCHAR(255) DEFAULT NULL,
alt_text VARCHAR(255) DEFAULT NULL,
is_primary TINYINT(1) NOT NULL DEFAULT 0,
sort_order INT NOT NULL DEFAULT 0,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
CONSTRAINT fk_images_product
FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
INDEX idx_product_sort (product_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- ----------------------------------------------------------------
-- Du lieu mau: 5 danh muc
-- ----------------------------------------------------------------
INSERT INTO categories (name, slug, status) VALUES
('Điện thoại - Máy tính bảng', 'dien-thoai-may-tinh-bang', 'active'),
('Thời trang nam', 'thoi-trang-nam', 'active'),
('Thời trang nữ', 'thoi-trang-nu', 'active'),
('Giày dép', 'giay-dep', 'active'),
('Đồ gia dụng', 'do-gia-dung', 'active');
-- ----------------------------------------------------------------
-- Du lieu mau: 20 san pham (chua co anh - anh se sinh o Buoc 10)
-- ----------------------------------------------------------------
INSERT INTO products (category_id, sku, name, brand, description, price,
stock, is_featured, status) VALUES
(1,'SP0001','Điện thoại Smart X10','SmartTech','Màn hình 6.5 inch, pin
5000mAh, camera 50MP.',4990000,50,1,'active'),
(1,'SP0002','Điện thoại Smart X10 Pro','SmartTech','Bản nâng cấp RAM 8GB,
bộ nhớ 256GB.',7990000,30,1,'active'),
(1,'SP0003','Máy tính bảng TabOne 10','TabCo','Màn hình 10.1 inch Full HD,
hỗ trợ bút cảm ứng.',3590000,25,0,'active'),
(1,'SP0004','Điện thoại Mini S','SmartTech','Thiết kế nhỏ gọn, phù hợp học
sinh sinh viên.',2290000,60,0,'active'),
(1,'SP0005','Máy tính bảng TabOne Lite','TabCo','Phiên bản phổ thông, giá
tốt, phù hợp giải trí.',2890000,40,0,'active'),
(2,'SP0006','Áo sơ mi nam dài tay','FashionMen','Chất liệu cotton thoáng
mát, form slimfit.',259000,100,1,'active'),
(2,'SP0007','Quần tây nam công sở','FashionMen','Vải kaki co giãn nhẹ,
không nhăn.',329000,80,0,'active'),
(2,'SP0008','Áo thun nam cổ tròn','FashionMen','Cotton 100%, nhiều màu lựa
chọn.',159000,150,1,'active'),
(2,'SP0009','Áo khoác nam chống nước','FashionMen','Chống thấm nước nhẹ,
phù hợp đi xe máy.',459000,45,0,'active'),
(3,'SP0010','Váy liền thân nữ','FashionWomen','Thiết kế trẻ trung, phù hợp
đi làm và dạo phố.',389000,70,1,'active'),
(3,'SP0011','Áo kiểu nữ tay phồng','FashionWomen','Chất liệu lụa mềm mại,
form rộng rãi.',279000,90,0,'active'),
(3,'SP0012','Chân váy xếp ly','FashionWomen','Phong cách công sở thanh
lịch.',249000,65,0,'active'),
(3,'SP0013','Áo len nữ cổ lọ','FashionWomen','Giữ ấm tốt, chất len mềm
không xù lông.',319000,55,0,'active'),
(4,'SP0014','Giày sneaker thể thao nam','SportFeet','Đế cao su chống trượt,

đệm êm chân.',589000,60,1,'active'),
(4,'SP0015','Giày cao gót nữ 7cm','StyleWalk','Thiết kế mũi nhọn thanh
lịch, đế êm.',399000,40,0,'active'),
(4,'SP0016','Dép sandal nam quai ngang','SportFeet','Phù hợp đi biển, đi
học, đi làm.',199000,85,0,'active'),
(4,'SP0017','Giày thể thao nữ dệt lưới','StyleWalk','Thoáng khí, trọng
lượng nhẹ.',479000,50,0,'active'),
(5,'SP0018','Nồi cơm điện 1.8L','HomeLife','Lòng nồi chống dính, nấu nhanh
tiết kiệm điện.',629000,35,1,'active'),
(5,'SP0019','Máy xay sinh tố đa năng','HomeLife','Công suất 500W, cối xay
inox 304.',459000,45,0,'active'),
(5,'SP0020','Bộ nồi inox 5 món','HomeLife','Đáy từ 3 lớp, dùng được cho mọi
loại bếp.',890000,20,0,'active');
-- ===================== BUOI 2 =====================
-- 2 tai khoan quan tri mau.
-- Mat khau goc: admin@shop.local / admin123 va staff@shop.local /staff123
-- Cot password luu sẵn chuoi hash bcrypt (tao boi password_hash()),
-- KHONG phai mat khau that - khong the suy nguoc lai mat khau tu hash nay.
INSERT INTO users (full_name, email, password, role, status) VALUES
('Quản trị viên', 'admin@shop.local','$2y$10$3bcAYXYYxv7TuWI9KH3zOOSDGTT8Q7P/ptvLmboC/WyXdJRWkVYku', 'admin','active'),
('Nhân viên bán hàng', 'staff@shop.local','$2y$10$Q2u2cILb1athiBr5Nz9njOJSvQwfjB333zsvP4omlakUD9rCTpBO2', 'staff','active');
-- ===================== BUOI 2 =====================
-- 2 tai khoan quan tri mau.
-- Mat khau goc: admin@shop.local / admin123 va staff@shop.local /staff123
-- Cot password luu sẵn chuoi hash bcrypt (tao boi password_hash()),
-- KHONG phai mat khau that - khong the suy nguoc lai mat khau tu hash nay.
INSERT INTO users (full_name, email, password, role, status) VALUES
('Quản trị viên', 'admin@shop.local',
'$2y$10$3bcAYXYYxv7TuWI9KH3zOOSDGTT8Q7P/ptvLmboC/WyXdJRWkVYku', 'admin','active'),
('Nhân viên bán hàng', 'staff@shop.local','$2y$10$Q2u2cILb1athiBr5Nz9njOJSvQwfjB333zsvP4omlakUD9rCTpBO2', 'staff','active');
-- ===================== BUOI 5 =====================
-- Them chi muc cho cac cot thuong dung trong WHERE / ORDER BY de tang toc do truy van.
-- category_id da duoc danh chi muc tu dong vi la khoa ngoai, khong can them.
ALTER TABLE products ADD INDEX idx_products_name (name);
ALTER TABLE products ADD INDEX idx_products_brand (brand);
ALTER TABLE products ADD INDEX idx_products_price (price);
ALTER TABLE products ADD INDEX idx_products_sold_count (sold_count);