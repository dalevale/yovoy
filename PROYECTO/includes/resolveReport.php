<?php
require_once __DIR__.'/config.php';

    $reportDAO = new ReportDAO();
    $reportId = $_POST["reportId"];

    if(!$reportDAO->isResolved($reportId))
         $reportDAO->resolveReport($reportId, ReportDAO::RESOLVED);
    else
         $reportDAO->resolveReport($reportId, ReportDAO::UNRESOLVED);

    echo 0;

   
