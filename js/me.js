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
    
    // 스크롤 80% 도달 시 게시물 더 불러오기 기능 구현
    
}