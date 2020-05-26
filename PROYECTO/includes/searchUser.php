<?php
require_once __DIR__.'/config.php';

    $userDAO = new UserDAO();
    $username = $_POST["username"];
    

    if(isset($_SESSION["userId"]) && $_SESSION["userId"]){
       $userArray = $userDAO->searchUser($username);
       $dataArray = array();
    while(sizeof($userArray) > 0){
        $user = array_pop($userArray);
        $userId = $user->getUserId();
        $username = $user->getUsername();
        $imgName = $user->getImgName();
        $userJson = array(
            'id' => $userId,
            'username' => $username,
            'imgName' => $imgName,
		);
        array_push($dataArray, $userJson);
	}

    echo json_encode($dataArray);
    }
            

?>