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

// 회원가입 입력 정보 필터링

function timeOutCall(){
    setTimeout(function(){
        document.querySelector('#valueError').innerText='';
    },2000);
}

// [가입하기] 버튼
const signUpSubmit = document.querySelector('#signUpSubmit');
// 이름 입력 폼
const userName = document.querySelector('#userName');
// 이메일 입력 폼
const userEmail = document.querySelector('#userEmail');
// 비밀번호 입력 폼
const userPw = document.querySelector('#userPw');
// 생년 selectTag 
const birthYear = document.querySelector('#birthYear');
// 생월 selectTag
const birthMonth = document.querySelector('#birthMonth');
// 생일 selectTag
const birthDay = document.querySelector('#birthDay');

// 필터링 시 값이 오류일 때 무엇이 오류인지 보여주는 박스
const valueError = document.querySelector('#valueError');
// [가입하기] 버튼 클릭 이벤트

signUpSubmit.addEventListener('click',(event)=>{
    
    
    if(userEmail.value.length >= 8){
        console.log('exp email good');
    }else{
        valueError.innerText='정확한 이메일 주소를 입력하세요.';
        userEmail.focus();
        timeOutCall();
        event.preventDefault();
        return false;
    }

    // ajax
    let emailCheck = false;
    const url = '/database/myMember.php';  
    const met = {method:'POST',headers:{'Content-Type': 'application/json'},
    body:JSON.stringify({mode:"emailCheck",userEmail: userEmail.value})};
    fetch(url,met)
        .then(res=>{
            try {
                return res.json();
            } catch (error) {
                valueError.innerText="이미 존재하는 이메일 주소입니다.";
                userEmail.focus();
                timeOutCall();
                return false;
            }})
        .then(data=>{
            if(data.result==true){
                console.log(data.result);
            }else{
                valueError.innerText="이미 존재하는 이메일 주소입니다.";
                userEmail.focus();
                timeOutCall();
                return false;
            }});

    

    if(userName.value === ''){
        valueError.innerText='이름을 입력하세요.';
        userName.focus();
        timeOutCall();
        event.preventDefault();
        return false;
    }
    
    if(userPw.value.length >= 8){
        console.log('the value of password is good');
    }else{
        valueError.innerText='비밀번호를 8자 이상 입력하세요.';
        userPw.focus();
        timeOutCall();
        event.preventDefault();
        return false;
    }

    if(birthYear.value === ''){
        valueError.innerText='생년을 입력하세요.';
        birthYear.focus();
        timeOutCall();
        event.preventDefault();
        return false;
    }

    if(birthMonth.value === ''){
        valueError.innerText='생월을 입력하세요.';
        birthMonth.focus();
        timeOutCall();
        event.preventDefault();
        return false;
    }

    if(birthDay.value === ''){
        valueError.innerText='생일을 입력하세요.';
        birthDay.focus();
        timeOutCall();
        event.preventDefault();
        return false;
    }
    
    try{
        if(document.querySelector('input[name="gender"]:checked').value==='w'||
        document.querySelector('input[name="gender"]:checked').value==='m'){
            console.log('gender val good');
        }
    }catch(error){
        valueError.innerText='성별을 선택해주세요.';
        timeOutCall();
        event.preventDefault();
        return false;
    }

    return true;
});