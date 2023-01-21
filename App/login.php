<?php
session_start();
require_once "../Classes/DB_Connection.php";
require_once "../Classes/CRUD/CRUD_User.php";
require_once "../Classes/User.php";
$alertsShow = "";
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['status'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
    }else{
        echo "<script>emailErr.innerText = 'Please enter a valid Email'</script>";
    }

    function login(){
        global $email,$status,$alertsShow,$password;
        $user = CRUD_User::getInstance()->getUser($email);
        if ($user->getType() != $status){
            $type = $status == DB_Connection::TYPE_TEACHER ? "teacher" : "student";
            $alertsShow .="
                         <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                               This user is not a $type!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                       </div>
            ";
        }else{
            if (password_verify($password, $user->getPassword())){
                $_SESSION['login'] = true;
                switch ($user->getType()){
                    case DB_Connection::TYPE_TEACHER:
                        header("Location:index.php?ud=".$user->getId());
                        break;
                    case DB_Connection::TYPE_STUDENT:
                        // go to student page
                        break;
                }
            }else{
                $alertsShow .="
                         <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            Incorrect password!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                       </div>
            ";
            }
        }
    }

    switch (CRUD_User::getInstance()->validEmail($email)){
        case CRUD_User::CONFIRMED_EMAIL:
            login();
        break;
        case CRUD_User::NON_CONFIRMED_EMAIL:
            $alertsShow .="
                         <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                Your email is not confirmed yet, you should confirm your email, check your email inbox!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                       </div>
            ";
        break;
        case CRUD_User::NOT_EXIST_EMAIL:
            $alertsShow .="
                         <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            This email has no account, please create new account first!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                       </div>
            ";
        break;
    }


}


?>


<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Quizester - Home</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page_auth.css" />
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>

<body style="">

    <main class="container-xxl p-4">
        <div class=" container-p-x">
            <div class="authentication-inner row">

                <div class="col-12 p-0 p-md-2 mt-5">

                    <h1 class="text-center text-black fw-bold" style="font-family: 'Berlin Sans FB'"> - Welcome To Quizester - </h1>
                     <div class="row d-flex justify-content-center mb-3">


                       <div class="col-12 col-sm-8 mt-3 mt-sm-0 p-3 p-sm-5 bg-black rounded">
                           <div class="">

                               <form id="loginForm" action="" method="post" enctype="application/x-www-form-urlencoded" class="position-relative">
                                    <!-- email -->
                                   <div class="alerts"><?= $alertsShow ?></div>
                                   <div class="my-2">
                                       <label for="email" class="text-white form-label">Email</label>
                                       <input type="email" id="email" name="email" value="<?= $email??'' ?>" class="form-control">
                                       <span id="email-error" class="text-danger"></span>
                                   </div>

                                   <!-- password -->
                                   <div class="my-2">
                                       <label for="password" class="text-white form-label">Password</label>
                                       <div class="form-password-toggle">
                                           <div class="input-group input-group-merge">
                                               <input type="password" name="password" id="password" value="<?= $password??''?>" class="form-control">
                                               <span class="input-group-text cursor-pointer" id="basic-default-password">
                                          <i class="bx bx-hide"></i>
                                      </span>
                                           </div>
                                           <span id="pass-error" class="text-danger"></span>
                                       </div>
                                   </div>

                                   <!-- status -->
                                   <div class="my-2">
                                       <label class="text-white form-check-label">Status:</label>
                                       <div class="d-flex flex-row justify-content-start gap-3">

                                           <div class="">
                                               <div class="position-relative">
                                                   <label class="status-select rounded border border-1 border-label-primary text-white fw-bold fs-6 p-4 cursor-pointer" id="student-box" for="student-select">Student</label>
                                                   <input type="radio" class="form-check-input radio cursor-pointer" name="status" value="<?= DB_Connection::TYPE_STUDENT ?>" id="student-select">
                                               </div>
                                           </div>

                                           <div class="">
                                               <div class="position-relative">
                                                   <label class="status-select rounded border border-1 border-label-primary text-white fw-bold fs-6 p-4 cursor-pointer" id="teacher-box" for="teacher-select">Teacher</label>
                                                   <input type="radio" class="form-check-input radio cursor-pointer" name="status" value="<?= DB_Connection::TYPE_TEACHER ?>" id="teacher-select">
                                               </div>
                                           </div>
                                       </div>
                                       <span id="status-error" class="text-danger"></span>
                                   </div>

                                   <!-- remember me -->
                                    <div class="my-2">
                                       <label for="remember" class="text-white form-check-label">Remember me</label>
                                       <input type="checkbox" role="switch" id="remember" class="form-check-input">
                                   </div>

                                   <!-- submit -->
                                   <div class="my-2 d-flex gap-2">
                                       <button type="button" class="btn btn-primary w-100" id="sbmtBtn">login</button>
                                       <button type="reset" class="btn btn-secondary">reset</button>
                                   </div>
                               </form>

                               <p class="text-white-50">
                                   Forgot your password?
                                   <a href="forgot-password.php">click here to retrieve it!</a>
                               </p>

                               <p class="text-center text-white mb-0 pt-3">Don't have account? <a href="newAccount.php" class="text-success text-decoration-underline">create one!</a></p>
                           </div>



                   </div>
                </div>
            </div>
        </div>

    </main>



    <script>
        let email = document.getElementById("email");
        let password = document.getElementById("password");
        const std_radio = document.getElementById("student-select");
        const teacher_radio = document.getElementById("teacher-select");
        const loginForm = document.getElementById("loginForm");
        const submitBtn = document.getElementById("sbmtBtn");
        let emailErr = document.getElementById("email-error");
        let passErr = document.getElementById("pass-error");
        let statusErr = document.getElementById("status-error");
        function validEmail() {
            if (!email.value.includes("@") || !email.value.includes(".")){

                emailErr.innerText = "*please enter valid email";
                email.classList.remove("is-valid")
                email.classList.add("is-invalid")
                return false;
            }else {

                emailErr.innerText = "";
                email.classList.remove("is-invalid")
                email.classList.add("is-valid")
                return true;
            }
        }
        email.onchange = ()=>{
            validEmail();
        }

        function validPassword() {
            if (password.value.length < 8 || password.value.search(/[a-z]/) < 0 || password.value.search(/[A-Z]/) < 0 || password.value.search(/[0-9]/) < 0 ){
                passErr.innerText = "*password should be at least 8 characters and contain upper and small chars and at least one number";
                password.classList.remove("is-valid")
                password.classList.add("is-invalid")
                return false;
            }else {
                passErr.innerText = "";
                password.classList.remove("is-invalid")
                password.classList.add("is-valid");
                return true;
            }
        }
        password.onchange = () =>{
            validPassword();
        }

        function validStatus() {
            if (std_radio.checked || teacher_radio.checked){
                statusErr.innerText = "";
                return true;
            }else {
                statusErr.innerText = "*please check your personality!";
                return false;
            }
        }

        submitBtn.onclick = function (){
            if (validEmail() && validPassword() && validStatus()){
                loginForm.submit();
            }
        }

    </script>




