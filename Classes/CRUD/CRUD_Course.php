<?php
declare(strict_types = 1);

class CRUD_Course extends DB_Connection{
    # Singleton Design Pattern

    private static ?CRUD_Course $instance = null; #static object(single object for all classes)

    // private constructor
    private function __construct()
    {
    }


    public static function getInstance():CRUD_Course{
        if (self::$instance == null){
            self::$instance = new CRUD_Course();
        }
        return self::$instance;
    }

    #get courses of specific teacher
    public function getTeacherCourses(int $teacher_id): array{
        $courses = array();
        $result = $this->getConnection()->query("select * From Course where teacher_id = $teacher_id");
        if ($result->num_rows > 0){
            while ($c = $result->fetch_assoc()){
                $c_id = (int) $c['id'];
                $c_name = $c['course_name'];
                $c_desc = $c['description'];
                $c_code = $c['code'];
                $obj = new Course($c_id, $c_name, $c_desc, $c_code);
                $courses[$c_code] = $obj;
            }
        }
        return $courses;
    }

    public function getStdCourses(int $std_id) :array{
        $courses = array();
        $result = $this->getConnection()->query("select course_id, date_created from student_course where std_id = $std_id");
        if ($result->num_rows > 0){
            while ($c = $result->fetch_assoc()){
                $c_id = $c['course_id'];
                $date_created = $c['date_created'];
                $courses[$c_id] = $date_created;
            }
        }
        return $courses;
    }

    # add new Course function
    public function createCourse(String $name, String $description, String $code, int $teacher_id){
        //prepared statement
        $statement = $this->getConnection()->prepare("insert into Course (course_name, description, code, teacher_id) values(? ,?, ?, ?)");
        #string, string, string, int
        $statement->bind_param("sssi", $course_name, $course_description, $course_code, $tech_id);
        $course_name = $name;
        $course_description = $description;
        $course_code = $code;
        $tech_id = $teacher_id;
        $statement->execute();
        $statement->close();
    }

    #update Course
    public function updateCourse(int $course_id, String $newName, String $newDesc){
        $statement = $this->getConnection()->prepare("update Course SET course_name = ? , description = ? WHERE id = ?");
        $statement->bind_param("ssi", $course_name, $description, $id);
        $id = $course_id;
        $course_name = $newName;
        $description = $newDesc;
        $statement->execute();
        $statement->close();
    }

    #update Course name
    public function updateCourseName(int $course_id, String $newName){
        $statement = $this->getConnection()->prepare("update Course SET course_name = ? WHERE id = ?");
        $statement->bind_param("si", $course_name,$id);
        $id = $course_id;
        $course_name = $newName;
        $statement->execute();
        $statement->close();
    }

    #update Course Description
    public function updateCourseDesc(int $course_id, String $newDesc){
        $statement = $this->getConnection()->prepare("update Course SET description = ? WHERE id = ?");
        $statement->bind_param("si", $description,$id);
        $id = $course_id;
        $description = $newDesc;
        $statement->execute();
        $statement->close();
    }

    #delete course
    public function deleteCourse(int $course_id){
        $this->getConnection()->query("delete from Course where id = $course_id");
    }

    public function signStdToCourse(int $std_id, int $course_id){
        $this->getConnection()->query("insert into student_course (std_id, course_id) values ($std_id, $course_id)");
    }

    public function signStdOutCourse(int $std_id, int $course_id){
        $this->getConnection()->query("delete from student_course where std_id = $std_id and course_id = $course_id");
    }


}