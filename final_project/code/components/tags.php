<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/component.php');

use FinalProject\Components\Component;

class Tags extends Component
{
    private string $text;
    private const TAGS_THEME = [
        'reject' => [
            "text" => "text-red",
            "background" => "bg-light-red"
        ],
        'pending' => [
            "text" => "text-yellow",
            "background" => "bg-light-yellow"
        ],
        'accepted' => [
            "text" => "text-primary",
            "background" => "bg-light-green"
        ],
    ];

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function render()
    {
?>
        <span class="<?= self::TAGS_THEME[$this->text]['text'] . ' ' .self::TAGS_THEME[$this->text]['background'] . ' py-1 px-2 rounded-md ' ?>">
            <?= $this->text; ?>
        </span>
<?php

    }
}
