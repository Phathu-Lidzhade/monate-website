<?php
// view: display the account text (no DB, no redirects, no logic)
if (!empty($username)) {
    echo 'Hi, ' . htmlspecialchars($username);
} else {
    echo 'ACCOUNT';
}
?>
