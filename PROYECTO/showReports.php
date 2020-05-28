<?php 
    require_once __DIR__.'/includes/config.php';
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
            if(isset($_SESSION["login"]))
                $userDAO = new UserDAO();
                $eventDAO = new EventDAO();
                $reportDAO = new ReportDAO();
                $reportsList = $reportDAO->getReports();
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
                    $imgDir = "includes/img/users/";
                    $imgName = $user->getImgName();
                    $imgPath = $imgDir . $imgName;
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
                            echo "<p><input class='unresolveBtn' type='image' src='includes/img/boton_REPORTAR.png' alt='No Resolver' title='No Resolver' width='10%' length=10%' value='".$reportId."'></p>";
                        else
                            echo "<p><input class='resolveBtn'type='image' src='includes/img/boton_PREMIUM.png' alt='Resolver' title='Resolver' width='10%' length=10%' value='".$reportId."'></p>";
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
			var check = toChange.hasClass('resolveBtn');
			var before = 'resolveBtn';
			var after = 'unresolveBtn';
			var imgString = 'boton_REPORTAR.png';
			var altString = 'No Resolver';
			if (!check) {
				var temp = before;
				before = after;
				after = temp;
				var imgString = 'boton_PREMIUM.png';
			    var altString = 'Resolver';
			}
			toChange.removeClass(before);
			toChange.addClass(after);
			toChange.attr("src", "includes/img/" + imgString);
			toChange.attr("alt", altString);
			toChange.attr("title", altString);
		},
		error: e => {
			console.log(e);
		}
	});
}
    $(document).ready(function(){
        $("#reportsList div.reports div.reportText div.resolveBtns p input").click(function(){
            resolve($(this).val(), $(this));
        });
	});
    </script>
    <footer>
        <?php include 'includes/comun/footer.php' ?>
    </footer>
</body>
</html>