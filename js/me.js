    const meContent = document.querySelector('#meContent');
    const mePostBtn = document.querySelector('#mePostBtn');


    // back end
    const logoutBtn = document.querySelector('#logoutBtn');

    logoutBtn.addEventListener('click',()=>{
        location.href = '/logout.php';
    });

    mePostBtn.addEventListener('click',()=>{
        if(meContent.value == ''){
            alert('내용을 입력하세요.');
            meContent.focus();
            return false;
        }

        
        const url = './database/contents.php';
        const json_file = {method:'POST',headers:{'Content-Type': 'application/json'},
        body:JSON.stringify({mode:"save",meContent: document.querySelector('#meContent').value})};
    
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

function debounce(callback,limit){
    let timeout
    return function(...args){
        clearTimeout(timeout);
        timeout = setTimeout(()=>{
            callback.apply(this,args);
        }, limit);
    }
}

    // 스크롤 80% 도달 시 게시물 더 불러오기 기능 구현
    window.addEventListener('scroll',debounce(()=>{
        const page_num = document.querySelector('#page');
        const nowScroll = window.scrollY;
        const allScroll = document.body.scrollHeight;

        if(page_num.value === '0'){
            return false;
        }
        
        const nowPercent = nowScroll / allScroll * 100;

        if(nowPercent >= 80){
            // const url = '/database/contents.php';
            // const json_file = {method:'POST',headers:{'Content-Type':'application/json'},
            //             body:JSON.stringify({mode:'loadMore',contentsLoadType:'me',page: page_num.value})};
            // fetch(url,json_file)
            //     .then(res=>{return res.json;})
            //     .then(data=>{
            const page_val = page_num.value;
            const url = './database/contents.php';
            // const json_file = {method:'POST',headers:{'Content-Type': 'application/json'},
            // body:JSON.stringify({mode:"save",meContent: document.querySelector('#meContent').value})};
            const json_file = {method:'POST',headers:{'Content-Type':'application/json'},
                            body:JSON.stringify({mode:'loadMore',contentsLoadType:'me',page: page_val})};
            fetch(url,json_file)
                .then(res=>{return res.json();})
                .then(data=>{
                    if(data.result===true){
                        const content = data.content;
                        const center = document.querySelector('#LoadedContents');
                        if(content.length < 20){
                            page_num.value = '0';
                            document.querySelector('#noContents').style.display = 'block';
                        }else{
                            page_num.value = parseInt(page_num.value)+1;
                        }
                        
                        
                        for(let contents in content){
                            let d = new Date(content[contents]['regTime'] * 1000);
                            let month = d.getMonth()+1;
                            let regTime = d.getFullYear()+'년 '+month+'월 '+d.getDate()+'일 '+d.getHours()+'시 '+d.getMinutes()+'분';
                            
                            // 특수기호를 HTML코드로 변경 
                            let bbs = content[contents]['content'];
                            bbs = bbs.replace(/</g,'&lt;');
                            bbs = bbs.replace(/>/g,'$gt;');

                            center.innerHTML += `<div class="reading">
                            <div class="writerArea">
                                <img src="${content[contents]['profilePhoto']}" />
                                <div class="writingInfo">
                                    <p>${content[contents]['userName']}</p>
                                    <div class="writingData">${regTime}</div>
                                </div>
                            </div>
                            <span class="content">${bbs}</span>


                            <div class="likeArea">
                                <div class="likeNum likes 861225" style="background:#fff">공감 수: 250</div>
                                <div class="likeBtn" id="likes 861225">공감하기</div>
                                <div class="contentsID">콘텐츠 번호: 861225</div>
                            </div>

                            <div class="myCommentArea myCommentArea861225">
                                <div class="commentBox">
                                    <img src="./images/me/happyCat.png" />
                                    <p class="commentRegTime">2013년 12월 25일</p>
                                    <p class="commentPoster">홍찬희</p>
                                    <p class="writtenComment">정말 반갑습니다.</p>
                                </div>
                            </div>
                            <div class="inputBox">
                                <img src="${content[contents]['profilePhoto']}" />
                                <input type="text" class="inputComment comments${content[contents]['contentsID']}" placeholder="코멘트 입력" />
                                <div class="regCommentBox">
                                    <input type="button" class="regCommentBtn" id="comments${content[contents]['contentsID']}" value="게시" />
                                </div>
                            </div>
                        </div>`;
                        }
                    }
                })
        }
    },2000));