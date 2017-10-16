<?php 
$conn = mysqli_connect("localhost", "root", "", "school_manager") or die();
mysqli_query($conn, "set names 'utf8'");
$id = $_GET['id'];
if (!ctype_digit($id)) {
    header('Location:index.php');
    exit;
}
$sql="delete from pupil where id=".$id;
mysqli_query($conn, $sql);
header('Location:index.php');
?>