<?php
if (strpos($_SERVER['REQUEST_URI'], 'me.php') || strpos($_SERVER['REQUEST_URI'], 'all.php')) { ?>
    <div id="viewType">
        <a href="../me.php" id="meLink">me</a>
        <a href="../all.php" id="allLink">all</a>
    </div>
<?php
} ?>
<header>
    <div id="myService">My First Web Service</div>
    <?php
    if (isset($_SESSION['myMemberSes'])) { ?>
        <div id="myName">
            <p>안녕하세요. <?= $_SESSION['myMemberSes']['userName'] ?> 님</p>
            <div id="logoutBox">
                <input type="button" id="logoutBtn" value="로그아웃">
            </div>
        </div>
    <?php
    } else {
    ?>
        <div id="loginForm">
            <form name="loginForm" method="post" action="./login.php">
                <div id="loginEmailArea">
                    <label for="loginEmail">E-Mail</label>
                    <div class="loginInputBox">
                        <input type="email" id="loginEmail" name="email" placeholder="이메일">
                    </div>
                </div>
                <div id="loginPwArea">
                    <label for="loginPw">Password</label>
                    <div class="loginInputBox">
                        <input type="password" name="userPw" id="loginPw" placeholder="비밀번호 8자 이상 입력">
                    </div>
                </div>
                <div class="loginSubmitBox">
                    <input type="submit" id="loginSubmit" value="로그인">
                </div>
            </form>
        </div>
    <?php
    }
    ?>
</header>