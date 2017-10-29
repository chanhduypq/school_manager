<?php

class ModelClass {

    private $conn;

    public function __construct() {
        include '../define_db.php';
        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME) or die();
        mysqli_query($conn, "set names 'utf8'");

        $this->conn = $conn;
    }

    public function insert($name) {
        $sql = "insert into class "
                . "("
                . "name"
                . ") "
                . "values "
                . "("
                . "'" . $name . "'" .
                ")";
        mysqli_query($this->conn, $sql);
    }

    public function update($name, $id) {
        $sql = "update class set "
                . "name='" . $name . "'"
                . "where id=" . $id;
        mysqli_query($this->conn, $sql);
    }

    public function getClassCount($where) {
        $result = mysqli_query($this->conn, "SELECT count(*) as count FROM class where $where");
        if ($row = mysqli_fetch_array($result)) {
            return $row['count'];
        }
        return 0;
    }

    public function getClasses($where, $offset=null, $NUMBER_ROW_PERPAGE=null) {
        $classes = array();
        if(ctype_digit($offset)&& ctype_digit($NUMBER_ROW_PERPAGE)){
            $result = mysqli_query($this->conn, "SELECT * FROM class_full where $where limit $offset," . $NUMBER_ROW_PERPAGE);
        }
        else{
            $result = mysqli_query($this->conn, "SELECT * FROM class_full where $where");
        }
        

        while ($row = mysqli_fetch_array($result)) {
            $classes[] = $row;
        }
        return $classes;
    }

    public function delete($id) {
        $sql = "delete from class where id=$id";
        mysqli_query($this->conn, $sql);
    }

    public function exist($name, $id = null) {
        if (ctype_digit($id)) {
            $sql = "select * from class where name='$name' and id<>$id";
        } else {
            $sql = "select * from class where name='$name'";
        }

        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            return false;
        }
        return true;
    }

    public function get($id) {
        $sql = "select * from class where id=" . $id;
        $result = mysqli_query($this->conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            return $row;
        }
        return array();
    }

}
