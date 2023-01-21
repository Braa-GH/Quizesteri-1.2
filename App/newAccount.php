<?php
session_start();
$_SESSION["is_login"] = null;
$_SESSION["creatingAccount"] = true;

include_once "../Classes/DB_Connection.php";
include_once "../Classes/CRUD/CRUD_User.php";
include_once "../Classes/User.php";
include_once "../Classes/Student.php";
include_once "../Classes/Teacher.php";
$reCaptchErr = "";
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST) && !empty($_POST)){
    $create_user = CRUD_User::getInstance();
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $status = $_POST['status'] ?? 0;
    $img = $_FILES['prof-img'];
    $captcha = $_POST['g-recaptcha-response'];

    #validation
    $create_ok = 1;

    #reCaptcha
    if (isset($_POST['g-recaptcha-response'])){
        $secretKey = "6LfeowYkAAAAAEW52SThqdq77PBjmN7Q5jpmeO6I";
        $response = $_POST['g-recaptcha-response'];
        $id = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$id";
        $fire = file_get_contents($url);
        $fire_data = json_decode($fire);
        if ($fire_data->success){

        }else{
            $create_ok = 0;
            $reCaptchErr = "*please complete reCaptcha!";
        }
    }else{
        $create_ok = 0;
        echo "reCaptcha error";
    }

    #fname
    if (strlen($fname) < 2 or strlen($fname) > 50){
        $create_ok = 0;
//        echo "<h1>fname error</h1>";
    }

    #lname
    if (strlen($lname) < 2 or strlen($lname) > 50){
        $create_ok = 0;
//        echo "<h1>lname error</h1>";
    }

    #email
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $create_ok = 0;
//        echo "<h1>email error</h1>";
    }

    if ($create_user->emailExist($email)){
        $create_ok = 0;
    }

    #password
    if (strlen($password) < 8 or strlen($password) > 50 or !preg_match('/[A-Z]/',$password) or !preg_match('/[a-z]/',$password) or !preg_match('/[0-9]/',$password)){
        $create_ok = 0;
//        echo "<h1>password error</h1>";
    }
    #status
    if (!isset($status)){
        $create_ok = 0;
//        echo "<h1>status error</h1>";
    }

    $upload_ok = 1;
    if (isset($img["name"]) && $img["name"] != ""){
        $target_dir = "../uploads/imgs/profile_imgs";
        $img_name = $img['name'];
        $img_tmp_name = $img['tmp_name'];
        $img_type = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        if (!array_search($img_type, ["jpeg","jpg","png","gif"])){
            $upload_ok = 0;
        }
        $img_name = time() . rand(100, 100000) . $img_name;
    }else{
        $upload_ok = 0;
    }

    if ($create_ok == 1){

        if ($status == "student"){
            $user = $create_user->createStd($fname,$lname,$email,$password,$img_name??"");
        }elseif($status == "teacher"){
            $user = $create_user->createTeacher($fname,$lname,$email,$password,$img_name??"");
        }
        if ($upload_ok == 1){
            move_uploaded_file($img_tmp_name, $target_dir . "/$img_name");
        }
        $id = $user->getId();
        $_SESSION['conf_email'] = true;
        header("Location:sendEmail.php?email=$email&fname=$fname&id=$id");

    }


}


?>




<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/all.min.css">
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
    <link rel="stylesheet" href="../assets/css/all.min.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page_auth.css" />
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Create New Account - Quizester</title>
</head>
<body style="overflow-x: hidden">

