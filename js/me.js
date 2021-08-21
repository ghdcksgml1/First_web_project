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
    var logoutBtn = document.querySelector('#logoutBtn');

    logoutBtn.addEventListener('click',()=>{
        location.href = '/logout.php';
    });
    // 스크롤 80% 도달 시 게시물 더 불러오기 기능 구현
    
}