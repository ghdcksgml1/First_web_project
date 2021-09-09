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

// debounce와 throttle
function debounce(callback,limit){
    let timeout
    return function(...args){
        clearTimeout(timeout);
        timeout = setTimeout(()=>{
            callback.apply(this,args);
        }, limit);
    }
}
function throttle(callback, limit) {
    let waiting = false
    return function() {
        if(!waiting) {
            callback.apply(this, arguments)
            waiting = true
            setTimeout(() => {
                waiting = false
            }, limit)
        }
    }
}
// 댓글 추가하기
document.addEventListener('click',throttle((event)=>{
    const event_id = event.target.id;
    if(event_id.slice(0,8) === 'comments'){
        const commentsID = event_id.slice(8);
        const comment = document.querySelector(`.${event_id}`);

        if(comment.value === ''){
            alert('내용을 입력하세요.');
            return false;
        }

        const url = './database/comments.php';
        const json_file = {method:'POST',headers:{'Content-Type':'application/json'},
                    body:JSON.stringify({mode:'save', contentsID: commentsID, comment: comment.value})};
        fetch(url,json_file)
            .then(res=>{return res.json()})
            .then(data=>{
                if(data.result === true){
                    const d = new Date(data.regTime * 1000);
                    const month = d.getMonth()+1;
                    const regTime = d.getFullYear()+'년 '+month+'월 '+d.getDate()+'일 '+d.getHours()+'시 '+d.getMinutes()+'분';

                    let div = document.createElement('div');
                    div.innerHTML = "";
                    div.innerHTML += `<div class='commentBox'>
                    <img src="${data.profilePhoto}"/>
                    <p class="commentRegTime">${regTime}</p>
                    <p class="commentPoster">${data.poster}</p>
                    <p class="writtenComment">${comment.value}</p>
                    </div>`;

                    document.querySelector(`.myCommentArea${commentsID}`).append(div);
                    comment.value = '';
                }else{
                    alert('댓글 등록 실패');
                }
            });
    }

    // 공감버튼
    if(event_id.slice(0,5) === 'likes'){
        // ID 저장
        const likesID = event_id.slice(5);
        const mode = (event.target.value === 0)?'new':'plus'; // 공감 수가 0이면 new, 1이상이면 plus
    
        const url = './database/likes.php';
        const json_file = {method:'POST',headers:{'Content-Type':'application/json'},
                body:JSON.stringify({mode:mode,contentsID:likesID})};
        fetch(url,json_file)
            .then(res=>{return res.json()})
            .then(data => {
                // data => result, likes, 
                if(data.result === true){
                    event.target.value = `공감 수: ${data.likes}`; // 좋아요 개수
                    document.querySelector(`.${event_id}`).style.background = '#64cbf9';
                }
            });
    }
},200));

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
        const page_val = page_num.value;
        const url = './database/contents.php';
        const json_file = {method:'POST',headers:{'Content-Type':'application/json'},
                        body:JSON.stringify({mode:'loadMore',contentsLoadType:'me',page: page_val})};
        fetch(url,json_file)
            .then(res=>{return res.json();})
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
                        
                        
                    for(let contents in content){
                        const div = document.createElement('div');
                        div.className = "LoadedContents";

                        let d = new Date(content[contents]['regTime'] * 1000);
                        let month = d.getMonth()+1;
                        let regTime = d.getFullYear()+'년 '+month+'월 '+d.getDate()+'일 '+d.getHours()+'시 '+d.getMinutes()+'분';
                            
                        // 특수기호를 HTML코드로 변경 
                        let bbs = content[contents]['content'];
                        bbs = bbs.replace(/</g,'&lt;');
                        bbs = bbs.replace(/>/g,'$gt;');

                        div.innerHTML = `<div class="reading">
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
                        </div>`;
                        
                        for(let commentsNum in content[contents]['comment']){
                            d = new Date(content[contents]['regTime'] * 1000);
                            month = d.getMonth()+1;
                            regTime = d.getFullYear()+'년 '+month+'월 '+d.getDate()+'일 '+d.getHours()+'시 '+d.getMinutes()+'분';
                        
                            
                            div.innerHTML += `<div class="myCommentArea myCommentArea${content[contents]['comment'][commentsNum]['contentsID']}">
                                <div class="commentBox">
                                    <img src="${content[contents]['comment'][commentsNum]['profilePhoto']}" />
                                    <p class="commentRegTime">${regTime}</p>
                                    <p class="commentPoster">${content[contents]['comment'][commentsNum]['userName']}</p>
                                    <p class="writtenComment">${content[contents]['comment'][commentsNum]['comment']}</p>
                                </div>
                            </div>`
                        }
                        div.innerHTML += `<div class="inputBox">
                            <img src="${content[contents]['profilePhoto']}" />
                            <input type="text" class="inputComment comments${content[contents]['contentsID']}" placeholder="코멘트 입력" />
                            <div class="regCommentBox">
                                <input type="button" class="regCommentBtn" id="comments${content[contents]['contentsID']}" value="게시" />
                            </div>
                        </div>
                        </div>`;
                        center.appendChild(div);
                    }
                }
            })
    }
},200));