<div class="container-xxl p-3 p-lg-5 pt-md-0">

    <div class="authentication-wrapper p-1 my-1 p-md-5 pt-md-1">
        <div class="authentication-inner justify-content-center">
            <div class="bg-body">
                <h1 class="">
                    Quizester / Create New Account</h1>
                <h5 class="ps-2">Create new quizester account and start your adventure 🥇</h5>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>New Profile details</h5>
                </div>
                <form method="post" action="" enctype="multipart/form-data" class="card-body">
                    <div class="upload-img d-flex flex-row align-items-center">
                        <div id="bg-img" class="rounded-circle">
                            <img id="prof-img" src="../assets/img/avatars/Sample_User_Icon.png" class="h-100 w-100 rounded-circle" alt="">
                        </div>
                        <div class="btns ps-3">
                            <label for="prof-img-file" class="btn btn-primary">
                                <span class="d-none d-md-inline">upload image</span>
                                <i class="d-inline d-md-none fa fa-arrow-up-from-bracket"></i>
                            </label>
                            <input id="prof-img-file" name="prof-img" type="file" hidden>
                            <button id="delete-img" class="btn btn-danger">
                                <span class="d-none d-md-inline">Delete image</span>
                                <i class="d-inline d-md-none fa fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row ms-lg-5">
                     <div class="my-1 col-12 col-md-6">
                         <label for="fname">First Name</label>
                         <input type="text" name="fname" class="form-control" id="fname" value="<?= $_POST['fname']?? ''?>" autofocus>
                         <span class="text-danger ps-3" id="fname-error"></span>
                     </div>

                     <div class="my-1 col-12 col-md-6">
                         <label for="lname">Last Name</label>
                         <input type="text" name="lname" class="form-control" value="<?= $_POST['lname']?? ''?>" id="lname">
                         <span class="text-danger ps-3" id="lname-error"></span>
                     </div>
                 </div>

                    <div class="my-1 ms-lg-5 ps-lg-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $_POST['email']?? ''?>" id="email">
                        <span class="text-danger ps-3" id="email-error"></span>
                    </div>

                    <div class="my-1 ms-lg-5 ps-lg-3 form-password-toggle">
                        <label for="password" class="">Password</label>
                        <div class="form-password-toggle">
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" id="password" value="<?= $_POST['password']?? ''?>" class="form-control">
                                <span class="input-group-text cursor-pointer" id="basic-default-password">
                                          <i class="bx bx-hide"></i>
                                </span>
                            </div>
                        </div>
                        <span class="text-danger ps-3" id="pass-error"></span>
                    </div>

                    <div class="my-1 ms-lg-5 ps-lg-3">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" value="<?= $_POST['confirm-password']?? ''?>" class="form-control">
                        <span class="text-danger ps-3" id="conf-pass-error"></span>
                    </div>

                    <div class="my-1 ms-lg-5 ps-lg-3">
                        <label>I am a:</label>
                        <div class="d-flex flex-row justify-content-start gap-2 ">
                            <div class="">
                                <div class="position-relative">
                                    <label class="status-select rounded border border-1 border-primary text-primary fw-bold fs-6 p-4 cursor-pointer" id="student-box" for="student-select">Student</label>
                                    <input type="radio" class="form-check-input radio cursor-pointer" name="status"  value="student" <?= $_POST['status'] =='student'?'checked':''?> id="student-select">
                                </div>
                            </div>

                            <div class="">
                                <div class="position-relative">
                                    <label class="status-select rounded border border-1 border-primary text-primary fw-bold fs-6 p-4 cursor-pointer" id="teacher-box" for="teacher-select">Teacher</label>
                                    <input type="radio" class="form-check-input radio cursor-pointer" name="status" value="teacher" <?= $_POST['status'] =='teacher'?'checked':''?> id="teacher-select">
                                </div>
                            </div>
                        </div>
                        <span class="text-danger ps-3" id="status-error"></span>
                    </div>

<!--                    reCaptcha-->
                    <div class="my-1 ms-lg-5 ps-lg-3"">
                        <div class="g-recaptcha" data-sitekey="6LfeowYkAAAAAMgmH5wBhVsZMe1rl_lV76a_DOwW"></div>
                        <span class="text-danger ps-3 d-block" id="reCaptcha-error"><?=$reCaptchErr?></span>
                    </div>


                    <div class="my-1 ms-lg-5 ps-lg-3">
                        <input type="checkbox" name="agree-terms" id="agree-terms" checked class="form-check-input">
                        <label for="agree-terms">Agree for our <a href="" class="text-decoration-underline">terms and conditions</a></label>
                        <span class="text-danger ps-3 d-block" id="terms-error"></span>
                    </div>


                    <div class="my-lg-3 ms-lg-5 ps-lg-3">
                        <button type="button" id="sbmtBtn" class="btn btn-outline-success">
                            <span>Create Account</span>
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            <span>clear all</span>
                        </button>
                    </div>

            </form>
                <div class="card-footer text-center">
                    <span class="fs-5 text-black">Already have an account ? <a href="login.php">Log in here</a></span>
                </div>
            </div>
        </div>
    </div>
    
</div>











<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/js/all.min.js"></script>

<script src="../assets/vendor/js/menu.js"></script>
<script src="../assets/js/main.js"></script>

<script src="../assets/js/newAccount.js"></script>
</body>
</html>
