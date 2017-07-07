<?php
/**
 * Created by IntelliJ IDEA.
 * User: rulersex
 * Date: 2017/5/12
 * Time: 0:14
 */

        if($_POST){
            $pass=$_POST["pass"];
            if($pass=="admin"){
                $id=$pass.rand(0,100);
                session_id($id);
                session_start();
                $_SESSION["name"]=$id;
                $_SESSION["expire"]=time()+60;
                header("Location:maintest.html");
            }

        }
        if($_GET){
            session_start();
            if($_GET["id"]==$_SESSION["name"]&&time()<$_SESSION["expire"]){
                echo true;
            }else{
                echo false;
            }
        }

