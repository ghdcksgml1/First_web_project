window.onload = function(){
    const meContent = document.querySelector('#meContent');
    const mePostBtn = document.querySelector('#mePostBtn');

    mePostBtn.addEventListener('click',()=>{
        if(meContent.value == ''){
            alert('내용을 입력하세요.');
            meContent.focus();
            return false;
        }
    });

    // back end
    const logoutBtn = document.querySelector('#logoutBtn');

    logoutBtn.addEventListener('click',()=>{
        location.href = '/logout.php';
    });

    mePostBtn.addEventListener('click',()=>{
        const url = './database/contents.php';
        // const json_file = {method:'POST',headers:{'Content-Type': 'application/json'},
        // body:JSON.stringify({mode:"save",meContent: document.querySelector('#meContent').value})};
        const json_file = {method:'POST',headers:{'Content-Type':'application/json'},
                        body:JSON.stringify({mode:'loadMore',contentsLoadType:'me',page: 1})};
        fetch(url,json_file)
            .then(res=>{return res.json();})
            .then(data=>{
                if(data.result===true){
                    console.log(data.result);
                    location.reload();
                }else{
                    alert('게시물 등록이 실패했습니다.');
                }});
    });
}

    // 스크롤 80% 도달 시 게시물 더 불러오기 기능 구현
    window.addEventListener('scroll',throttle(()=>{
        const page_num = document.querySelector('#page');
        const nowScroll = window.scrollY;
        const allScroll = document.body.scrollHeight;

        if(page_num.value === 0){
            return false;
        }

        const nowPercent = nowScroll / allScroll * 100;

        if(nowPercent >= 80){
            console.log("80 percent!!");
            const url = '/database/contents.php';
            const json_file = {method:'POST',headers:{'Content-Type':'application/json'},
                        body:JSON.stringify({mode:'loadMore',contentsLoadType:'me',page: page_num.value})};
            fetch(url,json_file)
                .then(res=>{return res.json;})
                .then(data=>{
                    if(data.result===true){
                        const content = data.content;
                        const center = document.querySelector('#center');
                        if(content.length < 20){
                            page_num.value = '0';
                            document.querySelector('#noContents').style.display = 'block';
                        }else{
                            page_num.value = parseInt(page_num.value)+1;
                        }

                        center.innerHTML += `<div class="reading">
                        <div class="writerArea">
                            <img src="<?= $mc['profilePhoto'] ?>" />
                            <div class="writingInfo">
                                <p><?= $mc['userName'] ?></p>
                                <div class="writingData"><?= date('Y년 m월 d일 H시 i분', $mc['regTime']) ?></div>
                            </div>
                        </div>
                        <span class="content"><?= nl2br(htmlspecialchars($mc['content'])) ?></span>


                        <div class="likeArea">
                            <div class="likeNum likes<?= $mc['contentsID'] ?>" style="background:#fff">공감 수: 250</div>
                            <div class="likeBtn" id="likes<?= $mc['contentsID'] ?>">공감하기</div>
                            <div class="contentsID">콘텐츠 번호: <?= $mc['contentsID'] ?></div>
                        </div>

                        <div class="myCommentArea myCommentArea861225">
                            <div class="commentBox">
                                <img src="<?= $_SESSION['myMemberSes']['profilePhoto'] ?>" />
                                <p class="commentRegTime">2013년 12월 25일</p>
                                <p class="commentPoster">홍찬희</p>
                                <p class="writtenComment">정말 반갑습니다.</p>
                            </div>
                        </div>
                        <div class="inputBox">
                            <img src="<?= $_SESSION['myMemberSes']['profilePhoto'] ?>" />
                            <input type="text" class="inputComment comments861225" placeholder="코멘트 입력" />
                            <div class="regCommentBox">
                                <input type="button" class="regCommentBtn" id="comments861225" value="게시" />
                            </div>
                        </div>
                    </div>`;
                    }
                })
        }
    },300));