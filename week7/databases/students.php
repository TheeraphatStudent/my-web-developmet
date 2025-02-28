<?php

function getStudents(): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'select * from students';
    $result = $conn->query($sql);
    return $result;
}

function getStudentById(int $id): array|bool
{
    $conn = getConnection();
    $sql = 'select * from students where student_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        return false;
    }
    return $result->fetch_assoc();
}

