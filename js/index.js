window.onload = function() {
    const signUpBtn = document.querySelector('#signUpBtn');
    const signup = document.querySelector('#signup');
    const loginForm = document.querySelector('#loginForm');
    const introSite = document.querySelector('#introSite');

    signUpBtn.addEventListener('click',()=>{
        // 로그인 폼 숨기기
        loginForm.classList.toggle('signUpBtnClicked');
        // 내가 만드는 첫 웹서비스에 어서오세요. - 문구 숨기기
        introSite.classList.toggle('signUpBtnClicked');
        // 회원가입 폼 보이기
        signup.classList.toggle('signUpBtnClicked');
        
        const clicked = document.querySelectorAll('.signUpBtnClicked');
        clicked[0].style.display='none';
        clicked[1].style.display='none';
        clicked[2].style.display='block';
        
    });

    const goToLoginBtn = document.querySelector('#goToLoginBtn');
    goToLoginBtn.addEventListener('click',()=>{
        const clicked = document.querySelectorAll('.signUpBtnClicked');
        clicked[0].style.display='block';
        clicked[1].style.display='block';
        clicked[2].style.display='none';
        // 로그인 폼 나타내기
        loginForm.classList.toggle('signUpBtnClicked');
        // 내가 만드는 첫 웹서비스에 어서오세요. - 문구 나타내기
        introSite.classList.toggle('signUpBtnClicked');
        // 회원가입 폼 숨기기
        signup.classList.toggle('signUpBtnClicked');  
    });

    const genderWoman = document.querySelector('#gMW');
    const genderMan = document.querySelector('#gMM');
    
    const genderBgInit = () =>{
        genderWoman.style.background='#fff';
        genderMan.style.background='#fff';
        genderWoman.style.color='#000';
        genderMan.style.color='#000';
    };

    genderWoman.addEventListener('click',()=>{
        genderBgInit();
        genderWoman.style.background='#64cbf9';
        genderWoman.style.color='white';
    });

    genderMan.addEventListener('click',()=>{
        genderBgInit();
        genderMan.style.background='#64cbf9';
        genderMan.style.color='white';
    });
};