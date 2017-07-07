<?php
/**
 * Created by IntelliJ IDEA.
 * User: rulersex
 * Date: 2017/5/15
 * Time: 23:39
 */
require_once("DBdealer.php");
require_once("BookDBdealer.php");


if ($_GET) {
    switch ($_GET["flag"]) {

        //0是返回用户信息
        case 0:
            $userdb = new DBdealer("root", "daohaodequsi");
            $bookdb = new BookDBdealer("root", "daohaodequsi");
            $userInofs = $userdb->getOneData($_GET["id"]);
            echo json_encode($userInofs);
            break;

        //1是返回搜索的图书信息
        case 1:
            $userdb = new DBdealer("root", "daohaodequsi");
            $bookdb = new BookDBdealer("root", "daohaodequsi");
            $bookInfos = $bookdb->getOneDataByName($_GET["bookname"]);
            echo json_encode($bookInfos);
            break;
        //返回前20本借阅最多的书信息
        case 2:
            $userdb = new DBdealer("root", "daohaodequsi");
            $bookdb = new BookDBdealer("root", "daohaodequsi");
            $allbooks = $bookdb->getAllData();
            echo json_encode(bookSort($allbooks));
            break;
        //获取所有借书信息
        case 3:
            $userdb = new DBdealer("root", "daohaodequsi");
            $infos = $userdb->getOneData($_GET["id"]);
            $notreturnArr = getBooksInfos($infos["notreturned"], "未还");
            $hadreturnedArr = getBooksInfos($infos["hadbroughtbooks"], "已还");
            $allbookinfos = array_merge($notreturnArr, $hadreturnedArr);
            echo json_encode($allbookinfos);
            break;
    }


}
if ($_POST) {
    switch ($_POST["flag"]) {
        //0代表借书

        case 0:
            $userdb = new DBdealer("root", "daohaodequsi");
            $bookdb = new BookDBdealer("root", "daohaodequsi");
            $bookid = $_POST["bookid"];
            $id = intval($_POST["id"]);
            $date = date("Y-m-d");
            $dateArr = explode("-", $date);
            $newdate = date($dateArr[0] . "-" . $dateArr[1] . "-" . ($dateArr[2] + 7));
            $borrowedBooks = $userdb->getOneData($id)["notreturned"];
            if(!isBorrowed($borrowedBooks,$bookid)){
                if ($bookdb->getOneDataById($bookid)) {
                    if (strlen($borrowedBooks) > 0) {
                        $mybooks = $borrowedBooks . ";" . $bookid . "_" . $date . "_" . $newdate;
                        $userdb->updateData("notreturned", $mybooks, $id);
                        echo true;
                    } else {
                        $mybooks = $bookid . "_" . $date . "_" . $newdate;
                        $userdb->updateData("notreturned", $mybooks, $id);
                        echo true;
                    }
                } else {
                    echo false;
                }

            }else{
                echo false;
            }

            break;
        //1代表还书
        case 1:
            $userdb = new DBdealer("root", "daohaodequsi");
            $bookdb = new BookDBdealer("root", "daohaodequsi");
            $count = 0;
            $bookid = $_POST["bookid"];
            $id = intval($_POST["id"]);
            $borrowedBooks = $userdb->getOneData($id)["notreturned"];
            $hadreturnedBooks = $userdb->getOneData($id)["hadbroughtbooks"];
            $books = explode(";", $borrowedBooks);
            if (strlen($hadreturnedBooks) > 0) {
                $hadreturnedArr = explode(";", $hadreturnedBooks);
            } else {
                $hadreturnedArr = array();
            }
            for ($i = 0, $j = count($books); $i < $j; $i++) {
                if (substr($books[$i], 0, 4) == $bookid) {
                    $oneBookInfos = explode("_", $books[$i]);
                    $oneBookInfos[2] = date("Y-m-d");
                    array_push($hadreturnedArr, implode("_", $oneBookInfos));
                    $myHadReturned = implode(";", $hadreturnedArr);
                    $userdb->updateData("hadbroughtbooks", $myHadReturned, $id);
                    array_splice($books, $i, 1);
                    $borrowedBooks = implode(";", $books);
                    $userdb->updateData("notreturned", $borrowedBooks, $id);
                    $count++;
                    break;
                }
            }
            if ($count > 0) {
                echo true;
            } else {
                echo false;
            }
            break;


    }


}
//确定是否已经借了这本书
function  isBorrowed($notreturn,$willborrow){
    $allnotreturnedbooks=explode(";",$notreturn);
    for($i=0,$j=count($allnotreturnedbooks);$i<$j;$i++){
        $onebookid=explode("_",$allnotreturnedbooks[$i])[0];
        if($onebookid==$willborrow){
            return true;
        }
    }
    return false;

}

//数组排序
function bookSort($books)
{
    $count = count($books);
    for ($i = 0; $i < $count; $i++) {
        for ($j = $i + 1; $j < $count; $j++) {
            if ($books[$i]["beingborrowednum"] < $books[$j]["beingborrowednum"]) {
                $temp = $books[$j];
                $books[$j] = $books[$i];
                $books[$i] = $temp;
            }
        }
    }
    return array_slice($books, 0, 15);
}

//读取图书信息
function getBooksInfos($str, $status)
{
    $booksArr = array();
    if (strlen($str) > 0) {
        $bookdb = new BookDBdealer("root", "daohaodequsi");
        $bookInfos = explode(";", $str);
        for ($i = 0, $j = count($bookInfos); $i < $j; $i++) {
            $oneBookInfos = explode("_", $bookInfos[$i]);
            $bookname = $bookdb->getOneDataById($oneBookInfos[0])["bookname"];
            $book = $oneBookInfos[0] . "_" . $bookname . "_" . $oneBookInfos[1] . "_" . $oneBookInfos[2] . "_" . $status;
            array_push($booksArr, $book);
        }

    }
    return $booksArr;

}




