<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/component.php');


class Breadcrumb extends Component
{
    protected $data;

    // public function __construct($data = [])
    // {
    //     // $this->data = $data;
    //     $this->data = ['Dashboard', 'ตรวจคนเข้างาน', 'AG-25T000001'];
    // }

    public function setPath($data = []) {
        $this->data = $data;

    }

    public function render()
    {
?>
        <ol class="flex items-center whitespace-nowrap">
            <?php
            $totalItems = count($this->data);

            foreach ($this->data as $index => $item) :
                $isLast = $index === $totalItems - 1;
            ?>
                <li class="inline-flex items-center">
                    <?php if (!$isLast) : ?>
                        <a class="flex items-center text-sm text-gray-500 hover:text-secondary focus:outline-none focus:text-secondary dark:text-neutral-500 dark:hover:text-secondary/50 dark:focus:text-secondary/50" href="#">
                            <?php echo htmlspecialchars($item); ?>
                        </a>
                        <svg class="shrink-0 mx-2 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    <?php else : ?>
                        <span class="text-sm font-semibold text-dark-primary truncate dark:text-neutral-200" aria-current="page">
                            <?php echo htmlspecialchars($item); ?>
                        </span>
                    <?php endif; ?>
                </li>

            <?php endforeach; ?>
        </ol>
<?php
    }
}
