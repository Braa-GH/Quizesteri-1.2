<?php
session_start();
if (!isset($_SESSION["creatingAccount"]) and !isset($_SESSION['conf_email']) and !$_SESSION['conf_email']){
    header("Location:login.php");
    exit();
}

$show = "";
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['email']) && isset($_GET['id']) && isset($_GET['fname'])){
        $email = $_GET['email'];
        $fname = $_GET['fname'];
        $id = $_GET['id'];
        $code = md5($email . rand(0,200));//    bin2hex(random_bytes(15));
        $year = date('Y');

        $msg = "
        Hi $fname, <br>
        confirm your email to create your account on quizester
        <a href='https://localhost/Quizesteri-seriously/App/verifyEmail.php?e=$email&c=$code&u=$id'>confirm email</a> <br>
        Quizester &copy; $year
        ";
        $headers = "From: Quizester.com \r\n";
        $headers .= "MIME-Version: 1.0 \r\n";
        $headers .= "Content-type: text/html;charset=UTF-8 \r\n";

        $send = mail($email,"Quizester - Email Verification",$msg,$headers);

        if ($send){
            include_once "../Classes/DB_Connection.php";
            include_once "../Classes/CRUD/CRUD_User.php";
            $connection = DB_Connection::getConnection();

            $validEmail = CRUD_User::getInstance()->validEmail($email);

            if ($validEmail == CRUD_User::NOT_EXIST_EMAIL){
                $sql = "insert into emails (email,code,is_confirmed,user_id) values ('$email','$code',false ,$id)";
                if ($connection->query($sql)) {
                    $show = "We sent you a confirmation email, please check your email inbox!";
                }
            }elseif($validEmail == CRUD_User::CONFIRMED_EMAIL){
                $show = "This Email is already confirmed!";
            }elseif($validEmail == CRUD_User::NON_CONFIRMED_EMAIL){
                $show = "We already sent you a confirmation email, check your inbox!";
            }

        }else{
            $show = "Failed to send you confirmation email!";
        }
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Confirmation - Quizester</title>
    <link rel="stylesheet" href="../assets/vendor/css/core.css">
</head>
<body>

<main >
    <div class="row d-flex justify-content-center align-items-center" style="height: 60vh">
        <div class="col-6 card">
            <div class="card-body text-center">
                <span class="fs-3"> <?= $show ?></span>
                <br/>
                <a href="login.php">Go To Login Page</a>
            </div>
        </div>
    </div>
</main>

</body>
</html>