<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/component.php');

class Breadcrumb extends Component
{
    protected $data;
    protected $prevPath;

    public function setPath($prevPath, $data = [])
    {
        $this->data = $data;
        $this->prevPath = $prevPath;
    }

    public function render()
    {
?>
        <ol class="flex items-center whitespace-nowrap overflow-hidden">
            <?php
            $totalItems = count($this->data);

            foreach ($this->data as $index => $item) :
                $isLast = $index === $totalItems - 1;
                $isEarlyLast = $index === $totalItems - 2;
            ?>
                <li class="inline-flex items-center">
                    <?php if (!$isLast) : ?>
                        <a
                            class="flex items-center text-white hover:text-dark-primary focus:outline-none focus:text-dark-primary dark:text-neutral-500 dark:hover:text-dark-primary/50 dark:focus:text-dark-primary/50 no-underline text-2xl"
                            href="../<?= $this->prevPath ?>">
                            <?php echo htmlspecialchars($item); ?>
                        </a>
                        <?php if (!$isEarlyLast) : ?>
                            <svg class="shrink-0 mx-2 size-4 text-white dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        <?php else : ?>
                            <span class="mx-3 text-white dark:text-neutral-600 text-xl">/</span>
                        <?php endif; ?>
                    <?php else : ?>
                        <span class="text-2xl font-semibold text-dark-primary truncate dark:text-neutral-200" aria-current="page">
                            <?php echo htmlspecialchars($item); ?>
                        </span>
                    <?php endif; ?>
                </li>

            <?php endforeach; ?>
        </ol>
<?php
    }
}
?>