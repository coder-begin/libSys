<?php
/**
 * Created by IntelliJ IDEA.
 * User: rulersex
 * Date: 2017/5/16
 * Time: 15:36
 */
function bookSort($books){
    $count=count($books);
    for($i=0;$i<$count;$i++){
        for($j=$i+1;$j<$count;$j++){
                if($books[$i]<$books[$j]){
                    $temp=$books[$j];
                    $books[$j]=$books[$i];
                    $books[$i]=$temp;
                }
        }
    }
    return $books;
}
$sorted=bookSort(array(10,9,15,60,3,18));
for($i=0;$i<count($sorted);$i++){
    echo $sorted[$i];
}
