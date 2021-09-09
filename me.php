<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/common/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/database/contents.php';
$myContents = $contents->contentsLoad('me');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>My First Web Service</title>
    <link rel="stylesheet" href="./css/cssReset.css" />
    <link rel="stylesheet" href="./css/header.css" />
    <link rel="stylesheet" href="./css/footer.css" />
    <link rel="stylesheet" href="./css/me.css" />
    <style>
        #myWallPhoto {
            background: url('<?= $_SESSION['myMemberSes']['coverPhoto'] ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: 50% 50%;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
    ?>
    <div id="container">
        <div id="center">
            <div id="myWallPhoto"></div>
            <div id="myProfilePhoto">
                <img src="<?= $_SESSION['myMemberSes']['profilePhoto'] ?>" />
            </div>
            <p id="name"><?= $_SESSION['myMemberSes']['userName'] ?></p>
            <div class="myButtonBox">
                <a href="./log/memberLogs/myLog_1111.txt" download>나의 로그 다운로드</a>
            </div>
            <div class="myButtonBox">
                <form name="photo" method="post" action="/myservice/database/myMember.php">
                    <div class="photoBox">
                        <input type="file" name="myProfilePhoto" class="photoSelectorBtn" />
                    </div>
                    <input type="hidden" name="mode" value="photo">
                    <div class="photoBox">
                        <input type="submit" id="myProfilePhotoUploadBtn" value="프로필 사진 변경">
                    </div>
                </form>
            </div>
            <div class="myButtonBox">
                <form name="photo" method="post" action="/myservice/database/myMember.php" enctype="multipart/form-data">
                    <div class="photoBox">
                        <input type="file" name="myCoverPhoto" class="photoSelectorBtn" />
                    </div>
                    <input type="hidden" name="mode" value="photo" />
                    <div class="photoBox">
                        <input type="submit" id="myCoverPhotoUploadBtn" value="커버 사진 변경" />
                    </div>
                </form>
            </div>
            <div id="myContent">
                <!-- timeline -->
                <div id="writing">
                    <div class="me">
                        <img src="<?= $_SESSION['myMemberSes']['profilePhoto'] ?>" />
                        <p><?= $_SESSION['myMemberSes']['userName'] ?></p>
                    </div>
                    <textarea maxlength="500" id="meContent"></textarea>
                    <div id="inputBox">
                        <input type="button" id="mePostBtn" value="게시" />
                    </div>
                </div>
                <?php
                foreach ($myContents as $mc) {
                ?>
                    <div class="reading">
                        <div class="writerArea">
                            <img src="<?= $mc['profilePhoto'] ?>" />
                            <div class="writingInfo">
                                <p><?= $mc['userName'] ?></p>
                                <div class="writingData"><?= date('Y년 m월 d일 H시 i분', $mc['regTime']) ?></div>
                            </div>
                        </div>
                        <span class="content"><?= nl2br(htmlspecialchars($mc['content'])) ?></span>


                        <div class="likeArea">
                            <div class="likeNum likes<?= $mc['contentsID'] ?>" style="background:#fff">공감 수: 0</div>
                            <div class="likeBtn" id="likes<?= $mc['contentsID'] ?>">공감하기</div>
                            <div class="contentsID">콘텐츠 번호: <?= $mc['contentsID'] ?></div>
                        </div>

                        <div class="myCommentArea myCommentArea<?= $mc['contentsID'] ?>">
                            <?php
                            foreach ($mc['comment'] as $comment) { ?>
                                <div class="commentBox">
                                    <img src="<?= $comment['profilePhoto'] ?>" />
                                    <p class="commentRegTime"><?= date('Y년 m월 d일 H시 i분', $comment['regTime']) ?></p>
                                    <p class="commentPoster"><?= $comment['userName'] ?></p>
                                    <p class="writtenComment"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="inputBox">
                            <img src="<?= $_SESSION['myMemberSes']['profilePhoto'] ?>" />
                            <input type="text" class="inputComment comments<?= $mc['contentsID'] ?>" placeholder="코멘트 입력" />
                            <div class="regCommentBox">
                                <input type="button" class="regCommentBtn" id="comments<?= $mc['contentsID'] ?>" value="게시" />
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <!-- end of timeline -->
                <div id="LoadedContents"> </div>
            </div>
            <input type="hidden" name="page" id="page" value="<?= (($myContents >= 20) ? 1 : 0) ?>" />
        </div>
        <div id="noContents">
            더 이상 콘텐츠가 없습니다.
        </div>
    </div>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
    ?>
</body>
<script src="/js/me.js"></script>

</html>