# Admin Login System

This admin login system is built following the same architecture as the user sign-in system, providing secure authentication for administrative access.

## Features

- Secure login with email and password
- Session-based authentication
- Input validation and error handling
- Protected admin dashboard
- Secure logout functionality

## Setup Instructions

### 1. Database Setup

Run the SQL script `setup_admin_table.sql` in your MySQL database to create the admin table:

```sql
-- Execute this in your MySQL database
source setup_admin_table.sql;
```

### 2. Default Admin Credentials

After running the setup script, you can log in with:

- **Email:** admin@restaurant.com
- **Password:** admin123

**Important:** Change these default credentials after your first login for security.

### 3. File Structure

```
admin/
├── includes/
│   ├── model.inc.php      # Database queries for admin users
│   ├── contr.inc.php      # Input validation and authentication logic
│   ├── view.inc.php       # Error display functions
│   ├── formhandler.inc.php # Form processing and authentication
│   └── logout.inc.php     # Logout functionality
├── admin-login.php        # Admin login page
├── admin-dashboard.php    # Protected admin dashboard
├── index.html             # Redirects to login
├── setup_admin_table.sql  # Database setup script
└── README.md             # This file
```

### 4. Security Features

- Password hashing using PHP's `password_hash()` function
- Session regeneration for security
- Input sanitization and validation
- Protected routes (dashboard only accessible after login)
- Secure session management

### 5. Customization

To add more admin users or change passwords, you can:

1. Use the existing admin panel (after implementation)
2. Manually insert into the database using hashed passwords
3. Create a password reset system

### 6. Access

- **Login Page:** `/admin/admin-login.php`
- **Dashboard:** `/admin/admin-dashboard.php` (requires authentication)

## Notes

- The system uses the same database connection as the main application
- Sessions are managed through the shared `config_session.inc.php`
- Error handling follows the same pattern as the user login system
- The admin dashboard is a basic template that can be expanded with your existing admin functionality
