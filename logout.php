<?php
session_start();

unset($_SESSION['myMemberSes']); // 세션제거


// 세션 제거 됐으면,  index.php 페이지로 이동
if (!isset($_SESSION['myMemberSes'])) {
    header("Location:./index.php");
}
