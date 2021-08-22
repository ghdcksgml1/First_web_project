<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/common/session.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);
class contents
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
        $this->mode = $data_array->mode;
        if ($this->mode == 'save') {
            $this->contentsSave($data_array->meContent);
        } else if ($this->mode == 'loadMore') {
            $this->contentsLoadMore($data_array->contentsLoadType, $data_array->page);
        }
    }

    // 게시물 저장
    function contentsSave($content)
    {
        $time = time();
        $this->dbConnection();
        $myMemberID = $_SESSION['myMemberSes']['myMemberID'];
        $content = mysqli_real_escape_string($this->dbConnection, $content);
        $sql = "INSERT INTO contents(myMemberID, content,regTime) VALUES ('{$myMemberID}','{$content}','{$time}')";
        $res = mysqli_query($this->dbConnection, $sql);

        $result = false;
        if ($res) {
            $result = true;
        }
        echo json_encode(array('result' => $result));
    }
    // 게시물 불러오기
    function contentsLoad($contentsLoadType)
    {
    }
    // 게시물 추가
    function contentsLoadMore($contentsLoadType, $page)
    {
    }
}
$contents = new contents;
