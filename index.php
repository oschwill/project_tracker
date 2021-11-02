<?php

// Root DIR
define('ROOT_DIR', __DIR__);

include 'model/classes/DotEnv.php';
require 'model/database.php';
require 'model/assignments_db.php';
require 'model/course_db.php';

/* INPUT DATA */
$assignment_id = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$course_name = filter_input(INPUT_POST, 'course_name', FILTER_SANITIZE_STRING);

$course_id = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);

if (!$course_id) {
    // if no course_id postet, get course_id from url
    $course_id = filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);
}

/* ROUTE ACTIONS */
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if (!$action) {
        $action = 'list_assignments';
    }
}

/* ROUTING via ACTIONS */
switch ($action) {
    case "list_courses":
        $courses = getCourses();
        include 'view/course_list.php';
        break;
    case "add_course":
        addCourse($course_name);
        header("Location: .?action=list_courses");
        break;
    case "add_assignment":
        if ($course_id && $description) {
            addAssignment($course_id, $description);
            header("Location: .?course_id=$course_id");
        } else {
            $error = "Ungültige Dateneingabe. Überprüfen Sie alle Felder und versuchen Sie es erneut.";
            include 'view/error.php';
            exit();
        }
        break;
    case "delete_course":
        if ($course_id) {
            try {
                deleteCourse($course_id);
            } catch (PDOException $e) {
                $error = "Sie können keinen Kurs löschen, wenn Kursinhalte im Kurs vorhanden sind!";
                include 'view/error.php';
                exit();
            }

            header("Location: .?action=list_courses");
        }
        break;
    case "delete_assignment":
        if ($assignment_id) {
            deleteAssignment($assignment_id);
            header("Location: .?course_id=$course_id");
        } else {
            $error = "Fehlende oder falsche Kursinhalts-ID!";
            include 'view/error.php';
        }
        break;
    default:
        $course_name = getCourseName($course_id);
        $courses = getCourses();
        $assignments = getAssignmentsByCourse($course_id);
        include 'view/assignment_list.php';
        break;
}
