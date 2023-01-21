<?php

class Student extends User{


    public function getCourses(): array{
        return CRUD_Course::getInstance()->getStdCourses($this->getId());
    }


    public function signOutCourse(int $course_id){
      CRUD_Course::getInstance()->signStdOutCourse($this->getId(),$course_id);
    }

    public function enrollCourse(int $course_id){
        CRUD_Course::getInstance()->signStdToCourse($this->getId(), $course_id);
    }

}













