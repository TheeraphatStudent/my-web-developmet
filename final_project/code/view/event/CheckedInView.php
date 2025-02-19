<?php

namespace FinalProject\View\Event;

require_once(__DIR__ . '/../../components/breadcrumb.php');

use FinalProject\Components\Breadcrumb;

$navigate = new Breadcrumb();

$navigate->setPath(['Dashboard', 'ตรวจคนเข้างาน', 'AG-25T000001']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">
    <title>Barrier</title>
</head>

<body class="bg-primary">
    <?php 
    $navigate->render();
    ?>

</body>

</html>