<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

$dbConnection = mysqli_connect('localhost:3306', 'root', 'hks13579', 'myservice');

$emailCheck = false;
if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $emailCheck = true;
}
if ($emailCheck == false) {
    echo '이메일을 정확히 입력해주세요.';
    header("Location:index.php");
    exit;
}

$userEmail = trim(mysqli_escape_string($dbConnection, $_POST['email']));
$userPw = sha1("mySalt" . $_POST['userPw']);

$sql = "SELECT * FROM mymember WHERE email = '{$userEmail}' AND pw = '{$userPw}'";
$res = mysqli_query($dbConnection, $sql);

if (mysqli_num_rows($res) == 1) {
    $memberInfo = mysqli_fetch_array($res, MYSQLI_ASSOC);
    $_SESSION['myMemberSes'] = array();
    $_SESSION['myMemberSes']['email'] = $memberInfo['email'];
    $_SESSION['myMemberSes']['userName'] = $memberInfo['userName'];
    $_SESSION['myMemberSes']['myMemberID'] = $memberInfo['myMemberID'];
    $_SESSION['myMemberSes']['profilePhoto'] = $memberInfo['profilePhoto'];
    $_SESSION['myMemberSes']['coverPhoto'] = $memberInfo['coverPhoto'];

    if (isset($_SESSION['myMemberSes'])) {
        header("Location:me.php");
    }
} else {
    echo "<script>alert('아이디 혹은 비밀번호가 다릅니다.'); location.href='index.php';
    </script>";
}
