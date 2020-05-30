<?php
require_once __DIR__.'/config.php';

    $userDAO = new UserDAO();
    $activityDAO = new ActivityDAO();
    $notificationsDAO = new NotificationsDAO();
    if(isset($_SESSION["userId"]) && $_SESSION["userId"]){
        
        $task = $_POST["task"];
        $u1 = $_POST["userId"];
        $u2 = $_POST["profileId"];
        $script = '<script>$("#addFriendBtn").click(function () {
                var ok = confirm("Estas seguro?");
                if(ok)
                    changeRelation($(this), "addFriend");
                });
                $("#blockUserBtn").click(function () {
                var ok = confirm("Estas seguro?");
                if(ok)
                    changeRelation($(this), "blockUser");
                });</script>';
        switch($task){
            case "addFriend":
                $result = $userDAO->insertRelationship($u1, $u2, RelationManager::ADD, $u1);
                $notificationsDAO->notify(NotificationsDAO::NEW_FRIEND_REQUEST,$u2, $u1, 'NULL');
                $script = '<script>$("#cancelAddFriendBtn").click(function () {
                var ok = confirm("Estas seguro?");
                if(ok)
                    changeRelation($(this), "cancelAddFriend");
                });</script>';
            break;
            case "cancelAddFriend":
                $result = $userDAO->deleteRelationship($u1, $u2);
                $notificationsDAO->removeNotificationsByUsers($u2,$u1,NotificationsDAO::NEW_FRIEND_REQUEST);
            break;
            case "rejectFriend":
                $result = $userDAO->deleteRelationship($u1, $u2);
                break;
            case "acceptFriend":
                $userDAO->deleteRelationship($u1, $u2);
                $result = $userDAO->insertRelationship($u1, $u2, RelationManager::ACCEPT, $u1);
                $notificationsDAO->notify(NotificationsDAO::FRIEND_REQUEST_ACCEPTED,$u2, $u1, 'NULL');
                $activityDAO->addActivity($u1,ActivityDAO::USER, $u2, 'null', ActivityDAO::NEW_FRIEND);
                $activityDAO->addActivity($u2,ActivityDAO::USER, $u1, 'null', ActivityDAO::NEW_FRIEND);
                $script = '<script>$("#unfriendBtn").click(function () {
                var ok = confirm("Estas seguro?");
                if(ok)
                    changeRelation($(this), "unfriend");
                });</script>';
            break;
            case "unfriend":
                $result = $userDAO->deleteRelationship($u1, $u2);
            break;
            case "blockUser":
                $result = $userDAO->insertRelationship($u1, $u2, RelationManager::BLOCK, $u1);
                $script = '<script>$("#unblockUserBtn").click(function () {
                var ok = confirm("Estas seguro?");
                if(ok)
                    changeRelation($(this), "unblockUser");
                });</script>';
            break;
            case "unblockUser":
                $result = $userDAO->deleteRelationship($u1, $u2);
            break;
            default:
            break;
		}
        if($result != 0){
            $relMan = new RelationManager($u1, $u2);
            $html = $relMan->printButtons();
            $html .= $script;
            $ret = array('html'=>$html);
            $result = json_encode($ret);
		}

        echo $result;
    }
?>