<?php
session_start();
$show = "";
if (isset($_GET['u']) and isset($_GET['c'])){
    include_once "../Classes/DB_Connection.php";

    $u = $_GET['u'];
    $c = $_GET['c'];
    $email = $_GET['e'];
    $connection = DB_Connection::getConnection();
    $getQuery = "select * from emails where user_id = $u";
    $result = $connection->query($getQuery);
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $code = $row['code'];
            $is_conf = $row['is_confirmed'];
            $email = $row['email'];
            if ($is_conf){
                $show = "<span class='text-info'>Email is already confirmed ✔</span>";
            }else{
                if ($code === $c){
                    if ($connection->query("update emails SET is_confirmed = true where user_id = $u")){
                        $show = "<span class='text-success'>Email confirmed successfully<br></span>";
                    }else{
                        $show = "<span class='text-danger'>Failed to confirm email!</span>";
                    }
                }else{
                    $show = "<span class='text-danger'>Invalid confirmation code!</span>";
                }
            }
        }

    }else{
        $show = "<span class='text-info'>You Should create account with this email first!</span>";
    }

;
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

<div class="row p-5 justify-content-center">
    <div class="col-8">
        <div class="card p-5">
            <div class="card-body text-center p-5">
                <span class="fs-3"><?= $show ?></span>
                <br>
                <a href ='login.php'>Go To Login Page...</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
