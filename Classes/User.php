<?php

 class User{
    private int $id;
    private String $firstName;
    private String $lastName;
    private String $email;
    private String $password;
    private int $type;
    private String $prof_img;

    public function __construct(int $id, string $firstName, string $lastName, string $email, string $password, int $type, string $prof_img)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->prof_img = $prof_img;
        $this->type = $type;
    }


    public function getId():int{
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }
    public function getFirstName(): String{
        return $this->firstName;
    }
    public function setFirstName(String $fname){
        $this->firstName = $fname;
    }

    public function getLastName(): String{
        return $this->lastName;
    }

    public function setLastName(String $lName){
        $this -> lastName = $lName;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function getPassword(): string{
        return $this->password;
    }


    public function setPassword(string $password): void{
        $this->password = $password;
    }

    public function getProfImg(): string{
        return $this->prof_img;
    }

    public function setProfImg(string $prof_img): void{
        $this->prof_img = $prof_img;
    }


     public function getType(): int{
         return $this->type;
     }

     public function setType(int $type): void{
         $this->type = $type;
     }



}