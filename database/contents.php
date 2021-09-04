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
        if (isset($data_array->mode)) {
            $this->mode = $data_array->mode;
            if ($this->mode == 'save') {
                $this->contentsSave($data_array->meContent);
            } else if ($this->mode == 'loadMore') {
                $this->contentsLoadMore($data_array->contentsLoadType, $data_array->page);
            }
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
        if ($contentsLoadType != 'me' && $contentsLoadType != 'all') {
            echo "잘못된 정보가 입력되어 기능이 정지됩니다.";
            exit;
        }
        $sqlMaker = '';
        $myMemberID = $_SESSION['myMemberSes']['myMemberID'];


        if ($contentsLoadType == 'me') {
            $sqlMaker = 'WHERE c.myMemberID = ' . $myMemberID;
        }

        $sql = "SELECT c.contentsID, c.myMemberID, c.content, c.regTime, m.userName,m.profilePhoto
        FROM contents c JOIN mymember m ON (c.myMemberID = m.myMemberID) {$sqlMaker} ORDER BY c.regTime DESC LIMIT 20";

        $this->dbConnection();
        $res = mysqli_query($this->dbConnection, $sql);

        $content = array();

        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $commentLoad = $this->commentsLaod($row['contentsID']);
            $row['comment'] = array();
            while ($comments = mysqli_fetch_array($commentLoad, MYSQLI_ASSOC)) {
                array_push($row['comment'], $comments);
            }
            array_push($content, $row);
        }


        return $content;
    }

    //댓글 불러오기
    function commentsLaod($contentsID)
    {
        $sql = "SELECT c.contentsID, c.commentsID, c.comment, c.regTime, m.userName
        , m.profilePhoto FROM comments c ";
        $sql .= "INNER JOIN mymember m ON (c.myMemberID = m.myMemberID) WHERE contentsID = {$contentsID}";
        $this->dbConnection();
        $res = mysqli_query($this->dbConnection, $sql);
        return $res;
    }

    // 게시물 추가
    function contentsLoadMore($contentsLoadType, $page)
    {
        $errorCheck = false;
        if ($contentsLoadType != 'me' && $contentsLoadType != 'all') {
            $errorCheck = true;
        }

        $page = (int) $page;
        if ($page == 0) {
            $errorCheck = true;
        }

        if ($errorCheck == true) {
            echo json_encode(array('result' => false,));
        }

        $dataCount = 20;
        $limitFirstValue = $page * $dataCount;
        $sqlMaker = '';
        $myMemberID = $_SESSION['myMemberSes']['myMemberID'];
        if ($contentsLoadType == 'me') {
            $sqlMaker = 'WHERE c.myMemberID = ' . $myMemberID;
        }
        $sql = "SELECT c.contentsID, c.myMemberID, c.content, c.regTime, m.userName,
        m.profilePhoto FROM contents c JOIN mymember m ON (c.myMemberID = m.myMemberID) {$sqlMaker} ORDER BY c.regTime DESC LIMIT {$limitFirstValue}, {$dataCount}";

        $this->dbConnection();
        $res = mysqli_query($this->dbConnection, $sql);

        $content = array();

        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $commentLoad = $this->commentsLaod($row['contentsID']);
            $row['comment'] = array();
            while ($comments = mysqli_fetch_array($commentLoad, MYSQLI_ASSOC)) {
                array_push($row['comment'], $comments);
            }
            array_push($content, $row);
        }

        echo json_encode(array('result' => true, 'content' => $content));
    }
}

$contents = new contents;
