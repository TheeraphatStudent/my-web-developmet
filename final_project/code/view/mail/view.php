<?php

namespace FinalProject\View;


require_once('components/breadcrumb.php');

use FinalProject\Components\Breadcrumb;
$navigate = new Breadcrumb();


// print_r($allaboutmail);


?>

<!DOCTYPE html>
<html lang en>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Mail</title>
    </head>
    


    <body class="flex flex-col justify-start items-center bg-primary">
    <div class="flex flex-col w-full gap-14 max-w-content py-[200px] px-10 xl:px-0">
     
 <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">

    <span value="<?php echo htmlspecialchars($allaboutmail['title']) ?>"></span>
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-white text-gray-600 uppercase text-xs *:py-3 *:px-4 border-2">
                                <th class="text-left">Event Photos</th>
                                <th class="text-left">About Event</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>

                        <?php foreach (array_reverse([]) as $about): ?>
                            <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden *:truncate">
                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= $about['title'] ?></td>
                </tr>
                <?php endforeach ?>


                        <tbody>
                        <tr>
                                <td colspan="7" class="py-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <a href="../?action=event.create" class="text-primary hover:text-primary/80 font-semibold text-3xl underline decoration-primary">
                                            Join Event?
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    </div>

   

    </div>
            <!-- </div> -->

    </body>
</html>