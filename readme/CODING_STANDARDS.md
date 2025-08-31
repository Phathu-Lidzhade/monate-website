# Coding Standards Guide

This document outlines the coding standards and best practices for the Food Ordering System project.

## 📋 PHP Coding Standards

### 1. File Structure and Naming

#### File Extensions

- **PHP Files**: Use `.php` for main files, `.inc.php` for included files
- **HTML Files**: Use `.html` extension
- **CSS Files**: Use `.css` extension
- **JavaScript Files**: Use `.js` extension

#### Naming Conventions

- **Files**: Use lowercase with hyphens for spaces (e.g., `admin-login.php`)
- **Functions**: Use snake_case (e.g., `get_user()`, `is_email_valid()`)
- **Variables**: Use snake_case (e.g., `$user_name`, `$login_pwd`)
- **Constants**: Use UPPER_SNAKE_CASE (e.g., `MAX_LOGIN_ATTEMPTS`)

### 2. Code Formatting

#### Indentation

- Use **4 spaces** for indentation (no tabs)
- Align related code blocks consistently

#### Line Length

- Keep lines under **120 characters** when possible
- Break long lines at logical points

#### Spacing

- **Operators**: Space around operators (`$a + $b`)
- **Commas**: Space after commas in arrays (`['a', 'b', 'c']`)
- **Parentheses**: No space inside parentheses (`function($param)`)
- **Braces**: Space before opening brace (`if ($condition) {`)

### 3. PHP Syntax Standards

#### Declarations

```php
<?php
/**
 * File description
 *
 * @package FoodOrdering
 * @version 1.0.0
 */

declare(strict_types=1);

// Use proper return types
function get_user(object $pdo, string $email): array|false
{
    // Function implementation
}
```

#### Function Definitions

```php
/**
 * Function description
 *
 * @param object $pdo Database connection
 * @param string $email User email address
 * @return array|false User data or false if not found
 */
function get_user(object $pdo, string $email): array|false
{
    // Implementation
}
```

#### Variable Declarations

```php
// Use null coalescing operator for POST data
$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';

// Use proper type hints
$errors = [];
$userData = [];
```

### 4. Security Standards

#### Input Validation

```php
// Always validate and sanitize input
if (empty($email) || empty($password)) {
    $errors["empty_input"] = "Fill in all fields";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["invalid_email"] = "Invalid email format";
}
```

#### Output Escaping

```php
// Always escape user-generated content
echo '<p>' . htmlspecialchars($userName) . '</p>';
echo '<span>' . htmlspecialchars($userEmail) . '</span>';
```

#### Database Security

```php
// Use prepared statements exclusively
$query = "SELECT * FROM users WHERE email = :email;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":email", $email);
$stmt->execute();
```

### 5. Error Handling

#### Exception Handling

```php
try {
    // Database operations
    $stmt->execute();
} catch (PDOException $e) {
    // Log error for debugging
    error_log("Database operation failed: " . $e->getMessage());

    // Show user-friendly message
    die("Operation failed. Please try again later.");
}
```

#### User Feedback

```php
if ($errors) {
    $_SESSION["errors_signup"] = $errors;
    header("Location: ../signup.php");
    die();
}
```

### 6. Session Management

#### Session Security

```php
// Use shared session configuration
require_once "../../api/config_session.inc.php";

// Set session variables securely
$_SESSION["user_id"] = $result["id"];
$_SESSION["user_name"] = htmlspecialchars($result["name"]);
```

#### Session Cleanup

```php
// Always clean up resources
$pdo = null;
$stmt = null;

// Redirect after processing
header("Location: ../dashboard.php");
die();
```

## 🏗️ Architecture Standards

### 1. MVC Pattern

#### Model (Database Operations)

```php
// admin/includes/model.inc.php
function get_admin(object $pdo, string $email): array|false
{
    $query = "SELECT * FROM admins WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
```

#### Controller (Business Logic)

```php
// admin/includes/contr.inc.php
function is_input_empty(string $email, string $login_pwd): bool
{
    return empty($email) || empty($login_pwd);
}

function is_email_invalid(string $email): bool
{
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}
```

#### View (Presentation Logic)

```php
// admin/includes/view.inc.php
function check_login_errors(): void
{
    if (isset($_SESSION["errors_admin"])) {
        $errors = $_SESSION["errors_admin"];

        foreach ($errors as $error) {
            echo '<p class="form-error">' . htmlspecialchars($error) . '</p>';
        }

        unset($_SESSION["errors_admin"]);
    }
}
```

### 2. File Organization

#### Directory Structure

