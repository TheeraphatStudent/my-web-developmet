<?php
session_start();

interface StudentInfo
{
    public function getUniqID(): string;
    public function getStdID(): string;
    public function getPrefix(): string;
    public function getName(): string;
    public function getYear(): int;
    public function getGrade(): float;
    public function getBirthday(): string;
}

interface StudentProps
{
    public function getAllInfo(): array;
    public function getInfoByUniqId(string $uniqId): ?StudentInfo;
    public function postInfo(StudentInfo $info);
}

class StudentData implements StudentInfo
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getUniqID(): string
    {
        return $this->data['uniq_id'];
    }

    public function getStdID(): string
    {
        return $this->data['stdid'] ?? '';
    }

    public function getPrefix(): string
    {
        return $this->data['prefix'] ?? '';
    }

    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    public function getYear(): int
    {
        return (int)$this->data['year'] ?? '';
    }

    public function getGrade(): float
    {
        return (float)$this->data['grade'] ?? '';
    }

    public function getBirthday(): string
    {
        return $this->data['birthday'] ?? '';
    }
}

class Student implements StudentProps
{
    // private $info;

    // public function __construct()
    // {

    // }

    public function postInfo(StudentInfo $info)
    {
        $uniq_id = $info->getUniqID();
        $stdid = $info->getStdID();
        $prefix = $info->getPrefix();
        $name = $info->getName();
        $year = $info->getYear();
        $grade = $info->getGrade();
        $birthday = $info->getBirthday();

        if (!isset($_SESSION["students"]) || empty($_SESSION["students"])) {
            $students = [];
        } else {
            $students = json_decode($_SESSION["students"], true);
        }

        $students[$uniq_id] = [
            "uniq_id" => $uniq_id,
            "stdid" => $stdid,
            "prefix" => $prefix,
            "name" => $name,
            "year" => $year,
            "grade" => $grade,
            "birthday" => $birthday,
        ];

        $_SESSION["students"] = json_encode($students);
    }

    public function getInfoByUniqId(string $uniqId): StudentInfo
    {
        $students = json_decode($_SESSION["students"], true);
        if (isset($students[$uniqId])) {
            return new StudentData($students[$uniqId]);
        } else {
            return null;
        }
    }

    public function getAllInfo(): array
    {
        $students = [];

        if (isset($_SESSION["students"]) && !empty($_SESSION["students"])) {
            $studentsData = json_decode($_SESSION["students"], true);
            foreach ($studentsData as $data) {
                $students[] = new StudentData($data);
            }
        }

        return $students;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student = new Student();

    $studentInfo = new StudentData($_POST);
    $student->postInfo($studentInfo);

    header("Location: ../pages/view.php");
    exit;
}
