<?php
// view: only responsible for displaying $message (no DB logic)

// If $message is set by control.php, display it in the page
if (!empty($message)) {
    echo '<p style="color:red;">' . htmlspecialchars($message) . '</p>';
}
?>
