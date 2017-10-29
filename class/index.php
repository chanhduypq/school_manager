<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:../login.php');
    exit;
}
include '../define.php';
include '../models/class.php';
if (isset($_GET['page']) && ctype_digit($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}


if(isset($_POST['q'])){
    $value=$_POST['q'];
    $q= str_replace("'", "\'", $_POST['q']);
    $where="name like '%$q%'";
    $textUrl="&old_q=".$_POST['q'];
    $page = 1;
}
else if(isset($_GET['old_q'])){
    $value=$_GET['old_q'];
    $q= str_replace("'", "\'", $_GET['old_q']);
    $where="name like '%$q%'";
    $textUrl="&old_q=".$_GET['old_q'];
}
else{
    $where=" 1=1 ";
    $value="";
    $textUrl="";
}
            
$offset = ($page - 1) * NUMBER_ROW_PERPAGE;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Lớp học</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8;" />
        <link href="../public/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../public/css/menu.css" rel="stylesheet" type="text/css"/>
        <link href="../public/css/paging.css" rel="stylesheet" type="text/css"/>
        <script src="../public/js/jquery-2.0.3.js"></script>
        <script type="text/javascript">
            jQuery(function ($) {
                $("img.delete").click(function () {
                    $.ajax({
                        url: '../common/delete.php?id=' + $(this).attr('id') + '&table_name=class'
                    });
                    $(this).parent().parent().remove();
                });

                $("img.toggle").click(function () {
                    if ($(this).attr('src').indexOf('down') != -1) {
                        src = $(this).attr('src');
                        src = src.replace('down', 'up');
                    } else {
                        src = src.replace('up', 'down');
                    }

                    $(this).attr('src', src);

                    node = $(this);
                    $.ajax({
                        url: '../load_pupil.php?class_id=' + $(this).attr('id'),
                        success: function (data) {
                            $(node).parent().parent().find('div.list_pupil').html(data).slideToggle();
                        }

                    });

                });
            });
        </script>
    </head>
    <body>
        <?php
        include_once '../menu.php';
        ?>

        <div class="right toolbar">
            <input onclick="window.location = 'add.php';" type="button" value="Thêm mới" class="button">
        </div>
        
        <div style="clear: both;"></div>
        <div>
            <form method="post" action="index.php">
                <input type="text" value="<?php echo $value;?>" name="q" placeholder="Nhập tên lớp để tìm kiếm" style="width: 200px;">
            </form>
        </div>

        <table class="list" style="width: 60%">
            <tr>
                <th style="width: 40%;">
                    tên lớp
                </th>
                <th style="width: 20%;">&nbsp;</th>
            </tr>
            <?php 
            $model=new ModelClass();
            
            $countClass =$model->getClassCount($where);
            $classes=$model->getClasses($where, $offset, NUMBER_ROW_PERPAGE);

            foreach ($classes as $row){
                ?>
                <tr>
                    <td>
                        <?php
                        if ($row['count_pupil'] > 0) {
                            echo '<div style="float:left;width: 50%;">' . $row['name'] . ' (' . $row['count_pupil'] . ' học sinh)</div>';
                            ?> 
                            <div style="float: right;width: 20%;" title="nhấn vào đây để xem danh sách học sinh">
                                <img id="<?php echo $row['id']; ?>" class="toggle" src="../public/images/down.png" style="width: 32px;height: 32px;cursor: pointer;"/>
                            </div>
                            <div style="clear: both;"></div>
                            <div class="list_pupil" style="display: none;background-color: blue;color: white;width: 80%;"></div>
                            <?php
                        } else {
                            echo '<div style="width: 50%;">' . $row['name'] . ' (chưa có học sinh nào)</div>';
                        }
                        ?>

                    </td>
                    <td style="text-align: center;">
                        <?php
                        if ($row['count_pupil'] == 0) {
                            ?>                            
                            <img id="<?php echo $row['id']; ?>" class="delete" style="margin-right: 20px;" title="Nhấn vào đây để xóa" src="../public/images/delete-icon.png"/>

                            <?php
                        }
                        ?>                       

                        <img onclick="window.location = 'edit.php?id=<?php echo $row['id']; ?>';" title="Nhấn vào đây để sửa" src="../public/images/ico_edit.png"/>

                    </td>
                </tr>
                <?php
            }
            if ($countClass > 0) {
                $numberPage = ceil($countClass / NUMBER_ROW_PERPAGE);

                $rangeCount = 3;

                $rangeNumber = ceil($numberPage / $rangeCount);
                $range = ceil($page / $rangeCount);
                $start = $range * $rangeCount - ($rangeCount - 1);

                if ($page == 1) {
                    $hrefPrev = "#";
                    $hrefFirst = "#";
                    $classPrevFirst = "selected";
                } else {
                    $hrefFirst = "index.php?page=1$textUrl";
                    $hrefPrev = "index.php?page=" . ($page - 1).$textUrl;
                    $classPrevFirst = "not_selected";
                }

                if ($page == $numberPage) {
                    $hrefNext = "#";
                    $hrefLast = "#";
                    $classNextLast = "selected";
                } else {
                    $hrefLast = "index.php?page=$numberPage".$textUrl;
                    $hrefNext = "index.php?page=" . ($page + 1).$textUrl;
                    $classNextLast = "not_selected";
                }
                ?>
                <tr style="height: 50px;background-color: #c1976c;">
                    <td colspan="3" style="text-align: center;" class="pagination">

                        <span class="<?php echo $classPrevFirst; ?>" onclick="window.location = '<?php echo $hrefFirst; ?>';">
                            First
                        </span>
                        <span class="<?php echo $classPrevFirst; ?>" onclick="window.location = '<?php echo $hrefPrev; ?>';">
                            Previous
                        </span>

                        <?php
                        for ($i = 1; $i <= 3 && $start <= $numberPage; $i++) {
                            if ($page == $start) {
                                $href = "#";
                                $class = 'selected';
                            } else {
                                $href = "index.php?page=$start".$textUrl;
                                $class = 'not_selected';
                            }
                            ?>
                            <span class="<?php echo $class; ?>" onclick="window.location = '<?php echo $href; ?>';">
                                <?php echo $start; ?>
                            </span>
                            <?php
                            $start++;
                        }
                        ?>

                        <span class="<?php echo $classNextLast; ?>" onclick="window.location = '<?php echo $hrefNext; ?>';">
                            Next
                        </span>
                        <span class="<?php echo $classNextLast; ?>" onclick="window.location = '<?php echo $hrefLast; ?>';">
                            Last
                        </span>

                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
