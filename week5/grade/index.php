<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .centered-text {
            text-align: center;
            position: relative;
            margin: 20px 0;
        }

        .centered-text::before,
        .centered-text::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #000;
        }

        .centered-text::before {
            left: 0;
        }

        .centered-text::after {
            right: 0;
        }
    </style>
</head>

<body>
    <div class="centered-text">Grade Calculator - On Page</div>

    <form method="post" style="display: flex; flex-direction: column;">
        <label for="subject">Subject: </label>
        <input type="text" name="subject" id="subject">

        <label for="score">Score: </label>
        <input type="number" name="score" id="score">

        <button type="submit">Calculated Grade</button>

    </form>

    <div class="centered-text">Grade Calculator - Another Page</div>

    <?php
    $subject = $_POST["subject"];
    $score = $_POST["score"];

    $getGrade = function ($point) {
        if ($point >= 80) {
            return 'A';
        } elseif ($point >= 70) {
            return 'B';
        } elseif ($point >= 60) {
            return 'C';
        } elseif ($point >= 50) {
            return 'D';
        } else {
            return 'F';
        }
    };

    $grade = $getGrade($score);

    echo "<h2 id='subject'>Subject: $subject</h2>";
    echo "<h2 id='result'>Score: $score</h2>";
    echo "<h2 id='grade'>Grade: $grade</h2>";

    ?>
</body>

</html>