<?php
    class myMember{
        protected $dbConnection = null;
        protected $mode;
        protected function dbConnection(){
            include_once $_SERVER['DOCUMENT_ROOT'].'/connect/connect.php';
        }

        function __construct(){
            if(isset($_POST['mode'])){
                $this->mode = $_POST['mode'];
                if($this->mode == 'emailCheck'){
                    $this->emailCheck($_POST['userEmail']);
                }else if($this->mode == 'save'){
                    $this->signUp();
                }else if($this->mode == 'photo'){
                    $this->photoSave();
                }
            }
        }

        function signUp(){}
        function emailCheck(){}
        function photoSave(){}
    }
    $myMember = new myMember;
?>