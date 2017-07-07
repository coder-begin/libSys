<?php
/**
 * Created by IntelliJ IDEA.
 * User: rulersex
 * Date: 2017/5/17
 * Time: 13:30
 */
require_once("BookDBdealer.php");
require_once("DBdealer.php");

if($_GET){
    switch($_GET["flag"]){
        //管理界面的搜索学生信息
        case 0:
            $users=new DBdealer("root","daohaodequsi");
            $userInfos=$users->getOneData(intval($_GET["stunum"]));
            if(count($userInfos)>0){
                echo json_encode($userInfos);
            }else{
                echo false;
            }
            break;
        case 1:
            $bookDB=new BookDBdealer("root","daohaodequsi");
            $bookInfos=$bookDB->getOneDataById($_GET["bookid"]);
            if(count($bookInfos)>0){
                echo json_encode($bookInfos);

            }else{
                echo false;

            }
            break;


    }


}
if($_POST){
    switch($_POST["flag"]){
        //管理界面的学生添加
        case 0:
            $usersDB=new DBdealer("root","daohaodequsi");
            $stuNum=$_POST["stunum"];
            $stuName=$_POST["stuname"];
            $stuMajor=$_POST["stumajor"];
            $usersDB->insertData($stuName,"admin",intval($stuNum),$stuMajor,date("Y-m-d"),0);
            break;
        case 1:
        //管理界面的图书添加
            $bookDB=new BookDBdealer("root","daohaodequsi");
            $bookId=$_POST["bookid"];
            $bookName=$_POST["bookname"];
            $bookAuthor=$_POST["bookauthor"];
            $bookDB->insertData($bookId,$bookName,$bookAuthor,"南京理工大学出版社");
            break;
        case 2:
            //管理界面的学生信息更新
            $userDB=new DBdealer("root","daohaodequsi");
            $userDB->updateAllData($_POST["stuinfos"]);
            break;
        case 3:
            //管理界面的学生信息删除
            $userDB=new DBdealer("root","daohaodequsi");
            $userDB->deleteData($_POST["stunum"]);
            break;
        case 4:
            //管理界面的图书信息更新
            $bookDB=new BookDBdealer("root","daohaodequsi");
            $bookDB->updateData($_POST["bookinfos"]);
            break;
        case 5:
            //管理界面的图书信息删除
            $bookDB=new BookDBdealer("root","daohaodequsi");
            $bookDB->deleteData($_POST["bookid"]);
            break;



    }


}
