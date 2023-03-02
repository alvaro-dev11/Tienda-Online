const iconShow=document.querySelector('.showHidePw'),
    inputPassword=document.querySelector('.password');

    iconShow.addEventListener('click', ()=>{
        if(inputPassword.type==="password"){
            inputPassword.type="text";

            iconShow.src="assets/icons/eye.svg";
        }else{
            inputPassword.type="password";
            iconShow.src="assets/icons/eye-slash.svg";
        }
    })