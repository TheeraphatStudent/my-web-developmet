<?php

namespace FinalProject\View\Event;

require_once(__DIR__ . '/../../components/breadcrumb.php');
require_once(__DIR__ . '/../../components/camera/camera.php');

use FinalProject\Components\Breadcrumb;
use FinalProject\Components\QrCodeReader;

$navigate = new Breadcrumb();

$navigate->setPath(['Dashboard', 'ตรวจคนเข้างาน', 'AG-25T000001']);

$qrreader = new QrCodeReader();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">
    <title>Barrier</title>
</head>

<body class="bg-primary flex flex-col justify-center items-center gap-12 pt-[200px] pr-10 pb-[200px] pl-10 w-full h-full">
    <div class="flex flex-col gap-10 w-full max-w-content">
        <?php
        $navigate->render();
        $qrreader->render();
        ?>
    </div>

</body>

</html>