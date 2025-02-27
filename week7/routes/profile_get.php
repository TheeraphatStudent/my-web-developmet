<?php

$result = getStudentById($_SESSION['student_id']);
$enrollments = getStudentEnrollmentByStudentId($_SESSION['student_id']);

renderView('profile_get',['result' => $result, 'enrollments' => $enrollments]);