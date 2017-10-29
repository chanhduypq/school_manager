<?php
$id = $_GET['id'];
$tableName = $_GET['table_name'];
if (!ctype_digit($id)) {
    exit;
}

if ($tableName == 'class') {
    include '../models/class.php';
    $model=new ModelClass();
    $model->delete($id);
}
else{
    include '../models/pupil.php';
    $model=new ModelPupil();
    $model->delete($id);
}


?>