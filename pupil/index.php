<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:../login.php');
    exit;
}
include '../define.php';
if (isset($_GET['page']) && ctype_digit($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
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
            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die();
            mysqli_query($conn, "set names 'utf8'");
            $countPupil = getClassPupil($conn);
            $result = mysqli_query($conn, "select * from pupil_full order by class_id ASC limit $offset," . NUMBER_ROW_PERPAGE);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td>
                        <?php
                        echo convertToVNDate($row['birthday']);
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
                    $hrefFirst = "index.php?page=1";
                    $hrefPrev = "index.php?page=" . ($page - 1);
                    $classPrevFirst = "not_selected";
                }

                if ($page == $numberPage) {
                    $hrefNext = "#";
                    $hrefLast = "#";
                    $classNextLast = "selected";
                } else {
                    $hrefLast = "index.php?page=$numberPage";
                    $hrefNext = "index.php?page=" . ($page + 1);
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
                                $href = "index.php?page=$start";
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

<?php

function convertToVNDate($dateTime) {
    $temp = explode(' ', $dateTime);
    $dateEn = $temp[0];
    $temp = explode('-', $dateEn);
    $dateVn = $temp[2] . '/' . $temp[1] . '/' . $temp[0];
    return $dateVn;
}

function getClassPupil($conn) {
    $result = mysqli_query($conn, "SELECT count(*) as count FROM pupil");
    if ($row = mysqli_fetch_array($result)) {
        return $row['count'];
    }
    return 0;
}
?>