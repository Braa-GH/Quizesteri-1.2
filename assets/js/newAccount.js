
const prof_img = document.querySelector("#prof-img");
const prof_img_file = document.querySelector("#prof-img-file");
const delete_img = document.querySelector("#delete-img");

prof_img_file.onchange = ()=>{
    prof_img.src = window.URL.createObjectURL(prof_img_file.files[0]);
}

delete_img.onclick = function () {
    deleteProfImg();
}
function deleteProfImg() {
    prof_img_file.value = "";
    prof_img.src = "../assets/img/avatars/Sample_User_Icon.png";
}

const std_radio = document.getElementById("student-select");
const std_box = document.getElementById("student-box");
const teacher_radio = document.getElementById("teacher-select");
const teacher_box = document.getElementById("teacher-box");




let ok = 0;
const fname = document.getElementById("fname");
const lname = document.getElementById("lname");
const email = document.getElementById("email");
const password = document.getElementById("password");
const confirm_pass = document.getElementById("confirm-password");
const statusChecked = document.querySelector("input[name ='status']:checked");
const agree = document.getElementById("agree-terms");
const submitBtn = document.getElementById("sbmtBtn");

let fname_valid;
function validFname() {
    if (fname.value.length < 2){
        fname_valid = false;
        document.getElementById("fname-error").innerText = "*first name can not be less than 2 characters";
        fname.classList.remove("is-valid")
        fname.classList.add("is-invalid")
    }else {
        fname_valid = true;
        document.getElementById("fname-error").innerText = "";
        fname.classList.remove("is-invalid")
        fname.classList.add("is-valid")
    }
}

let lname_valid;
function valid_lname() {
    if (lname.value.length < 2){
        lname_valid = false;
        document.getElementById("lname-error").innerText = "*last name can not be less than 2 characters";
        lname.classList.remove("is-valid")
        lname.classList.add("is-invalid")
    }else {
        lname_valid = true;
        document.getElementById("lname-error").innerText = "";
        lname.classList.remove("is-invalid")
        lname.classList.add("is-valid")
    }
}

let email_valid;
function valid_email() {
    if (!email.value.includes("@") || !email.value.includes(".")){
        email_valid = false;
        document.getElementById("email-error").innerText = "*please enter valid email";
        email.classList.remove("is-valid")
        email.classList.add("is-invalid")
    }else {
        email_valid = true;
        document.getElementById("email-error").innerText = "";
        email.classList.remove("is-invalid")
        email.classList.add("is-valid")
    }
}

let pass_valid;
function valid_password() {
    if (password.value.length < 8 || password.value.search(/[a-z]/) < 0 || password.value.search(/[A-Z]/) < 0 || password.value.search(/[0-9]/) < 0 ){
        pass_valid = false;
        document.getElementById("pass-error").innerText = "*password should be at least 8 characters and contain upper and small chars and at least one number";
        password.classList.remove("is-valid")
        password.classList.add("is-invalid")
    }else {
        pass_valid = true;
        document.getElementById("pass-error").innerText = "";
        password.classList.remove("is-invalid")
        password.classList.add("is-valid")
    }
    confirm_password();
}

let conf_pass;
function confirm_password() {
    if (confirm_pass.value !== password.value){
        conf_pass = false;
        document.getElementById("conf-pass-error").innerText = "*passwords are not the same!";
        password.classList.remove("is-valid")
        password.classList.add("is-invalid")

        confirm_pass.classList.remove("is-valid")
        confirm_pass.classList.add("is-invalid")
    }else {
        conf_pass = true;
        document.getElementById("conf-pass-error").innerText = "";
        confirm_pass.classList.remove("is-invalid")
        confirm_pass.classList.add("is-valid")
    }
}

let status_valid;
function valid_status() {
    if (std_radio.checked || teacher_radio.checked){
        status_valid = true;
        document.getElementById("status-error").innerText = "";
    }else {
        status_valid = false;
        document.getElementById("status-error").innerText = "*please check your personality!";
    }
}

let agree_valid;
function valid_agree() {
    if (agree.checked){
        agree_valid = true;
        document.getElementById("terms-error").innerText ="";
    }
    else{
        agree_valid = false;
        document.getElementById("terms-error").innerText = "you should agree our terms and conditions to join our communication!"
    }
}

fname.onchange = () =>{
    validFname();
    console.log(ok)
}

lname.onchange = () =>{
    valid_lname();
    console.log(ok)
}

email.onchange = () =>{
    valid_email();
    console.log(ok)
}

password.onchange = () =>{
    valid_password()
    console.log(ok)
}

confirm_pass.onchange = () =>{
    valid_password();
    confirm_password();
}

std_radio.onchange = () =>{
    valid_status();
    teacher_box.classList.remove("border-label-primary");
    teacher_box.classList.add("border-primary");

    std_box.classList.remove("border-primary");
    std_box.classList.add("border-label-primary");
}

teacher_radio.onchange = () =>{
    valid_status();
    std_box.classList.remove("border-label-primary");
    std_box.classList.add("border-primary");

    teacher_box.classList.remove("border-primary");
    teacher_box.classList.add("border-label-primary");
}

agree.onchange = () =>{
    valid_agree();

}

const form = document.querySelector("form");


form.onreset = () =>{
    const inputs = document.getElementsByTagName("input");
    for (let input of inputs){
        input.classList.remove("is-valid");
        input.classList.remove("is-invalid");
    }
    deleteProfImg();
}

submitBtn.onclick = function () {
    validFname();
    valid_lname();
    valid_email();
    valid_password();
    valid_status();
    valid_agree();

    if (fname_valid && lname_valid && email_valid && pass_valid && conf_pass && status_valid && agree_valid){
        form.submit();
    }else {
        console.log("failed to submit")
    }
}

