<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/common/session.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);
class comments
{
    protected $dbConnection = null;
    protected $mode;

    protected function dbConnection()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/connect/connect.php';
    }

    function __construct()
    {
        $data = file_get_contents('php://input');
        $data_array = json_decode($data);
        $mode = $data_array->mode;
        if (isset($mode)) {
            if ($mode == 'save') {
                $this->commentsSave($data_array->contentsID, $data_array->comment);
            }
        }
    }

    protected function commentsSave($contentsID, $comment)
    {
        $contentsID = (int)$contentsID;

        $errorCheck = false;

        if ($contentsID == 0 || $comment == '') {
            $errorCheck = true;
        }

        if ($errorCheck == true) {
            echo json_encode(array('result' => 'false'));
        }

        $myMemberID = $_SESSION['myMemberSes']['myMemberID'];

        $this->dbConnection();

        $comment = mysqli_real_escape_string($this->dbConnection, $comment);

        $time = time();

        $sql = "INSERT INTO comments(contentsID, myMemberID, comment, regTime) ";
        $sql .= "VALUES({$contentsID}, {$myMemberID}, '{$comment}', {$time})";
        $res = mysqli_query($this->dbConnection, $sql);

        $result = false;
        if ($res) {
            $result = true;
        }

        echo json_encode(array('result' => $result, 'poster' => $_SESSION['myMemberSes']['userName'], 'profilePhoto' => $_SESSION['myMemberSes']['profilePhoto'], 'regTime' => $time));
    }
}
$comments = new comments;
