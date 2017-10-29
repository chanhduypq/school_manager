<?php 
include '../models/class.php';

/**
 * đây là đoạn code xử lý khi user vừa submit
 * lưu vào database, sau đó quay lại trang index
 */
if (count($_POST) > 0) {
    $name = $_POST['name'];
    $name = str_replace("'", "\'", $name);
    $name= htmlentities($name);
    $model=new ModelClass();
    if($model->exist($name)==FALSE){
        $model->insert($name);
        header('Location:index.php');
        exit;
    }
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
        <form action="add.php" method="post">
            <table width="40%"> 
                <tbody>
                      

                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            <label for="name">Tên lớp:<span style="color:red;"> *</span></label>
                        </td>
                        <td nowrap="nowrap" style="width: 20%;">
                            <input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) echo $_POST['name'];?>">
                            <?php
                            if(isset($_POST['name'])){?>
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
                            <input type="submit" value="Thêm mới"/>
                        </td>
                    </tr>

                </tbody>
            </table>
        </form>
        

        <script type="text/javascript">

            jQuery(function ($){
               $('form').submit(function (){
                    name = $('#name').val();
                    if ($.trim(name) == '') {
                        alert("Vui lòng nhập tên lớp");
                        $('#name').focus();
                        return false;
                    }

                    return true;
               });               
               
               $("#name").focus();
            });
        </script>
    </body>
</html>
