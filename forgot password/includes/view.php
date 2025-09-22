<?php
// sign in/includes/view.php (view)
// Only responsible for rendering messages (no DB logic)

if (!empty($message)) {
    echo '<p style="color:red;">' . htmlspecialchars($message) . '</p>';
}
?>
