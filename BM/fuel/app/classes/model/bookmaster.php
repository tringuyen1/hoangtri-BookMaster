<?php
class Model_Bookmaster extends Orm\Model {
    //Thực thi chuổi truy vấn
    public static function db_query($query_string) {
        $conn = mysqli_connect('localhost', 'root', '', 'mt_book');
        $result = mysqli_query($conn, $query_string);
        return $result;
    }

    // cập nhật db
    public static function db_insert($data) {
        $conn = mysqli_connect('localhost', 'root', '', 'mt_book');
        $fields = "(" . implode(", ", array_keys($data)) . ")";
        $values = "";
        foreach ($data as $field => $value) {
            if ($value === NULL)
                $values .= "NULL, ";
            else
                $values .= "'" . Model_Bookmaster::escape_string($value) . "', ";
        }
        $values = substr($values, 0, -2);
        Model_Bookmaster::db_query("
                INSERT INTO `bookmasters` $fields
                VALUES($values)
            ");
        return mysqli_insert_id($conn);
    }


    // update
    public static function db_update($data, $id) {
        $conn = mysqli_connect('localhost', 'root', '', 'mt_book');
        $sql = "";
        foreach ($data as $field => $value) {
            if ($value === NULL)
                $sql .= "$field=NULL, ";
            else
                $sql .= "$field='" . Model_Bookmaster::escape_string($value) . "', ";
        }
        $sql = substr($sql, 0, -2);
        Model_Bookmaster::db_query("
                UPDATE `bookmasters`
                SET $sql
                WHERE `id` = '$id'
       ");
        return mysqli_affected_rows($conn);
    }


    // delete
    public static function db_delete($id) {
        $conn = mysqli_connect('localhost', 'root', '', 'mt_book');
        $query_string = "DELETE FROM `bookmasters` WHERE `id` = '$id'";
        Model_Bookmaster::db_query($query_string);
        return mysqli_affected_rows($conn);
    }
    
    

    public static function escape_string($str) {
        $conn = mysqli_connect('localhost', 'root', '', 'mt_book');
        return mysqli_real_escape_string($conn, $str);
    }
}


?>