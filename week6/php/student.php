<?php

interface StudentProps
{
    public function addedStudent(array $data);
    public function getStudents();
    public function removeStudentByUniqId($uniqId);
    public function getStudentByUniqId($uniqId);
    public function getStudentById($id);
}

class Student implements StudentProps
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function addedStudent(array $data)
    {
        try {
            if (count($data) != 7) {
                return ['status' => 422, 'error' => 'Missing statement'];
            }

            $studentExits = $this->getStudentByUniqId($data['uniq_id']);

            if (isset($studentExits['error']) || !$studentExits) {
                return ['status' => 409, 'error' => 'Student already exists'];

            }

            $field = ['uniq_id', 'stdid', 'prefix', 'name', 'year', 'grade', 'birthday'];
            $container = [];

            foreach ($field as $key) {
                if (!isset($data[$key])) {
                    return ['status' => 422, "error" => "Missing $key"];
                }

                $container[$key] = $data[$key];
            }

            // print_r($container);

            $state = $this->connection->prepare('INSERT INTO students (uniqId, stdid, prefix, name, year, grade, birth) VALUES (:uniqId, :stdid, :prefix, :name, :year, :grade, :birth)');
            // $state->bind_param(':uniq_id', $container['uniq_id'], PDO::PARAM_STR);

            // $state->execute($container);
            $state->execute([
                ':uniqId' => $container['uniq_id'],
                ':stdid' => $container['stdid'],
                ':prefix' => $container['prefix'],
                ':name' => $container['name'],
                ':year' => $container['year'],
                ':grade' => $container['grade'],
                ':birth' => $container['birthday']
            ]);

            $result = $state->fetch(PDO::FETCH_ASSOC);

            return ['status' => 201, 'message' => 'Student added successfully'];
        } catch (PDOException $e) {
            return ['status' => 500, 'error' => $e->getMessage()];
        }
    }

    public function getStudents()
    {
        try {
            $state = $this->connection->prepare("SELECT * FROM students");
            $state->execute();

            $students = $state->fetchAll(PDO::FETCH_ASSOC);

            return ['status' => 200, 'data' => $students];
        } catch (PDOException $e) {
            return ['status' => 500, 'error' => $e->getMessage(), 'data' => []];
        }
    }

    public function getStudentByUniqId($uniqId)
    {
        try {
            $state = $this->connection->prepare("SELECT * FROM students WHERE uniqId = :uniqId");
            // $state->bindParam(':uniqId', $uniqId);
            $state->execute([':uniqId' => $uniqId]);

            $data = $state->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return ['status' => 404, 'error' => 'Student not found', 'data' => null];
            }

            return ['status' => 200, 'Student was found!', 'data' => $data];
        } catch (PDOException $e) {
            return ['status' => 500, 'error' => $e->getMessage(), 'data' => []];
        }
    }

    public function getStudentById($id) {}

    public function removeStudentByUniqId($uniqId) {}
}