<!--    <div id="statuses-container" class="p-5">-->
<!--        <div class="container">-->
<!--            <div class="row rounded bg-black" style="background-color: #eee">-->
<!--                <div class="col-12 col-md-6 p-5">-->
<!--                    <div class="card bg-transparent">-->
<!--                        <div class="col-10 h-100 m-auto">-->
<!--                            <img src="../assets/img/avatars/std.webp" class="img-fluid">-->
<!--                        </div>-->
<!--                        <span class="text-white text-center fs-large fw-bold d-inline-block p-1" style="letter-spacing: 2px">Students gate</span>-->
<!--                        <button id="std-status" class="btn btn-secondary mt-2" style="border-radius: 0">Student</button>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                <div class="col-12 col-md-6 p-5">-->
<!--                    <div class="card bg-transparent">-->
<!--                        <div class="col-10 m-auto">-->
<!--                            <img src="../assets/img/avatars/female-teacher.webp" class="img-fluid">-->
<!--                        </div>-->
<!--                        <span class="text-white text-center fs-large fw-bold d-inline-block p-1" style="letter-spacing: 2px">Instructors gate</span>-->
<!--                        <button id="teacher-status" class="btn btn-secondary mt-2" style="border-radius: 0">Instructor</button>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->












<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/vendor/js/menu.js"></script>
<script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="../assets/js/main.js"></script>
<script>


    const std_box = document.getElementById("student-box");
    const teacher_box = document.getElementById("teacher-box");

    std_radio.onchange = () =>{
        teacher_box.classList.add("border-label-primary");
        teacher_box.classList.remove("border-primary");

        std_box.classList.add("border-primary");
        std_box.classList.remove("border-label-primary");
    }

        teacher_radio.onchange = () =>{
        std_box.classList.add("border-label-primary");
        std_box.classList.remove("border-primary");

        teacher_box.classList.add("border-primary");
        teacher_box.classList.remove("border-label-primary");
    }
</script>


<!--<script>-->
<!--    document.getElementById('changeStatusBtn').onclick = function () {-->
<!--        document.querySelector("main").style.display = "none";-->
<!--        document.getElementById("statuses-container").classList.remove("d-none");-->
<!--        document.getElementById("statuses-container").classList.add("d-block");-->
<!--    }-->
<!---->
<!--    document.getElementById('std-status').onclick = function (){-->
<!--        document.getElementById("status-text").innerText = "Students gate";-->
<!--        document.getElementById("status-img").src = "../assets/img/avatars/std.webp";-->
<!--        document.querySelector("main").style.display = "block";-->
<!--        document.getElementById("statuses-container").classList.add("d-none");-->
<!--        document.getElementById("statuses-container").classList.remove("d-block");-->
<!--    }-->
<!---->
<!--    document.getElementById('teacher-status').onclick = function (){-->
<!--        document.getElementById("status-text").innerText = "Teachers gate";-->
<!--        document.getElementById("status-img").src = "../assets/img/avatars/female-teacher.webp";-->
<!--        document.querySelector("main").style.display = "block";-->
<!--        document.getElementById("statuses-container").classList.add("d-none");-->
<!--        document.getElementById("statuses-container").classList.remove("d-block");-->
<!--    }-->
<!---->
<!---->
<!--</script>-->

</body>
</html>