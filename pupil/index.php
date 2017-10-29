<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:../login.php');
    exit;
}
include '../define.php';
include '../models/pupil.php';
if (isset($_GET['page']) && ctype_digit($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}


if(isset($_POST['q'])){
    $value=$_POST['q'];
    $q= str_replace("'", "\'", $_POST['q']);
    $where="full_name like '%$q%'";
    $textUrl="&old_q=".$_POST['q'];
    $page = 1;
}
else if(isset($_GET['old_q'])){
    $value=$_GET['old_q'];
    $q= str_replace("'", "\'", $_GET['old_q']);
    $where="full_name like '%$q%'";
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
        <title>Học sinh</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8;" />
        <link href="../public/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../public/css/menu.css" rel="stylesheet" type="text/css"/> 
        <link href="../public/css/paging.css" rel="stylesheet" type="text/css"/>
        <script src="../public/js/jquery-2.0.3.js"></script>
        <script type="text/javascript">
            jQuery(function($){
                $("img.delete").click(function() {
                    $.ajax({
                       url:'../common/delete.php?id='+$(this).attr('id')+'&table_name=pupil'
                    });
                    $(this).parent().parent().remove();
                });
            });
        </script>
    </head>
    <body>
        <?php 
        include_once  '../menu.php';
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
        <table class="list" style="width: 100%;">

            <tr>
                <th style="width: 10%;">
                    lớp
                </th>
                <th style="width: 10%;">
                    họ tên
                </th>
                <th style="width: 10%;">
                    ngày sinh
                </th>
                <th style="width: 10%;">
                    giới tính
                </th>
                <th style="width: 10%;">
                    Tình trạng hôn nhân
                </th>
                <th style="width: 10%;">
                    avatar
                </th>
                <th style="width: 20%;">
                    vài thông tin khác                    
                </th>
                <th style="width: 20%;">&nbsp;</th>
            </tr>
            <?php 
            $model=new ModelPupil();
            
            $countPupil =$model->getPupilCount($where);
            $pupils=$model->getPupils($where, $offset, NUMBER_ROW_PERPAGE);
            foreach ($pupils as $row){
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td>
                        <?php
                        echo $row['birthday'];
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($row['sex'] == '1') {
                            echo 'nam';
                        } else {
                            echo 'nữ';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($row['married'] == '1') {
                            echo 'đã kết hôn';
                        } else {
                            echo 'độc thân';
                        }
                        ?>
                    </td>
                    <td>
                        <?php 
                        if (trim($row['avatar']) != '' && file_exists("../public/images/database/avatar/" . trim($row['avatar']))) {
                                ?>
                            <img src="../public/images/database/avatar/<?php echo $row['avatar'];?>" style="width: 50px;height: 50px;"/>
                        <?php 
                        } 
                        ?>
                    </td>
                    <td>
                        <?php echo $row['introduce']; ?>
                        <br>
                        <?php 
                        if (trim($row['profile']) != '' && file_exists("../public/images/database/profile/" . trim($row['profile']))) {
                                ?>
                            <a href="download.php?file_name=<?php echo $row['profile']; ?>">
                                download
                            </a>
                        <?php 
                        } 
                        ?>
                    </td>
                    <td style="text-align: center;">
                        
                        <img id="<?php echo $row['id']; ?>" class="delete" style="margin-right: 20px;" title="Nhấn vào đây để xóa" src="../public/images/delete-icon.png"/>

                        <img onclick="window.location='edit.php?id=<?php echo $row['id']; ?>';" title="Nhấn vào đây để sửa" src="../public/images/ico_edit.png"/>
                        
                    </td>
                </tr>
                <?php
            }
            if ($countPupil > 0) {
                $numberPage = ceil($countPupil / NUMBER_ROW_PERPAGE);

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
                    <td colspan="8" style="text-align: center;" class="pagination">

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
