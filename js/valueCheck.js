const loginSubmit = document.querySelector('#loginSubmit');
const loginEmail = document.querySelector('#loginEmail');
const loginPw = document.querySelector('#loginPw');

loginSubmit.addEventListener('click',(event)=>{
    if(loginPw.value.length < 8){
        alert('비밀번호를 입력하지 않았거나 8글자 이하입니다.');
        event.preventDefault();
        return false;
    }
});