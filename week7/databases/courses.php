<?php

function getCourses(): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'select * from courses';
    $result = $conn->query($sql);
    return $result;
}
