<?php
if (!empty($message)) {
    // escape output
    echo '<p style="color:red;">' . htmlspecialchars($message) . '</p>';
}
?>
