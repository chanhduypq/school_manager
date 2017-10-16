<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Học sinh</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8;" />
        <link href="../public/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../public/css/menu.css" rel="stylesheet" type="text/css"/>   
    </head>
    <body>
        <?php 
        include_once  '../menu.php';
        ?>
        Nội dung hướng dẫn sử dụng hệ thống tại đây
    </body>
</html>
