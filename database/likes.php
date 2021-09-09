<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/common/session.php';
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    class likes{
        protected $dbConnection = null;
        protected $mode;

        protected function dbConnection(){
            include_once $_SERVER['DOCUMENT_ROOT'].'/connect/connect.php';
        }

        function __construct(){
            $data = file_get_contents('php://input');
            $data_array = json_decode($data);
            $mode = $data_array->mode;
            if(isset($mode)){
                if ($mode == 'new'){
                    $this->likesNew($data_array->contentsID);
                }
                if ($mode == 'plus'){
                    $this->likesPlus($data_array->contentsID);
                }
            }
        }

        # INSERT INTO VALUES 구현
        function likesNew($contentsID){

        }
        # likes 개수 추가
        function likesPlus($contentsID){

        }
    }
?>