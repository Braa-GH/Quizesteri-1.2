
let email = document.getElementById("email");
let sendBtn = document.getElementById("sendBtn");
let emailErr = document.getElementById("email-err");
const form = document.getElementById("reset-pass-form");

function validEmail(){
    if (email.includes('@') && email.includes('.')){
        emailErr.innerText = "";
        return true;
    }else {
        emailErr.innerText = "*please enter a valid email!";
        return false;
    }
}

email.onchange = ()=>{
    validEmail();
}

function valid() {
    if (validEmail()){
        form.submit();
    }
}