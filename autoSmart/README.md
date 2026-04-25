# AutoSmart — Inventory Management System
Built with **CodeIgniter 3** · Bootstrap 5 · MySQL

---

## 🚀 Quick Setup (5 steps)

### 1. Download CodeIgniter 3 system folder
Visit https://codeigniter.com/download and download **CodeIgniter 3.1.13**.
Extract the ZIP and copy the `system/` folder into your `autoSmart/` directory.

Your folder structure should look like:
```
autoSmart/
├── system/            ← paste CI3 system folder here
├── application/
├── assets/
├── index.php
├── .htaccess
└── autoSmart.sql
```

### 2. Create the database
Open **phpMyAdmin** or run via MySQL CLI:
```sql
mysql -u root -p < autoSmart.sql
```
This creates the `autosmart` database with all tables and sample data.

### 3. Configure database connection
Edit `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',       // ← your MySQL username
    'password' => '',           // ← your MySQL password
    'database' => 'autosmart',
    ...
);
```

### 4. Configure base URL
Edit `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/autoSmart/';
// Change if hosted differently, e.g.:
// $config['base_url'] = 'https://yourdomain.com/';
```

### 5. Enable mod_rewrite (Apache)
Make sure `mod_rewrite` is enabled. In XAMPP/WAMP:
- XAMPP: Uncomment `LoadModule rewrite_module` in `httpd.conf`
- Enable `AllowOverride All` for your htdocs directory

Place the project in: `htdocs/autoSmart/` (XAMPP) or `www/autoSmart/` (WAMP)

---

## 🔑 Default Login
| Field    | Value             |
|----------|-------------------|
| Email    | admin@gmail.com   |
| Password | admin             |
| Role     | Admin (master)    |

---

## 👥 User Roles
| Role   | DB Value | Access                              |
|--------|----------|-------------------------------------|
| Admin  | `master` | Full access including user management |
| Staff  | `user`   | All inventory features, no user mgmt |

---

## 📦 Features
- ✅ Role-based login (Admin / Staff)
- ✅ Dashboard with stats & low stock alerts
- ✅ Product management with opening stock
- ✅ Category, UOM, Supplier, Customer masters
- ✅ Purchase invoices with multi-product entry
- ✅ Sales orders with live stock availability
- ✅ Stock overview with in/out ledger per product
- ✅ Low stock highlighting & alerts
- ✅ Soft delete on all records
- ✅ CSRF protection on all forms
- ✅ XSS-safe output (htmlspecialchars everywhere)

---

## 🐛 Bugs Fixed (from original project)
1. **`session_start()` removed** — was conflicting with CI's session library
2. **Environment** — now properly reads `CI_ENV` server variable
3. **`.htaccess`** — cleaned up, assets path excluded from routing
4. **`composer.json`** — PHP version requirement corrected
5. **Timezone** — kept in `index.php` but documented for easy relocation

---

## 📁 Project Structure
```
application/
├── config/
│   ├── config.php       ← base URL, session, CSRF settings
│   ├── database.php     ← DB credentials
│   ├── routes.php       ← URL routing
│   └── autoload.php     ← auto-loaded libraries
├── core/
│   └── MY_Controller.php ← base controller with auth & role check
├── controllers/
│   ├── Auth.php         ← login / logout
│   ├── Dashboard.php
│   ├── Category.php
│   ├── Uom.php
│   ├── Supplier.php
│   ├── Product.php
│   ├── Purchase.php
│   ├── Inventory.php    ← sales orders
│   ├── Stock.php
│   ├── Customers.php
│   └── Users.php        ← admin only
├── models/
│   └── [matching models for each controller]
└── views/
    ├── layouts/main.php ← Bootstrap sidebar layout
    ├── auth/login.php
    ├── dashboard/
    ├── category/
    ├── uom/
    ├── supplier/
    ├── product/
    ├── purchase/
    ├── inventory/
    ├── stock/
    ├── customers/
    └── users/
```

---

## ⚙️ Environment Settings
Set `CI_ENV` on your server for different environments:

**Development (show errors):**
```apache
# Apache .htaccess or VirtualHost
SetEnv CI_ENV development
```

**Production (hide errors):**
```apache
SetEnv CI_ENV production
```

---

## 🔒 Security Notes
- Passwords stored as SHA1 (matches original DB schema). Consider migrating to `password_hash()` for new projects.
- CSRF protection is enabled on all forms.
- All user input is sanitized via CI's `$this->input->post('field', TRUE)`.
- `application/` folder is protected with `Deny from all` `.htaccess`.

---

*AutoSmart © 2025 — Built on CodeIgniter 3*
