# Food Ordering System

A comprehensive food ordering system with user authentication, admin panel, and menu management capabilities.

## 🏗️ Project Structure

```
mo/
├── api/                          # Core API and configuration
│   ├── config_session.inc.php   # Session management and security
│   └── dbh.inc.php             # Database connection handler
├── admin/                       # Admin panel
│   ├── includes/               # Admin backend logic
│   │   ├── model.inc.php      # Admin database operations
│   │   ├── contr.inc.php      # Admin validation logic
│   │   ├── view.inc.php       # Admin UI functions
│   │   ├── formhandler.inc.php # Admin login processing
│   │   └── logout.inc.php     # Admin logout handler
│   ├── admin-login.php         # Admin login page
│   ├── admin-dashboard.php     # Protected admin dashboard
│   ├── index.html              # Admin redirect page
│   ├── setup_admin_table.sql   # Database setup script
│   └── README.md              # Admin setup instructions
├── create account/             # User registration system
│   ├── includes/              # Registration backend logic
│   │   ├── model.inc.php     # User database operations
│   │   ├── contr.inc.php     # Registration validation
│   │   ├── view.inc.php      # Registration UI functions
│   │   └── formhandler.inc.php # Registration processing
│   ├── signup.php            # User registration page
│   └── style.css             # Registration page styles
├── sign in/                   # User authentication system
│   ├── includes/             # Authentication backend logic
│   │   ├── model.inc.php    # User lookup operations
│   │   ├── contr.inc.php    # Login validation
│   │   ├── view.inc.php     # Login UI functions
│   │   └── formhandler.inc.php # Login processing
│   ├── signin.php           # User login page
│   └── style.css            # Login page styles
├── forgot password/          # Password recovery system
│   ├── includes/            # Password recovery logic
│   │   └── update.inc.php  # Password update handler
│   ├── index.html          # Password recovery page
│   └── style.css           # Recovery page styles
├── menu/                    # Main application interface
│   ├── includes/           # Menu system logic
│   │   └── logout.inc.php # User logout handler
│   ├── food.html          # Food menu page
│   ├── Thohoyandou.html   # Location-specific menu
│   ├── Lufule.html        # Location-specific menu
│   ├── Mukula.html        # Location-specific menu
│   ├── script.js          # Menu functionality
│   └── Style.css          # Menu page styles
└── README.md               # This file
```

## 🚀 Features

### User Management

- **User Registration**: Secure account creation with validation
- **User Authentication**: Email/password login with session management
- **Password Recovery**: Secure password reset functionality
- **User Logout**: Proper session destruction

### Admin Panel

- **Secure Admin Login**: Separate authentication system for administrators
- **Protected Dashboard**: Access control for admin functions
- **User Management**: View and manage user accounts
- **Order Management**: Process and track food orders
- **Menu Management**: Update food items and pricing

### Security Features

- **Password Hashing**: Secure password storage using PHP's `password_hash()`
- **Session Security**: Secure session management with regeneration
- **Input Validation**: Comprehensive input sanitization and validation
- **SQL Injection Protection**: Prepared statements for all database queries
- **XSS Protection**: Output escaping for user-generated content

## 🛠️ Technology Stack

- **Backend**: PHP 8.0+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Security**: PDO, prepared statements, password hashing
- **Session Management**: Secure PHP sessions with regeneration

## 📋 Requirements

- **Web Server**: Apache/Nginx with PHP support
- **PHP Version**: 8.0 or higher
- **Database**: MySQL 5.7 or higher
- **Extensions**: PDO, PDO_MySQL, session

## 🔧 Installation

### 1. Database Setup

Create a MySQL database named `food_ordering` and run the setup scripts:

```sql
-- Run this in your MySQL database
source admin/setup_admin_table.sql;
```

### 2. Configuration

Update database credentials in `api/dbh.inc.php` if needed:

```php
$dsn = "mysql:host=localhost;dbname=food_ordering;charset=utf8mb4";
$dbusername = "your_username";
$dbpassword = "your_password";
```

### 3. File Permissions

Ensure proper file permissions for web server access.

## 🔐 Default Credentials

### Admin Access

- **Email**: admin@restaurant.com
- **Password**: admin123

**⚠️ Important**: Change these credentials after first login!

## 📚 Coding Standards

### PHP Standards

- **PSR-12**: Follow PSR-12 coding style guidelines
- **Type Declarations**: Use strict types and return type hints
- **Documentation**: PHPDoc comments for all functions and classes
- **Error Handling**: Proper exception handling and logging
- **Security**: Input validation, output escaping, prepared statements

### File Organization

- **Separation of Concerns**: Model-View-Controller (MVC) pattern
- **Include Files**: Use `.inc.php` extension for included files
- **Directory Structure**: Logical grouping by functionality
- **Naming Conventions**: Descriptive names for files and functions

### Security Practices

- **Input Validation**: Validate all user inputs
- **Output Escaping**: Escape all user-generated content
- **Session Security**: Secure session configuration
- **Database Security**: Use prepared statements exclusively
- **Error Handling**: Log errors, don't expose system details

## 🔒 Security Features

### Session Management

- Secure cookie settings (HttpOnly, Secure, SameSite)
- Session regeneration every 30 minutes
- Secure session ID generation
- Proper session destruction on logout

### Database Security

- PDO with prepared statements
- Input validation and sanitization
- Error logging without information disclosure
- Secure password hashing

### Input Validation

- Email format validation
- Required field validation
- XSS prevention through output escaping
- CSRF protection through session validation

## 🚨 Error Handling

### User-Friendly Messages

- Clear error messages for validation failures
- Success confirmations for completed actions
- Redirect-based error handling
- No system information exposure

### Logging

- Error logging for debugging
- Security event logging
- Database query failure logging
- User action logging (admin actions)

## 📱 User Experience

### Responsive Design

- Mobile-friendly interface
- Consistent styling across pages
- Intuitive navigation
- Clear feedback for user actions

### Form Handling

- Client-side validation
- Server-side validation
- Form data persistence on errors
- Success confirmations

## 🔄 Maintenance

### Regular Tasks

- Monitor error logs
- Update security patches
- Database backup and optimization
- Session cleanup

### Performance

- Database query optimization
- Session management efficiency
- File caching strategies
- Resource optimization

## 📞 Support

For technical support or questions about the system:

- Review the code documentation
- Check error logs for issues
- Ensure all requirements are met
- Verify database connectivity

## 📄 License

This project is proprietary software. All rights reserved.

---

**Last Updated**: December 2024
**Version**: 1.0.0
**Maintainer**: Development Team
