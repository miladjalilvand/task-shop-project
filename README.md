# 🛍️ پروژه فروشگاهی

پروژه فروشگاهی با ساختار ماژولار و پنل ادمین، توسعه داده‌شده با **Laravel 12**, **Tailwind CSS**, **Vite**, و **MySQL**.  
این سیستم شامل دو بخش اصلی است:  
- **پنل ادمین:** برای مدیریت فروشگاه، محصولات، دسته‌بندی‌ها و کاربران.  
- **فروشگاه کاربری:** برای مشاهده محصولات، افزودن به سبد خرید، ثبت سفارش و مدیریت حساب کاربری.

---

## ⚙️ تکنولوژی‌های استفاده‌شده
- Laravel 12  
- Tailwind CSS  
- Vite  
- MySQL  

---

## 🚀 مراحل نصب پروژه

1. کلون یا دانلود پروژه  
   ```bash
   git clone <repo-link>
   cd <project-folder>
   ```

2. نصب وابستگی‌های بک‌اند  
   ```bash
   composer install
   ```

   ```

3. تنظیم فایل `.env`  
   - اتصال به دیتابیس MySQL  
   - اجرای مهاجرت‌ها  نیاز)
     ```bash
     php artisan migrate
     ```

4. لینک دادن فایل‌های ذخیره‌سازی  
   ```bash
   php artisan storage:link
   ```

5. ایجاد حساب کاربری ادمین  
   - ابتدا ثبت‌نام کنید در سایت  
   - سپس در دیتابیس، نقش کاربر خود را به `admin` تغییر دهید تا به پنل مدیریت دسترسی داشته باشید

---

## 🧩 ساختار ماژولار پروژه

ماژول‌ها به‌صورت جداگانه در پوشه‌ی `Modules` سازمان‌دهی شده‌اند:

- `Products` → مدیریت محصولات  
- `Categories` → مدیریت دسته‌بندی‌ها  
- `Carts` → مدیریت سبد خرید  
- `Orders` → مدیریت سفارش‌ها  

---

## 👨‍💼 پنل ادمین
/dashboard
- مشاهده و تغییر وضعیت سفارشات  
- ایجاد، ویرایش، حذف و بروزرسانی محصولات و دسته‌بندی‌ها  
- مدیریت کاربران و تعیین دسترسی ادمین  
- خروج از حساب کاربری  

---

## 🛒 فروشگاه کاربری
/shop
- مشاهده لیست محصولات  
- مرتب‌سازی بر اساس قیمت  
- مشاهده جزئیات محصول و محصولات مرتبط  
- افزودن به سبد خرید و ذخیره آن  
- ثبت سفارش نهایی  
- ثبت‌نام و ورود کاربر  
- محافظت از صفحات با دسترسی محدود  

---

## 👤 توسعه‌دهنده

ساخته شده توسط **میلاد جلیلوند**  
[GitHub: miladjalilvand](https://github.com/miladjalilvand)


# 🛍️ E-commerce Project

A modular e-commerce system with an admin panel, built using **Laravel 12**, **Tailwind CSS**, **Vite**, and **MySQL**.  
The system includes two main sections:  
- **Admin Panel:** For managing the store, products, categories, and users.  
- **Storefront:** For customers to browse products, add items to the cart, and place orders.

---

## ⚙️ Technologies Used
- Laravel 12  
- Tailwind CSS  
- Vite  
- MySQL  

---

## 🚀 Installation Steps

1. Clone or download the project  
   ```bash
   git clone <repo-link>
   cd <project-folder>
   ```

2. Install backend dependencies  
   ```bash
   composer install
   ```

3. Configure the `.env` file  
   - Set up the MySQL database connection  
   - Run the migrations (if needed)  
     ```bash
     php artisan migrate
     ```

4. Create a storage link  
   ```bash
   php artisan storage:link
   ```

5. Create an admin account  
   - First, register a user through the website  
   - Then manually update the user's role in the database to `admin` to gain admin panel access

---

## 🧩 Modular Structure

Modules are organized separately within the `Modules` folder:

- `Products` → Product management  
- `Categories` → Category management  
- `Carts` → Shopping cart management  
- `Orders` → Order management  

---

## 👨‍💼 Admin Panel  
`/dashboard`
- View and update order statuses  
- Create, edit, delete, and update products and categories  
- Manage users and assign admin access  
- Logout  

---

## 🛒 Storefront  
`/shop`
- Browse product listings  
- Sort products by price  
- View product details and related products  
- Add products to the cart and save them  
- Place final orders  
- Register and log in  
- Protected pages for authorized users only  

---

## 👤 Developer

Developed by **Milad Jalilvand**  
[GitHub: miladjalilvand](https://github.com/miladjalilvand)

---
