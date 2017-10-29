<?php 
include '../models/class.php';
$modelClass = new ModelClass();
/**
 * đây là đoạn code xử lý khi user vừa submit
 * lưu vào database, sau đó quay lại trang index
 */
if (count($_POST) > 0) {
    include '../models/pupil.php';
    
    $class_id = $_POST['class_id'];
    $full_name = $_POST['full_name'];
    $full_name = str_replace("'", "\'", $full_name);
    $full_name= htmlentities($full_name);
    $birthday = $_POST['birthday'];
    $birthday = convertToENDate($birthday);
    
    if (isset($_POST['married']) && $_POST['married'] == '1') {
        $married = '1';
    } else {
        $married = '0';
    }
    
    $introduce=$_POST['introduce'];
    $introduce = str_replace("'", "\'", $introduce);
    $introduce= htmlentities($introduce);
    
    if (isset($_POST['so_thich'])) {
        $so_thich = $_POST['so_thich'];        
    }
    else{
        $so_thich=array();
    }
    
    $sex = $_POST['sex'];
    
    $model=new ModelPupil();
    $model->insert($class_id, $full_name, $birthday, $married, $introduce, $sex, $so_thich);
    header('Location:index.php');
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
        <script src="../public/js/jquery-2.0.3.js"></script>
        
        <link rel="stylesheet" href="../public/jquery-ui-1.10.3/themes/smoothness/jquery-ui.css" type="text/css"/>
        <script type="text/javascript" src="../public/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
        <script src="../public/jquery-ui-1.10.3/ui/i18n/jquery.ui.datepicker-vi.js"></script>
    </head>
    <body>
        <?php 
        include_once  '../menu.php';
        ?>
        <div class="right toolbar">
            <input onclick="window.location='index.php';" type="button" value="Quay lại" class="button">
        </div>
        <form action="add.php" method="post" onsubmit="return validate();" enctype="multipart/form-data">
            <table width="40%"> 
                <tbody>
                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            <label for="class_id">Lớp:<span style="color:red;"> *</span></label>
                        </td>
                        <td nowrap="nowrap" style="width: 20%;">
                            <select name="class_id" id="class_id">
                                <option value="">----Chọn lớp----</option>
                                <?php
                                $classes=$modelClass->getClasses("1=1");
                                foreach ($classes as $row){
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>					                 
                        </td>

                    </tr>     

                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            <label for="full_name">Họ và tên:<span style="color:red;"> *</span></label>
                        </td>
                        <td nowrap="nowrap">
                            <input type="text" name="full_name" id="full_name">					                
                        </td>

                    </tr>
                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            <label for="birthday">Ngày sinh:<span style="color:red;"> *</span></label>
                        </td>
                        <td nowrap="nowrap">
                            <input style="background-color: #eeeeee;cursor: not-allowed;" readonly="readonly" type="text" name="birthday" id="birthday">
                        </td>
                    </tr>
                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            <label>Giới tính:<span style="color:red;"> *</span></label>
                        </td>
                        <td nowrap="nowrap">
                            <label><input type="radio" name="sex" value="1" checked="checked"/>Nam</label>
                            <label><input type="radio" name="sex" value="0"/>Nữ</label>
                        </td>

                    </tr>
                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            &nbsp;
                        </td>
                        <td nowrap="nowrap">
                            <label><input type="checkbox" name="married" value="1"/>Đã kết hôn</label>
                        </td>

                    </tr>
                    
                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            <label>Ảnh đại diện:</label>
                        </td>
                        <td nowrap="nowrap">
                            <input type="file" name="avatar"/>
                        </td>

                    </tr>
                    
                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            <label for="introduce">Vài thông tin khác:</label>
                        </td>
                        <td nowrap="nowrap">
                            <textarea id="introduce" name="introduce" cols="50" rows="5"></textarea>
                        </td>

                    </tr>
                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            &nbsp;
                        </td>
                        <td nowrap="nowrap">
                            <input type="file" name="profile"/>
                        </td>

                    </tr>
                    
                    <tr>                 
                        <td nowrap="nowrap" style="width: 20%;text-align: right;">
                            Sở thích
                        </td>
                        <td nowrap="nowrap">
                            <label><input type="checkbox" name="so_thich[]" value="sport"/>Thể thao</label>
                            <label><input type="checkbox" name="so_thich[]" value="music"/>Âm nhạc</label>
                        </td>

                    </tr>
                    
                    <tr>
                        <td colspan="2" align="center" style="width: 40%;padding-top: 30px;">
                            <input type="submit" value="Thêm mới"/>
                        </td>
                    </tr>

                </tbody>
            </table>
        </form>

        <script type="text/javascript">

            function validate() {

                if ($('#class_id').val() == '') {
                    alert("Vui lòng chọn lớp");
                    $('#class_id').focus();
                    return false;
                }
                full_name = $('#full_name').val();
                if ($.trim(full_name) == '') {
                    alert("Vui lòng nhập họ và tên");
                    $('#full_name').focus();
                    return false;
                }
                birthday = $('#birthday').val();
                if ($.trim(birthday) == '') {
                    alert("Vui lòng nhập ngày sinh");
                    $('#birthday').focus();
                    return false;
                }
                return true;
            }
            
            jQuery(function ($){
               $("#class_id").focus(); 
               
               $( "#birthday" ).datepicker({
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: "dd/mm/yy",
                  showWeek: true,
                    showOn: "button",
                    buttonImage: "../public/images/calendar.gif",
                    buttonImageOnly: true,
                    buttonText: 'Click để chọn ngày',
                    option:$.datepicker.regional['vi']       

                });

                $('img.ui-datepicker-trigger').css('margin-left','10px').css('cursor','pointer');
            });
        </script>
    </body>
</html>
<?php

function convertToENDate($dateVn) {
    $temp = explode('/', $dateVn);
    $dateEn = $temp[2] . '/' . $temp[1] . '/' . $temp[0];
    return $dateEn;
}


?>