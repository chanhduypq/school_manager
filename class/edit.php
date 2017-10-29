<?php 
include '../models/class.php';
/**
 * đây là đoạn code xử lý khi user vừa submit
 * lưu vào database, sau đó quay lại trang index
 */
if (count($_POST) > 0) {
    $inputName = $_POST['name'];
    $inputName = str_replace("'", "\'", $inputName);
    $inputName = htmlentities($inputName);
    $id = $_POST['id'];
    $model=new ModelClass();
    if ($model->exist($inputName, $id)==FALSE) {
        $model->update($inputName, $id);
        header('Location:index.php');
        exit;
    } else {
        $error = true;
    }
} else {
    $id = $_GET['id'];
    if (!ctype_digit($id)) {
        header('Location:index.php');
        exit;
    }
    $model=new ModelClass();
    $row=$model->get($id);
    $name = $row['name'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Lớp học</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8;" />
        <link href="../public/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../public/css/menu.css" rel="stylesheet" type="text/css"/>
        <script src="../public/js/jquery-2.0.3.js"></script>
    </head>
    <body>
        <?php 
        include_once  '../menu.php';
        ?>
        <div class="right toolbar">
            <input onclick="window.location='index.php';" type="button" value="Quay lại" class="button">
        </div>
        <form action="edit.php" method="post" onsubmit="return validate();">
            <table width="40%"> 
                <tbody>
                        

                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            <label for="name">Tên lớp:<span style="color:red;"> *</span></label>
                        </td>
                        <td nowrap="nowrap" style="width: 20%;">
                            <input type="text" name="name" id="name" value="<?php if(isset($error)) echo $_POST['name']; else echo $name; ?>">
                            <?php
                            if(isset($error)){?>
                            <div style="color: red;">
                                Đã tồn tại lớp học mang tên [<?php echo $_POST['name'];?>].
                            </div>
                            <?php 
                            }
                            ?>
                        </td>

                    </tr>
                    
                    <tr>
                        <td colspan="2" align="center" style="width: 40%;">
                            <input type="submit" value="Sửa"/>
                        </td>
                    </tr>

                </tbody>
            </table>

            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        </form>

        <script type="text/javascript">

            function validate() {

                name = $('#name').val();
                if ($.trim(name) == '') {
                    alert("Vui lòng nhập tên lớp");
                    $('#name').focus();
                    return false;
                }
                return true;
            }
            
            jQuery(function ($){
               $("#name").focus(); 
            });
        </script>
    </body>
</html>
