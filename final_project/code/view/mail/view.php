<?php

namespace FinalProject\View;


require_once('components/texteditor/texteditor.php');
require_once('components/breadcrumb.php');
require_once('utils/useTags.php');

use FinalProject\Components\TextEditor;

use FinalProject\Components\Breadcrumb;

$navigate = new Breadcrumb();

?>

<!DOCTYPE html>
<html lang en>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script> -->
    <title>Mail</title>
</head>

<body class="flex flex-col justify-start items-center bg-primary">
    <div class="flex flex-col w-full gap-14 max-w-content py-[200px] px-10 xl:px-0">

        <div class="rounded-lg shadow-lg overflow-hidden">
            <div class="flex flex-col p-2.5 gap-2.5">
                <?php foreach (array_reverse($aboutmail) as $about):

                    // print_r($about);
                ?>
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4 p-4 rounded-xl bg-white w-full shadow-sm">
                        <div class="flex flex-col justify-start items-start gap-3 w-full md:w-3/5">
                            <div class="flex items-center gap-2.5 w-full">
                                <div class="rounded-full w-10 h-10 bg-primary/50 flex-shrink-0"></div>
                                <div class="flex flex-col justify-center">
                                    <div class="font-bold text-lg text-black"><?= $about['organizeName'] ?></div>
                                    <div class="font-light text-sm text-neutral-800"><?= $about['start'] ?> - <?= $about['end'] ?></div>
                                </div>
                            </div>

                            <div class="w-full h-14 max-h-14 overflow-y-auto">
                                <h2 class="font-bold text-base text-black mb-1"><?= $about['title'] ?></h2>
                                <?php
                                $editor = new TextEditor();
                                $editor->updatetextarea($about['description'], false);
                                ?>
                                <?php $editor->render(); ?>
                                <?php
                                ?>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2.5 w-full md:w-2/5">
                            <div
                                class="flex flex-col justify-between items-stretch bg-center bg-cover rounded w-full h-36 overflow-hidden bg-dark-primary/50 border-dashed border-primary/60 border-2"
                                style="background-image: url(public/images/uploads/<?= $about['cover'] ?>);">
                                <!-- Tag -->
                                <div class="flex flex-row justify-start items-start gap-2.5 p-2.5 pb-3.5 w-full h-fit bg-gradient-to-b from-dark-primary/50 via-dark-primary/25 to-transparent">
                                    <?php
                                    $selectedTags = [];

                                    if ($about['type'] === 'online' || $about['type'] === 'any') {
                                        $selectedTags[] = "online";
                                    }

                                    if ($about['type'] === 'onsite' || $about['type'] === 'any') {
                                        $selectedTags[] = "onsite";
                                    }

                                    if ($about['venue'] > 0) {
                                        $selectedTags[] = "paid";
                                    } else {
                                        $selectedTags[] = "free";
                                    }

                                    ?>
                                    <?php foreach ($selectedTags as $tag): ?>
                                        <div class='flex justify-center items-center rounded w-16 h-8 shadow-sm <?= $tags[$tag]['background'] ?>'>
                                            <span class='font-kanit text-sm text-center whitespace-nowrap text-opacity-100 leading-none font-normal <?= $tags[$tag]['color'] ?>'>
                                                <?= $tags[$tag]['text'] ?>
                                            </span>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>


                            <!-- Action Buttons -->
                            <div class="flex flex-row justify-start items-center gap-2.5 w-full">
                                <!-- Cancel/Delete Button -->
                                <div class="flex justify-center items-center p-2 rounded-lg bg-light-red">
                                    <img
                                        src="public/icons/delete.svg"
                                        alt="Cancel"
                                        class="w-5 h-5" />
                                </div>

                                <!-- Ticket Button -->
                                <div class="flex justify-between items-center px-4 py-2 rounded-lg bg-primary flex-grow">
                                    <div class="flex items-center gap-2">
                                        <img
                                            class="w-6 h-6"
                                            src="public/icons/ticket.svg"
                                            alt="Ticket" />
                                        <span class="text-sm text-white font-medium">บัตรเข้างาน</span>
                                    </div>
                                    <div class="flex justify-center items-center w-6 h-6">
                                        <img
                                            class="w-3 h-3"
                                            src="public/icons/arrow-right.svg"
                                            alt="Arrow" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach ?>

            </div>
        </div>



    </div>
    <!-- </div> -->

</body>

</html>