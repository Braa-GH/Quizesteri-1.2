<?php
declare(strict_types=1);

class Course{
    private int $c_id;
    private String $c_name;
    private String $c_description;
    private String $c_code;


    public function __construct(int $c_id, string $c_name, string $c_description, string $c_code){
        $this->c_id = $c_id;
        $this->c_name = $c_name;
        $this->c_description = $c_description;
        $this->c_code = $c_code;
    }

    public function setId(int $id){
        $this->c_id = $id;
    }

    public function getId(): int{
        return $this->c_id;
    }

    public function getName(): string{
        return $this->c_name;
    }

    public function setName(string $c_name): void{
        $this->c_name = $c_name;
    }

    public function getDescription(): string{
        return $this->c_description;
    }

    public function setDescription(string $c_description): void{
        $this->c_description = $c_description;
    }

    public function getCode(): string{
        return $this->c_code;
    }

    public function setCode(string $c_code): void{
        $this->c_code = $c_code;
    }


}
