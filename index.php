<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <meta charset="utf-8" />
    <title>My First Web Service</title>
    <link rel="stylesheet" href="./css/cssReset.css" />
    <link rel="stylesheet" href="./css/header.css" />
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="./css/footer.css" />

</head>

<body>
    <!-- 로그인 후 -->
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
    ?>
    <!-- container -->
    <div id="container">
        <section id="introSite">
            <div id="siteComment">
                내가 만드는<br />
                첫 웹서비스에<br />
                어서오세요.
            </div>
            <div id="signUpBtn">
                <p>가입하기</p>
            </div>
        </section>
        <section id="signup">
            <div id="signupCenter">
                <form method="post" action="./database/myMember.php" id="signUpForm">
                    <div class="row">
                        <div class="inputBox">
                            <input type="text" name="userName" id="userName" placeholder="이름" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="inputBox">
                            <input type="email" id="userEmail" name="userEmail" placeholder="이메일" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="inputBox">
                            <input type="password" id="userPw" name="userPw" placeholder="비밀번호" />
                        </div>
                    </div>
                    <div class="row">
                        <label>생일</label>
                        <div class="selectBox">
                            <select name="birthYear" id="birthYear">
                                <option value="">연도</option>
                                <?php
                                $nowYear = date('Y', time());
                                for ($i = $nowYear; $i >= 1900; $i--) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                        <div class="selectBox selectBoxMargin">
                            <select name="birthMonth" id="birthMonth">
                                <option value="">월</option>
                                <?php
                                for ($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                        <div class="selectBox">
                            <select name="birthDay" id="birthDay">
                                <option value="">일</option>
                                <?php
                                for ($i = 1; $i <= 31; $i++) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row genderRow">
                        <div id="genderLabel">
                            <label for="gW" id="gMW">여성</label>
                            <label for="gM" id="gMM">남성</label>
                        </div>
                        <input type="radio" name="gender" class="gender" id="gW" value="w" />
                        <input type="radio" name="gender" class="gender" id="gM" value="m" />
                    </div>
                    <div class="row">
                        <p id="valueError"></p>
                    </div>
                    <div class="row">
                        <div class="submitBox">
                            <input type="submit" id="signUpSubmit" value="가입하기" />
                        </div>
                    </div>
                    <input type="hidden" name="mode" value="save">
                </form>
                <div id="goToLoginBtn">
                    <p>로그인하기</p>
                </div>
            </div>
        </section>
    </div>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
    ?>
</body>
<script src="js/index.js"></script>
<script src="js/valueCheck.js"></script>

</html>