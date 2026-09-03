<?php
// Start session so we can log in the user after registration
session_start();

// Include DB connection
include("../API/db.php");

// Initialize message
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $day = $_POST["day"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $dob = "$year-$month-$day"; // format YYYY-MM-DD
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Password check
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into database
        $sql = "INSERT INTO users (username, email, mobile, dob, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $email, $mobile, $dob, $hashedPassword);

        if ($stmt->execute()) {
            // ✅ Account created successfully → log in user immediately
            $userId = $stmt->insert_id;

            $_SESSION["user_id"] = $userId;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = "user";

            // Redirect to homepage
            header("Location: ../HOME/index.php");
            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="desktop">
        
        <div class="image-side">
            <img class="bacc" src="img/bacc 1.png" alt="Background Image">
        </div>

        <div class="container">
            <img class="logo" src="img/logo 1.png" alt="Logo">

            <h1>Create Account</h1>

           <!-- Show message -->
            <?php if (!empty($message)) { ?>
                <p style="color:red;"><?php echo $message; ?></p>
            <?php } ?>

            <form class="form" method="POST" action="">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="tel" name="mobile" placeholder="Mobile Number" required>
                
                <label class="dob-label">Date of Birth</label>
                <div class="dob">
                    <input type="number" name="day" placeholder="Day" min="1" max="31" required>
                    <input type="number" name="month" placeholder="Month" min="1" max="12" required>
                    <input type="number" name="year" placeholder="Year" min="1900" max="2100" required>
                </div>

                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>

                <label class="terms">
                    <input type="checkbox" required>
                    By creating an account, I agree to the 
                    <a href="#">Terms of use</a> and understand that my information will be used as described on this page.
                </label>

                <button type="submit" class="btn">Create Account</button>
            </form>

            <p class="signin-text">
                Already have an account?
                <a href="../Sign in/index.php" class="signin-link">Sign in</a>
            </p>
        </div>
    </div>
</body>
</html>