```
admin/
├── includes/           # Backend logic
│   ├── model.inc.php  # Database operations
│   ├── contr.inc.php  # Business logic
│   ├── view.inc.php   # UI functions
│   └── formhandler.inc.php # Form processing
├── admin-login.php    # Main page
└── style.css          # Styling
```

#### Include Files

```php
// Always use require_once for critical files
require_once "../../api/dbh.inc.php";
require_once "model.inc.php";
require_once "view.inc.php";
require_once "contr.inc.php";
```

## 🔒 Security Standards

### 1. Authentication

#### Password Handling

```php
// Hash passwords before storage
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Verify passwords securely
if (!password_verify($inputPassword, $storedHash)) {
    $errors["invalid_password"] = "Incorrect password";
}
```

#### Session Security

```php
// Use secure session configuration
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
```

### 2. Data Validation

#### Input Sanitization

```php
// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["invalid_email"] = "Invalid email format";
}

// Check for empty fields
if (empty($username) || empty($email)) {
    $errors["empty_fields"] = "All fields are required";
}
```

#### SQL Injection Prevention

```php
// Use prepared statements exclusively
$query = "INSERT INTO users (username, email) VALUES (:username, :email);";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":username", $username);
$stmt->bindParam(":email", $email);
$stmt->execute();
```

## 📱 Frontend Standards

### 1. HTML Structure

#### Semantic HTML

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page Title</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <header>
      <nav>
        <!-- Navigation content -->
      </nav>
    </header>

    <main>
      <!-- Main content -->
    </main>

    <footer>
      <!-- Footer content -->
    </footer>
  </body>
</html>
```

#### Form Structure

```html
<form class="form" action="includes/formhandler.inc.php" method="POST">
  <input name="email" type="email" placeholder="Email Address" required />
  <input name="password" type="password" placeholder="Password" required />

  <button type="submit" class="btn">Submit</button>
</form>
```

### 2. CSS Standards

#### Naming Conventions

```css
/* Use BEM methodology */
.form-section {
}
.form-section__title {
}
.form-section__input {
}
.form-section__button {
}
.form-section__button--primary {
}
```

#### Organization

```css
/* Group related styles together */
/* Layout */
.container {
}
.sidebar {
}
.content {
}

/* Forms */
.form {
}
.form__input {
}
.form__button {
}

/* Utilities */
.text-center {
}
.hidden {
}
```

## 🧪 Testing and Quality

### 1. Code Review Checklist

- [ ] Follows PSR-12 coding standards
- [ ] Includes proper PHPDoc comments
- [ ] Uses strict types declaration
- [ ] Implements proper error handling
- [ ] Validates all user inputs
- [ ] Escapes all user outputs
- [ ] Uses prepared statements for database queries
- [ ] Implements proper session management
- [ ] Follows MVC architecture pattern
- [ ] Includes proper security measures

### 2. Common Issues to Avoid

#### Security Issues

- ❌ Direct output of user input without escaping
- ❌ SQL queries without prepared statements
- ❌ Weak password hashing
- ❌ Insecure session configuration
- ❌ Missing input validation

#### Code Quality Issues

- ❌ Inconsistent indentation
- ❌ Missing return type hints
- ❌ Poor error handling
- ❌ Inconsistent naming conventions
- ❌ Missing documentation

## 📚 Documentation Standards

### 1. File Headers

```php
<?php
/**
 * File Name
 *
 * Brief description of what this file does
 *
 * @package FoodOrdering
 * @category Authentication
 * @version 1.0.0
 * @author Developer Name
 * @since 2024-01-01
 */
```

### 2. Function Documentation

```php
/**
 * Get user information by email address
 *
 * Retrieves user data from the database based on the provided email.
 * Returns false if no user is found with the given email.
 *
 * @param object $pdo Database connection object
 * @param string $email User's email address
 * @return array|false User data array or false if not found
 * @throws PDOException If database query fails
 */
function get_user(object $pdo, string $email): array|false
{
    // Implementation
}
```

### 3. Inline Comments

```php
// Validate required fields
if (empty($username) || empty($email)) {
    $errors["empty_fields"] = "All fields are required";
}

// Hash password for secure storage
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Create secure session
$newSessionId = session_create_id();
$sessionId = $newSessionId . "_" . $result["id"];
session_id($sessionId);
```

## 🔄 Maintenance and Updates

### 1. Regular Tasks

- Review and update security measures
- Update dependencies and libraries
- Monitor error logs and performance
- Backup database and files regularly
- Review and refactor code as needed

### 2. Version Control

- Use descriptive commit messages
- Review changes before merging
- Maintain clean git history
- Tag releases appropriately
- Document breaking changes

---

**Remember**: These standards are designed to ensure code quality, security, and maintainability. Always prioritize security and user experience when making decisions about code implementation.
