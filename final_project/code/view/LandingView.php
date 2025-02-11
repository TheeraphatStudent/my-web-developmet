<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../components/navbar.php');

$navbar = new Navbar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../public/style/main.css">
</head>

<body class="bg-primary">
    <div class="flex w-full max-w-content">
        <?php
        $navbar->render();
        ?>
    </div>
</body>

</html>