<?php
class BookDBdealer
{
    var $username;
    var $passwords;
    var $host = "localhost";
    var $DB = "LibraryManageSystem";
    var $data;              //存单条数据
    var $alldata=array();   //所有数据

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

    function  insertData($bookid,$bookname,$author,$publishHouse){
        $conn=new mysqli($this->host, $this->username, $this->passwords,$this->DB);
        if ($conn->connect_error) {
            echo "connect error";
        }
        $sql = "INSERT INTO book_infos(bookid,bookname,author,publish_house)VALUES( '".$bookid."','".$bookname."','".$author."','".$publishHouse."')";
        if ($conn->query($sql) === TRUE) {
            echo true;
        } else {
            echo $conn->error;
        }
        $conn->close();
    }
    function  getOneDataById($id){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM book_infos WHERE bookid='".$id."'";
        $result = $conn->query($sql);
        if ($result->num_rows> 0){
            $this->data=$result->fetch_assoc();
            return $this->data;
        }
        $conn->close();
    }

    function  getOneDataByName($name){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM book_infos WHERE bookname='".$name."'";
        $result = $conn->query($sql);
        if ($result->num_rows> 0){
            $this->data=$result->fetch_assoc();
            $conn->close();
            return $this->data;
        } else {
            $conn->close();
            return false;
        }

    }
    function  getAllData(){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM book_infos";
        $result = $conn->query($sql);
        if ($result->num_rows> 0){
            while($onedata=$result->fetch_assoc()){
                array_push($this->alldata,$onedata);
            }
            return $this->alldata;
        } else {
            $conn->close();
            return false;
        }
    }
    function deleteData($bookid){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql = "DELETE FROM book_infos WHERE bookid=".$bookid;
        if ($conn->query($sql)===TRUE){
           echo true;
        } else {
            $conn->close();
            echo $conn->error;
        }


    }
    function updateData($bookinfos){
        $conn = new mysqli($this->host, $this->username, $this->passwords, $this->DB);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql="UPDATE book_infos SET bookname = '".$bookinfos[1]."', author='".$bookinfos[2]."', publish_house='".$bookinfos[3]."' WHERE bookid=".$bookinfos[0];
        if ($conn->query($sql) === TRUE) {
            echo true;
        }else{
            echo "error----->".$conn->error;
        }
        $conn->close();
    }

}