<?php
	session_start();
	$_SESSION["login"] = false;
    session_destroy();

    header("Location: " . $_SERVER['DOCUMENT_ROOT'] . "/Yovoy/Proyecto/index.html")
?>