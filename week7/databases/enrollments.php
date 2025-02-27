<?php

// function getCourses(): mysqli_result|bool
// {
//     $conn = getConnection();
//     $sql = 'select * from courses';
//     $result = $conn->query($sql);
//     return $result;
// }

function getStudentEnrollmentByStudentId(int $studentId): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'SELECT
    c.course_id,
    c.course_name,
    c.course_code,
    c.instructor,
    e.enrollment_id,
    e.enrollment_date,
    s.student_id
    FROM
    enrollment.courses c
    INNER JOIN enrollment.enrollment e ON
    c.course_id = e.course_id
    INNER JOIN enrollment.students s ON
    e.student_id = s.student_id where s.student_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
