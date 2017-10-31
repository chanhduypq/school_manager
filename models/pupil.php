<?php

class ModelPupil {

    private $conn;

    public function __construct() {
        include '../define_db.php';
        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die();
        mysqli_query($conn, "set names 'utf8'");

        $this->conn = $conn;
    }

    public function insert($class_id, $full_name, $birthday, $married, $introduce, $sex, $so_thich) {
        if($introduce==''){
            $introduce='NULL';
        }
        else{
            $introduce="'".$introduce."'";
        }
        
        

        if (isset($_FILES['avatar']) && isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != '') {
            $avatar = $_FILES['avatar']['name'];
            $extension = explode(".", $avatar);
            $extension = $extension[count($extension) - 1];
            $avatar = sprintf('_%s.' . $extension, uniqid(md5(time()), true));
            move_uploaded_file($_FILES['avatar']['tmp_name'], "../public/images/database/avatar/" . $avatar);
        } else {
            $avatar = '';
        }

        if (isset($_FILES['profile']) && isset($_FILES['profile']['name']) && $_FILES['profile']['name'] != '') {
            $profile = $_FILES['profile']['name'];
            $extension = explode(".", $profile);
            $extension = $extension[count($extension) - 1];
            $profile = sprintf('_%s.' . $extension, uniqid(md5(time()), true));
            move_uploaded_file($_FILES['profile']['tmp_name'], "../public/images/database/profile/" . $profile);
        } else {
            $profile = '';
        }



        $music = '0';
        $sport = '0';
        for ($i = 0; $i < count($so_thich); $i++) {
            if ($so_thich[$i] == 'music') {
                $music = '1';
            } else if ($so_thich[$i] == 'sport') {
                $sport = '1';
            }
        }

        $sql = "insert into pupil "
                . "("
                . "class_id,"
                . "full_name,"
                . "birthday,"
                . "sex,"
                . "introduce,"
                . "married,"
                . "avatar,"
                . "music,"
                . "sport,"
                . "profile"
                . ") "
                . "values "
                . "("
                . "" . $class_id . ","
                . "'" . $full_name . "',"
                . "'" . $birthday . "',"
                . "" . $sex . ","
                . $introduce .","
                . "" . $married . ","
                . "'" . $avatar . "',"
                . "" . $music . ","
                . "" . $sport . ","
                . "'" . $profile . "'" .
                ")";
        mysqli_query($this->conn, $sql);
    }

    public function update($class_id, $full_name, $birthday, $married, $introduce, $sex, $so_thich, $id) {
        if (isset($_FILES['avatar']) && isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != '') {
            $avatar = $_FILES['avatar']['name'];
            $extension = explode(".", $avatar);
            $extension = $extension[count($extension) - 1];
            $avatar = sprintf('_%s.' . $extension, uniqid(md5(time()), true));
            move_uploaded_file($_FILES['avatar']['tmp_name'], "../public/images/database/avatar/" . $avatar);

            $stringAvatarInSql = "avatar='" . $avatar . "',";
            @unlink("../public/images/database/avatar/" . $_POST['avatar_filename']);
        } else {
            $stringAvatarInSql = '';
        }

        if (isset($_FILES['profile']) && isset($_FILES['profile']['name']) && $_FILES['profile']['name'] != '') {
            $profile = $_FILES['profile']['name'];
            $extension = explode(".", $profile);
            $extension = $extension[count($extension) - 1];
            $profile = sprintf('_%s.' . $extension, uniqid(md5(time()), true));
            move_uploaded_file($_FILES['profile']['tmp_name'], "../public/images/database/profile/" . $profile);

            $stringProfileInSql = "profile='" . $profile . "',";
            @unlink("../public/images/database/profile/" . $_POST['profile_filename']);
        } else {
            $stringProfileInSql = '';
        }



        $music = '0';
        $sport = '0';
        for ($i = 0; $i < count($so_thich); $i++) {
            if ($so_thich[$i] == 'music') {
                $music = '1';
            } else if ($so_thich[$i] == 'sport') {
                $sport = '1';
            }
        }

        $sql = "update pupil set " .
                "class_id=" . $class_id . ","
                . "full_name='" . $full_name . "',"
                . "birthday='" . $birthday . "',"
                . "introduce='" . $introduce . "',"
                . $stringAvatarInSql
                . $stringProfileInSql
                . "married=" . $married . ","
                . "sport=" . $sport . ","
                . "music=" . $music . ","
                . "sex=" . $sex . " "
                . "where id=" . $id;
        mysqli_query($this->conn, $sql);
    }

    public function getPupilCount($where) {
        $result = mysqli_query($this->conn, "SELECT count(*) as count FROM pupil where $where");
        if ($row = mysqli_fetch_array($result)) {
            return $row['count'];
        }
        return 0;
    }

    public function getPupils($where, $offset, $NUMBER_ROW_PERPAGE) {
        $classes = array();
        $result = mysqli_query($this->conn, "SELECT * FROM pupil_full where $where limit $offset," . $NUMBER_ROW_PERPAGE);

        while ($row = mysqli_fetch_array($result)) {
            $classes[] = $row;
        }
        return $classes;
    }

    public function delete($id) {
        $row = $this->get($id);
        @unlink("../public/images/database/avatar/" . $row['avatar']);
        @unlink("../public/images/database/profile/" . $row['profile']);

        $sql = "delete from pupil where id=$id";
        mysqli_query($this->conn, $sql);
    }

    
    public function get($id) {
        $sql = "select * from pupil_full where id=" . $id;
        $result = mysqli_query($this->conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            return $row;
        }
        return array();
    }

}
