<?php 
    require_once __DIR__.'/includes/config.php';
    
    //DAO�s
    $userDAO = new UserDAO();
    $eventDAO = new EventDAO();
    $reportDAO = new ReportDAO();

    //Lista de los reports
    $reportsList = $reportDAO->getReports();

    //Condiciones necesarias para ver el contenido
    $loggedIn = isset($_SESSION["login"]) && $_SESSION["login"];
    $adminLoggedIn = isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"];
    
    //Directorio de las imagenes de los usuarios
    $userImgDir = "includes/img/users/";
    
    if(!$loggedIn || !$adminLoggedIn){
        header("Location: error.php");
        die();
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
</head>
<body>
    <header>
        <?php include 'includes/comun/nav.php' ?>
    </header>  
    <div class= "container">
    <h1>Reports</h1>
    
        <div id="reportsList" class= "friends row justify-content-between">
            <?php
            if($loggedIn)
                //Mostrar reports de BBDD
                while(sizeof($reportsList) > 0){
                    $report = array_pop($reportsList);
                    $reportId = $report->getId();
                    $userId = $report->getUserId();
                    $user = $userDAO->getUser($userId);
                    $userName = $user->getName();
                    $objType = $report->getObjType();
                    $reportDate = $report->getReportDate();
                    $reportText = $report->getReportText();
                    $date = date("Y-m-d g:ia", strtotime($reportDate));
                    $resolved = $report->isResolved();
                    $imgName = $user->getImgName();
                    $imgPath = $userImgDir . $imgName;
                    if($objType == ReportDAO::USER){
                        $objId = $report->getObjUserId();
                        $objUser = $userDAO->getUser($objId);
                        $objName = $objUser->getName();
                        $str = "un usuario: ";
                        $imgDir = "includes/img/users/";
                        $objImgName = $objUser->getImgName();
                        $objImgPath = $imgDir . $objImgName;
                        $linkPath = "profileView.php?userId=";
				    }
                    else if($objType == ReportDAO::EVENT){
                        $objId = $report->getObjEventId();
                        $objEvent = $eventDAO->getEvent($objId);
                        $objName = $objEvent->getName();
                        $str = "un evento: ";
                        $imgDir = "includes/img/events/";
                        $objImgName = $objEvent->getImgName();
                        $objImgPath = $imgDir + $objImgName;
                        $linkPath = "eventItem.php?eventId=";
				    }
                    echo "<div class = 'reports tarjeta_blanca col-md-5  col-12'>";
                        echo "<p><a href='profileView.php?userId=".$userId."'>";
                        echo "<img src='" . $imgPath . "?random=" . rand(0, 100000) . "' alt='img' height='50' width='50'></a>";
                        echo "<a href= 'profileView.php?userId=".$userId."'>".$userName."</a>";
                        echo " ha reportado ". $str;
                        echo "</p><p><a href='". $linkPath . $objId . "'>";
                        echo "<img src='" . $objImgPath . "?random=" . rand(0, 100000) . "' alt='img' height='50' width='50'></a>";
                        echo "<a href='". $linkPath . $objId . "'>" . $objName . "</a>"  . " el " .$date. "</p>";
                        echo "<div class = 'reportText'>";
                        echo "<p></p><p>Message: <span class='reportText'>". $reportText ."</span></p>";
                        echo "<div class='resolveBtns'>";
                        if($resolved)
                            echo "<p><input class='unresolveBtn' type='image' src='includes/img/boton_CANCELAR.png' alt='No Resolver' title='No Resolver' width='10%' length=10%' value='".$reportId."'></p>";
                        else
                            echo "<p><input class='resolveBtn'type='image' src='includes/img/boton_RESOLVE.png' alt='Resolver' title='Resolver' width='10%' length=10%' value='".$reportId."'></p>";
                        echo "</div>";
                        echo "</div>";
                    echo "</div>";
			        }
            ?>
        </div>
    </div>
    <script>
        function resolve(reportId, toChange){
            var data = {
		"reportId": reportId
	    }
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/resolveReport.php",
		data: data,
		success: data => {
            if(data == 0)
                alert("No se puede resolver el report en este momento.");
            else {			    var check = toChange.hasClass('resolveBtn');
			    var before = 'resolveBtn';
			    var after = 'unresolveBtn';
			    var imgString = 'boton_CANCELAR.png';
			    var altString = 'No Resolver';
			    if (!check) {
				    var temp = before;
				    before = after;
				    after = temp;
				    var imgString = 'boton_RESOLVE.png';
			        var altString = 'Resolver';
			    }
			    toChange.removeClass(before);
			    toChange.addClass(after);
			    toChange.attr("src", "includes/img/" + imgString);
			    toChange.attr("alt", altString);
			    toChange.attr("title", altString);
			}
		},
		error: e => {
			console.log(e);
		}
	});
}
    $(document).ready(function(){
        $("#reportsList div.reports div.reportText div.resolveBtns p input").click(function(){
            var str = "RESUELTO";
            if($(this).hasClass('unresolveBtn'))
                str = "NO RESUELTO";
            var ok = confirm("Cambiando estado del report a "+ str +". ¿Estas seguro?");
            if (ok)
                resolve($(this).val(), $(this));
        });
	});
    </script>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>
