<?php
require_once("DBdealer.php");
require_once("BookDBdealer.php");
$db = new DBdealer("root", "daohaodequsi");
$bookdb = new BookDBdealer("root", "daohaodequsi");
if ($_POST) {

    if (isset($_POST["flag"])) {
        if($_POST["flag"]==1){
            session_start();
            $Id = $_POST["id"];
            if ($Id == $_SESSION["id"] && time() < $_SESSION["expire"]) {
                echo true;
            } else {
                echo false;
            }
        }
    } else {
        $username = $_POST['username'];
        $passwords = $_POST['passwords'];
        $userInfos = $db->getOneData($username);
        if ($userInfos) {
            if ($passwords == $userInfos["passwords"]) {
                $id = intval($userInfos["stunum"]);
                initLibInfos($id);
                session_id($id);
                session_start();
                $_SESSION["id"] = $id;
                $_SESSION["expire"] = time() + 3600;
                header("Location:../main.html");
            }
        }

    }
}
if ($_GET) {
    session_start();
    $sessionId = $_GET["id"];
    if ($sessionId == $_SESSION["id"] && time() < $_SESSION["expire"]) {
        $userInfos = $db->getOneData(intval($sessionId));
        $booksInfos = json_encode($bookdb->getAllData());
        if ($userInfos["permission"] == 1) {
            $src = "components/manager.html";
        }
        if ($userInfos["permission"] == 0) {
            $src = "components/users.html";
        }
        $initInfos = array("booksInfos" => $booksInfos, "username" => $userInfos["username"], "stunum" => $userInfos["stunum"], "src" => $src);
        echo json_encode($initInfos);
    }
}
function initLibInfos($id)
{
    $owe = 0;
    $mydb = new DBdealer("root", "daohaodequsi");
    $myInfos = $mydb->getOneData($id);
    if (strlen($myInfos["notreturned"]) > 0) {
        $myborrowinfos = explode(";", $myInfos["notreturned"]);
        for ($i = 0, $j = count($myborrowinfos); $i < $j; $i++) {
            $oneborrowinfos = explode("_", $myborrowinfos[$i]);
            $overdate = explode("-", $oneborrowinfos[2]);
            $currentdate = explode("-", date("Y-m-d"));
            $overyear = intval($currentdate[0]) - intval($overdate[0]);
            $overmonth = intval($currentdate[1]) - intval($overdate[1]);
            $overday = intval($currentdate[2]) - intval($overdate[2]);
            if ($overyear > 0) {
                $owe += $overdate * 365;
            }
            if ($overmonth > 0) {
                $owe += $overmonth * 30;
            }
            if ($overday > 0) {
                $owe += $overday;
            }
        }
    }

    $mydb->updateData("owe", $owe, $id);
}


?>