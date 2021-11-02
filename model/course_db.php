<?php

/* READ METHOD - get all courses */
function getCourses()
{
    global $db;

    $query = 'SELECT * FROM courses ORDER BY id';

    $statement = $db->prepare($query);
    $statement->execute();
    $courses = $statement->fetchAll(); // fetch all records
    $statement->closeCursor();

    return $courses;
}

/* READ METHOD - get courseName by id */
function getCourseName($course_id)
{
    if (!$course_id) {
        return 'Alle Kurse';
    }

    global $db;

    $query = 'SELECT * FROM courses
              WHERE id = :course_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $course = $statement->fetch(); // fetch only one record
    $statement->closeCursor();
    $course_name = $course['courseName'];

    return $course_name;
}

/* DELETE METHOD - delete course by id */
function deleteCourse($course_id)
{
    global $db;

    $query = 'DELETE FROM courses
              WHERE id = :course_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $statement->closeCursor();
}

/* INSERT MEHTOD - add a new course by name */
function addCourse($course_name)
{
    global $db;

    $query = 'INSERT INTO courses (courseName)
              VALUES (:course_name)';

    $statement = $db->prepare($query);
    $statement->bindValue(':course_name', $course_name);
    $statement->execute();
    $statement->closeCursor();
}
