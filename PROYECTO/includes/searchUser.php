<?php
require_once __DIR__.'/config.php';

    $userDAO = new UserDAO();
    $searchVal = $_POST["searchVal"];
    $filter = $_POST["filter"];

    if(isset($_SESSION["userId"]) && $_SESSION["userId"]){
        $userArray = $userDAO->searchUser($filter, $searchVal);
        $dataArray = array();
        while(sizeof($userArray) > 0){
            $user = array_pop($userArray);
            $userId = $user->getUserId();
            $name = $user->getName();
            $username = $user->getUsername();
            $imgName = $user->getImgName();
            $userJson = array(
                'id' => $userId,
                'username' => $username,
                'name' => $name,
                'imgName' => $imgName,
		    );
            array_push($dataArray, $userJson);
	    }

        echo json_encode($dataArray);
    }
?>