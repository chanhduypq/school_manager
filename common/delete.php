<?php 
$conn = mysqli_connect("localhost", "root", "", "school_manager") or die();
mysqli_query($conn, "set names 'utf8'");
$id = $_GET['id'];
$tableName = $_GET['table_name'];
if (!ctype_digit($id)) {    
    exit;
}
$sql="delete from $tableName where id=$id";
mysqli_query($conn, $sql);
?>