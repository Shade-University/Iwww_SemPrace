<?php
require_once './classes/ImportExportService.php';
require_once './classes/dao/UserDaoImpl.php';

$service = new ImportExportService(new UserDaoImpl());

$service->exportUsers(); //Must be in solo file to prevent index.php writing to output
