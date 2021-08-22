
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
class myMember
{
    protected $dbConnection = null;
    protected $mode;
    protected function dbConnection()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/connect/connect.php';
    }

    function __construct()
    {
        if (isset($_POST['mode'])) {
            $this->mode = $_POST['mode'];
            if ($this->mode == 'save') {
                $this->signUp();
            } else if ($this->mode == 'photo') {
                $this->photoSave();
            }
        } else {
            $data = file_get_contents('php://input');
            $array_data = json_decode($data);
            $this->mode = $array_data->mode;
            if ($this->mode == 'emailCheck') {
                $this->emailCheck($array_data);
            }
        }
    }

    function signUp()
    {
        echo "성공";
        $userName = trim($_POST['userName']);
        if (!preg_match('/^[a-zA-Z가-힣]+$/', $userName)) {
            //echo "<script>alert('올바른 이름이 아닙니다.'); location.href='../index.php';</script>";
            exit;
        }

        $userEmail = trim($_POST['userEmail']);
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            echo "올바른 이메일이 아닙니다.";
            exit;
        }

        $userPw = $_POST['userPw'];
        if ($userPw == '') {
            echo "비밀번호 값이 공백입니다.";
            exit;
        }

        $userPw = sha1('mySalt' . $userPw);

        $birthYear = (int) $_POST['birthYear'];
        if ($birthYear == '') {
            echo "생년 값이 빈값입니다.";
            exit;
        }

        $birthYearCheck = false;
        $thisYear = date('Y', time());
        for ($i = 1900; $i <= $thisYear; $i++) {
            if ($i == $birthYear) {
                $birthYearCheck = true;
                break;
            }
        }
        if ($birthYearCheck == false) {
            echo "올바른 값이 아닙니다.";
            exit;
        }

        $birthMonth = (int) $_POST['birthMonth'];
        if ($birthMonth == '') {
            echo "생월 값이 빈값입니다.";
            exit;
        }

        $birthMonthCheck = false;
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $birthMonth) {
                $birthMonthCheck = true;
                break;
            }
        }

        if ($birthMonthCheck == false) {
            echo "올바른 생월 값이 아닙니다.";
            exit;
        }

        $birthDay = (int) $_POST['birthDay'];
        if ($birthDay == '') {
            echo "생월 값이 빈값입니다.";
            exit;
        }

        $birthDayCheck = false;
        for ($i = 1; $i <= 31; $i++) {
            if ($i == $birthDay) {
                $birthDayCheck = true;
                break;
            }
        }

        if ($birthDayCheck == false) {
            echo "올바른 값이 아닙니다.";
            exit;
        }

        $birth = $birthYear . '-' . $birthMonth . '-' . $birthDay;

        $gender = $_POST['gender'];

        $genderCheck = false;

        switch ($gender) {
            case 'm':
            case 'w':
                $genderCheck = true;
                break;
        }

        if ($genderCheck == false) {
            echo "<script>alert('올바른 성별이 아닙니다.'); location.href='../index.php';</script>";
            exit;
        }

        $this->dbConnection();
        $userName = mysqli_real_escape_string($this->dbConnection, $userName);

        $profilePhoto = '';
        if ($gender == 'm') {
            $profilePhoto = '/images/me/boy.png';
        } else if ($gender == 'w') {
            $profilePhoto = '/images/me/girl.png';
        }

        $coverPhoto = '/images/me/happyCat.png';

        $regTime = time();

        $sql = "INSERT INTO mymember(userName,email,pw,birthDay,gender,profilePhoto,coverPhoto,regTime) ";
        $sql .= "VALUES('{$userName}', '{$userEmail}', '{$userPw}', '{$birth}', '{$gender}', '{$profilePhoto}', '{$coverPhoto}', '{$regTime}')";
        $res = mysqli_query($this->dbConnection, $sql);

        if ($res) {
            $_SESSION['myMemberSes']['email'] = $userEmail;
            $_SESSION['myMemberSes']['userName'] = $userName;
            $_SESSION['myMemberSes']['myMemberID'] = mysqli_insert_id($this->dbConnection);
            $_SESSION['myMemberSes']['profilePhoto'] = $profilePhoto;
            $_SESSION['myMemberSes']['coverPhoto'] = $coverPhoto;
            header("Location:../me.php");
        } else {
            echo "<script>alert('실패123'); location.href='../index.php';</script>";
            exit;
        }
    }
    function emailCheck($array_data)
    {

        $result = false;
        $email = $array_data->userEmail;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM mymember WHERE email = '{$email}'";
            $this->dbConnection();
            $res = mysqli_query($this->dbConnection, $sql);

            if ($res->num_rows == 0) {
                $result = true;
            }
        }

        echo json_encode(array('result' => $result));
    }
    function photoSave()
    {
    }
}
$myMember = new myMember;
