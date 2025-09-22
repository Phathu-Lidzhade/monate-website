<?php
// admin/includes/view.php
if (!empty($message)) {
    echo '<div class="admin-message" style="color:red;padding:10px 0;">' . htmlspecialchars($message) . '</div>';
}
