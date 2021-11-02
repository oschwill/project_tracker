<?php

/* READ METHOD - get all Assignments by course */
function getAssignmentsByCourse($course_id)
{
    global $db;

    if ($course_id) {
        $query = 'SELECT A.id, A.description, C.courseName
                  FROM assignments A
                  LEFT JOIN courses C
                  ON A.course_id = C.id
                  WHERE A.course_id = :course_id
                  ORDER BY A.id';
    } else {
        $query = 'SELECT A.id, A.description, C.courseName
                  FROM assignments A
                  LEFT JOIN courses C
                  ON A.course_id = C.id
                  ORDER BY C.id';
    }

    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $assignments = $statement->fetchAll();
    $statement->closeCursor();

    return $assignments;
}

/* DELETE METHOD - delete an assigment */
function deleteAssignment($assignment_id)
{
    global $db;

    $query = 'DELETE FROM assignments
              WHERE id = :assign_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':assign_id', $assignment_id);
    $statement->execute();
    $statement->closeCursor();
}

/* CREATE METHOD - create an assignment */
function addAssignment($course_id, $description)
{
    global $db;

    $query = 'INSERT INTO assignments (description, course_id)
              VALUES (:description, :course_id)';

    $statement = $db->prepare($query);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $statement->closeCursor();
}
