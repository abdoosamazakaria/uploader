<?php
session_start();
session_destroy();
redirect('admin_login.php');
?>