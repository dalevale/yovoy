<?php
require_once __DIR__.'/config.php';

    $reportDAO = new ReportDAO();
    $reportId = $_POST["reportId"];

    if(!$reportDAO->isResolved($reportId))
         $result = $reportDAO->resolveReport($reportId, ReportDAO::RESOLVED);
    else
         $result = $reportDAO->resolveReport($reportId, ReportDAO::UNRESOLVED);

    echo $result;

   
