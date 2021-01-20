<?php
require './classes/dao/UserDaoImpl.php';
define("EXPORT_FILENAME", "export.csv");
define("DELIMETER", ";");



class ImportExportService
{
    protected $_userDao;
    public function __construct(UserDao $userDao)
    {
        $this->_userDao = $userDao;
    }

    public function importUsers($file)
    {
        $csvFile = null;
        try {
            $csvFile = fopen($file['tmp_name'], "r");
            while (($column = fgetcsv($csvFile, 10000, DELIMETER)) !== FALSE) {
                if ($this->validateUser($column)) {
                    $this->_userDao->insertUser($column[0], $column[1], $column[2], $column[3], $column[4]);
                } else {
                    throw new Exception("Validation failed");
                }
            }

        } catch (exception $e) {
            Helpers::alert("Csv file is invalid.\n " . $e);
        } finally {
            fclose($csvFile);
        }
    }

    public function exportUsers()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . EXPORT_FILENAME);

        $output = fopen("php://output", "w");

        foreach ($this->_userDao->getAllUsers() as $user) {
            $row = "";

            for ($i = 1; $i < 5; $i++) { //Skip id and rememberme hash (first and last)
                $row .= $user[$i] . DELIMETER;
            }
            $row .= "\n";
            fwrite($output, $row);
        }
        fclose($output);
        exit();
    }


    private function validateUser($data)
    {
        $validRoles = array("admin", "teacher", "student");

        if (empty($data[0])
            ||
            empty($data[1])
            ||
            empty($data[2])
            ||
            empty($data[3])
            ||
            empty($data[4])) {
            return false;
        }

        if (strlen($data[0]) > 250
            ||
            strlen($data[1]) > 250
            ||
            strlen($data[2]) > 250
            ||
            strlen($data[3]) > 50
            ||
            strlen($data[4]) > 50) {
            return false;
        }

        if (!in_array($data[4], $validRoles)) {
            return false;
        }

        if (strpos($data[2], "@") == false) { //Regex would be better
            return false;
        }

        return true;
    }
}