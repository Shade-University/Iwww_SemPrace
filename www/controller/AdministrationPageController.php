<?php
require_once './classes/ImportExportService.php';
require_once './classes/Helpers.php';

class AdministrationPageController
{
    protected $_importExportService;

    public function __construct()
    {
        $this->_importExportService = new ImportExportService(new UserDaoImpl());
    }

    public function importFile($file)
    {
        if ($file["size"] > 0) {
            $this->_importExportService->importUsers($file);
        }

    }

}