<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width"/>
        <meta charset="utf-8"/>
        <title>My First Web Service</title>
        <link rel="stylesheet" href="./css/cssReset.css"/>
        <link rel="stylesheet" href="./css/header.css"/>
        <link rel="stylesheet" href="./css/index.css"/>
        <link rel="stylesheet" href="./css/footer.css"/>
        
    </head>
    <body>
        <!-- 로그인 후 -->
        <div id="viewType">
            <a href="/myservice/me.html" id="meLink">me</a>
            <a href="/myservice/all.html" id="allLink">all</a>
        </div>
        <header>
            <div id="myService">My First Web Service</div>
            <!-- 로그인 후 -->
            <div id="myName">
                <p>안녕하세요. 홍찬희 님</p>
                <div id="logoutBox">
                    <input type="button" id="logoutBtn" value="로그아웃"/>
                </div>
            </div>
            <!-- 로그인 전 -->
            <div id="loginForm">
                <form name="loginForm" method="post" action="./login.php">
                    <div id="loginEmailArea">
                        <label for="loginEmail">E-Mail</label>
                        <div class="loginInputBox">
                            <input type="email" id="loginEmail" name="email" placeholder="이메일"/>
                        </div>
                    </div>
                    <div id="loginPwArea">
                        <label for="loginPw">Password</label>
                        <div class="loginInputBox">
                            <input type="password" name="userPw" id="loginPw" placeholder="비밀번호 8자 이상 입력"/>
                        </div>
                    </div>
                    <div class="loginSubmitBox">
                        <input type="submit" id="loginSubmit" value="로그인"/>
                    </div>
                </form>
            </div>
        </header>
        <!-- container -->
        <div id="container">
            <section id="introSite">
                <div id="siteComment">
                    내가 만드는<br/>
                    첫 웹서비스에<br/>
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
                                <input type="text" name="userName" id="userName" placeholder="이름"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputBox">
                                <input type="email" id="userEmail" name="userEmail" placeholder="이메일"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="inputBox">
                            <input type="password" id="userPw" name="userPw" placeholder="비밀번호"/>
                            </div>
                        </div>
                        <div class="row">
                            <label>생일</label>
                            <div class="selectBox">
                                <select name="birthYear" id="birthYear">
                                    <option value="">연도</option>
                                    <?php
                                        $nowYear = date('Y',time());
                                        for($i = $nowYear;$i>=1900;$i--){?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                        <?php
                                    }?>                                    
                                </select>
                            </div>
                            <div class="selectBox selectBoxMargin">
                                <select name="birthMonth" id="birthMonth">
                                    <option value="">월</option>
                                    <?php
                                        for($i=1;$i<=12;$i++){?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                        <?php
                                        }?>
                                </select>
                            </div>
                            <div class="selectBox">
                                <select name="birthDay" id="birthDay">
                                    <option value="">일</option>
                                    <?php
                                        for($i=1;$i<=31;$i++){?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                        <?php
                                        }?>
                                </select>
                            </div>
                        </div>
                        <div class="row genderRow">
                            <div id="genderLabel">
                                <label for="gW" id="gMW">여성</label>
                                <label for="gM" id="gMM">남성</label>
                            </div>
                            <input type="radio" name="gender" class="gender" id="gW" value="w"/>
                            <input type="radio" name="gender" class="gender" id="gM" value="m"/>
                        </div>
                        <div class="row">
                            <p id="valueError"></p>
                        </div>
                        <div class="row">
                            <div class="submitBox">
                                <input type="submit" id="signUpSubmit" value="가입하기"/>
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
        <footer>
            <p>My First Web Service</p>
        </footer>
    </body>
    <script src="js/index.js"></script>
    <script type="text/javascript" src="js/valueCheck.js"></script>
</html>