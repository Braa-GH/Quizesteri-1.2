<?php

class Teacher extends User{
    public function getCourses(): array{
        return CRUD_Course::getInstance()->getTeacherCourses($this->getId());
    }
}