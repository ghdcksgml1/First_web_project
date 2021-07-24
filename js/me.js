window.onload = function(){
    const meContent = document.querySelector('#meContent');
    const mePostBtn = document.querySelector('#mePostBtn');

    mePostBtn.addEventListener('click',()=>{
        if(meContent.value == ''){
            alert('내용을 입력하세요.');
            meContent.focus();
            return false;
        }
        // back end
    });
}