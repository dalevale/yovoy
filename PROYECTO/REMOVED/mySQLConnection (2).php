 <?php
    //Ajustar según la configuracion de la BBDD que tengais en vuestro equipo
    $DBServername="localhost";
    $DBUsername="root";
    $DBPasswd="";
    $DBName="yovoy_DB";
    $conn= new mysqli($DBServername, $DBUsername, $DBPasswd, $DBName);
    
    if($conn -> connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
?>
