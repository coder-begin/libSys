<?php
/**
 * Created by IntelliJ IDEA.
 * User: rulersex
 * Date: 2017/5/13
 * Time: 21:29
 */
class DBdealer
{
    var $username;
    var $passwords;
    var $host = "localhost";
    var $DB = "LibraryManageSystem";
    var $data;

    function  DBdealer($username, $passwords)
    {
        $this->username = $username;
        $this->passwords = $passwords;
    }

    function createDB()
    {
        $isConnect =new mysqli($this->host, $this->username, $this->passwords);
        if ($isConnect->connect_error) {
            return "connect error";
        }else{
            $selected_db = $isConnect->select_db($this->DB);
            if (!$selected_db) {
                $created_db =$isConnect->query("CREATE DATABASE ".$this->DB);
                if (!$created_db) {
                    $isConnect->close();
                    return false;
                } else {
                    $isConnect->close();
                   return true;
                }
            }
        }

    }

    function  insertData($name,$pass,$stunum,$major,$carddata,$permission){
        $conn=new mysqli($this->host, $this->username, $this->passwords,$this->DB);
        if ($conn->connect_error) {
           echo "connect error";
        }
        $sql = "INSERT INTO users_infos( username,passwords,stunum,major,carddata,permission)VALUES( '".$name."','".$pass."',".$stunum.",'".$major."','".$carddata."',".$permission.")";
        if ($conn->query($sql) === TRUE) {
           echo true;
        } else {
           echo false;
        }

        $conn->close();
    }
    function  getOneData($name){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM users_infos WHERE stunum='".$name."'";
        $result = $conn->query($sql);
        if ($result->num_rows> 0){
           $this->data=$result->fetch_assoc();
            return $this->data;
        }
        $conn->close();
    }

    function  updateData($change,$new ,$id){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql="UPDATE users_infos SET ".$change." = '".$new."' WHERE stunum=".$id;
        if ($conn->query($sql) === TRUE) {

        }else{
           echo "error----->".$conn->error;
        }
        $conn->close();

    }
    function  updateAllData($newArr){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql="UPDATE users_infos SET username = '".$newArr[0]."', passwords='".$newArr[1]."', major='".$newArr[3]."' WHERE stunum=".intval($newArr[2]);
        if ($conn->query($sql) === TRUE) {
                echo true;
        }else{
            echo "error----->".$conn->error;
        }
        $conn->close();
    }
    function  deleteData($stunum){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if (!$conn)
        {
            die('Could not connect: ' . $conn->connect_error);
        }
        $sql="DELETE FROM users_infos WHERE stunum=".$stunum;
         if ($conn->query($sql) === TRUE) {
             echo true;
         }else{
             echo "error----->".$conn->error;
         }
        $conn->close();

    }

}