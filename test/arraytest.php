<?php
/**
 * Created by IntelliJ IDEA.
 * User: rulersex
 * Date: 2017/5/16
 * Time: 17:30
 */
//$str="0001;0002;0003;";
////if(strlen($str)>0){
////    echo (count(explode(";",$str)));
////}
//echo (count(explode(";",$str)));
//$date=date("Y-m-d");
//echo $date;
//$dateArr=explode("-",$date);
//$newdate=date($dateArr[0]."-".$dateArr[1]."-".($dateArr[2]+7));
//$arr=array("0001");
//echo implode(";",$arr);

$a=array("1","2",3,4,5);
$b=array("a","b","c");
$c=array_merge($a,$b);
for($i=0;$i<count($c);$i++){
    echo $c[$i]."<br/>";


}



