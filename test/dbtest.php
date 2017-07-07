<?php
/**
 * Created by IntelliJ IDEA.
 * User: rulersex
 * Date: 2017/5/13
 * Time: 21:33
 */
require("../php/BookDBdealer.php");
require("../php/DBdealer.php");
//$db=new BookDBdealer("root","daohaodequsi");
////echo $db->insertData('王名贤','140601150',140601150,"学士",date("Y-m-d"),0);
//$userdb=new DBdealer("root","daohaodequsi");
////echo $userdb->updateData("hadbroughtbooks","0001",140601144);
////    $book =$userdb->getOneData(140601150)["hadbroughtbooks"];
////echo strlen($book);
//$allInfos=$userdb->getOneData(140601150);
//$borrowinfos=explode(";",$allInfos["notreturned"]);
//$overdate=explode("_",$borrowinfos[0]);
//$over=explode("-",$overdate[2]);
//$current=explode("-",date("Y-m-d"));
//echo intval($current[1])-intval($over[1]);
//
//function initLibInfos($id){
//    $owe=0;
//    $db=new DBdealer("root","daohaodequsi");
//    $myInfos=$db->getOneData($id);
//    $myborrowinfos=explode(";",$myInfos["notreturned"]);
//    for($i=0,$j=count($myborrowinfos);$i<$j;$i++){
//        $oneborrowinfos=explode("_",$myborrowinfos[$i]);
//        $overdate=explode("-",$oneborrowinfos[2]);
//        $currentdate=explode("-",date("Y-m-d"));
//        $overyear=intval($currentdate[0])-intval($overdate[0]);
//        $overmonth=intval($currentdate[1])-intval($overdate[1]);
//        $overday=intval($currentdate[2])-intval($overdate[2]);
//        if($overyear>0){
//            $owe+=$overdate*365;
//        }
//        if($overmonth>0){
//            $owe+=$overmonth*30;
//            echo $owe."</br>";
//        }
//        if($overday>0){
//            $owe+=$overday;
//            echo $owe;
//        }
//    }
//    $db->updateData("owe",$owe,$id);
//    echo $owe;
//}
//initLibInfos(140601150);

$userdb=new DBdealer("root","daohaodequsi");
$bookdb=new BookDBdealer("root","daohaodequsi");
//$userdb->updateAllData(array("王名贤","admin",140601150,"计算机科学与技术"));
$userdb->deleteData(140601150);
//$count=0;
//$bookid="0001";
//$id=intval(140601150);
//$borrowedBooks=$userdb->getOneData($id)["notreturned"];
//$hadreturnedBooks=$userdb->getOneData($id)["hadbroughtbooks"];
//$books=explode(";",$borrowedBooks);
//if(strlen($hadreturnedBooks)>0){
//    $hadreturnedArr=explode(";",$hadreturnedBooks);
//}else{
//    $hadreturnedArr=array();
//}
//for($i=0,$j=count($books);$i<$j;$i++){
//    if(substr($books[$i],0,4)==$bookid){
//        $oneBookInfos=explode("_",$books[$i]);
//
//        $oneBookInfos[2]=date("Y-m-d");
//
//        array_push($hadreturnedArr,implode("_",$oneBookInfos));
//
//
//
//        $myHadReturned=implode(";",$hadreturnedArr);
//
////        echo $myHadReturned;
////        $userdb->updateData("hadbroughtbooks",$myHadReturned,$id);
//        array_splice($books,$i,1);
//
//        $borrowedBooks=implode(";",$books);
//        echo $borrowedBooks;
//        $userdb->updateData("notreturned",$borrowedBooks,$id);
//        $count++;
//        break;
//    }
//}
//echo $count;




