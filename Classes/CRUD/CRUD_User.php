<?php
declare(strict_types=1);

class CRUD_User extends DB_Connection{
    #Singleton
    private static ?CRUD_User $instance = null;
    const NOT_EXIST_EMAIL = 0;
    const CONFIRMED_EMAIL = 1;
    const NON_CONFIRMED_EMAIL = 2;

    #privatr constructor
    private function __construct()
    {
    }

    public static function getInstance() : CRUD_User{
        if (self::$instance ==  null)
            self::$instance = new CRUD_User();
        return self::$instance;
    }

    // Do Validation in form file and then execute this function
    #create new teacher
    public function createTeacher(String $fname, String $lname, String $email, String $password, String $prof_img): Teacher{
        $encryptedPass = password_hash($password,PASSWORD_BCRYPT);
        $teacher = self::TYPE_TEACHER;
        $stat = $this->getConnection()->prepare ("insert into `user` (first_name,last_name,email,password,type,prof_img)
         values('$fname','$lname','$email','$encryptedPass',$teacher,'$prof_img')");
        $stat->execute();
        $id = $this->last_id();
        return new Teacher($id,$fname,$lname,$email,$password,$teacher,$prof_img);
    }

    public function createStd(String $fname, String $lname, String $email, String $password, String $prof_img): Student{
        $encryptedPass = password_hash($password,PASSWORD_BCRYPT);
        $student = self::TYPE_STUDENT;
        $sql = "insert into `user` (first_name,last_name,email,password,type,prof_img) values('$fname','$lname','$email','$encryptedPass',$student,'$prof_img')";
        $this->getConnection()->query($sql);
        $id = $this->last_id();
        return new Student($id,$fname,$lname,$email,$password,$student, $prof_img);
    }

    public function getTeacher($id): Teacher{
        $result = $this->getConnection()->query("select * from `user` where id = $id");
        if ($result->num_rows > 0) {
            while ($t = $result->fetch_assoc()) {
            $fname = $t['first_name'];
            $lname = $t['last_name'];
            $email = $t['email'];
            $prof_img = $t['prof_img'];
            }
        }
        return new Teacher($id,$fname,$lname,$email, "",$prof_img);
    }

    public function getStd($id): Student{
        $result = $this->getConnection()->query("select * from `user` where id = $id");
        if ($result->num_rows > 0) {
            while ($t = $result->fetch_assoc()) {
                $fname = $t['first_name'];
                $lname = $t['last_name'];
                $email = $t['email'];
                $prof_img = $t['prof_img'];
            }
        }
        return new Student($id,$fname,$lname,$email, "",$prof_img);
    }

    public function emailExist($email):bool{
        $emails = $this->getConnection()->query("select email from User where email = '$email'");
        if ($emails->num_rows > 0){
            return true;
        }
        return false;
    }

    public function validEmail($email):int{

        if (!$this->emailExist($email)){
            return self::NOT_EXIST_EMAIL;
        }

        $getEmailQuery = "select * from emails where email = '$email'";
        $result = self::getConnection()->query($getEmailQuery);
        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $is_confirmed = $row['is_confirmed'];
                if ($is_confirmed){
                    return self::CONFIRMED_EMAIL;
                }
                return self::NON_CONFIRMED_EMAIL;
            }
        }
        return self::NOT_EXIST_EMAIL;
    }

    public function getUser($email):User{
        $result = $this->getConnection()->query("select * from `user` where email = '$email'");
        if ($result->num_rows > 0) {
            while ($t = $result->fetch_assoc()) {
                $id = (int) $t['id'];
                $password = $t['password'];
                $fname = $t['first_name'];
                $lname = $t['last_name'];
                $prof_img = $t['prof_img'];
                $type = (int) $t['type'];
            }
        }
        return new User($id,$fname,$lname,$email,$password,$type ,$prof_img);
    }


    ### UPDATE Functions
    public function editFname(int $id, String $fname):string{
        $this->getConnection()->query("update `user` set first_name = '$fname' where id = $id");
        return $fname;
    }

    public function editLname(int $id, String $lname) :string{
        $this->getConnection()->query("update `user` set last_name = '$lname' where id = $id");
        return $lname;
    }

    public function editProfImg(int $id, String $img): String{
        $this->getConnection()->query("update `user` set prof_img = '$img' where id = $id");
        return $img;
    }

    public function editEmail(int $id, String $email): String{
        $this->getConnection()->query("update `user` set email = '$email' where id = $id");
        return $email;
    }

    public function editPass(int $id, String $pass): string{
        $encrypt_pass = md5($pass);
        $this->getConnection()->query("update `user` set password = '$encrypt_pass' where id = $id");
        return $pass;
    }


   ### DELETE Function
    public function deleteUser($id){
        $this->getConnection()->query("Delete from `user` where id = $id");
    }







}





