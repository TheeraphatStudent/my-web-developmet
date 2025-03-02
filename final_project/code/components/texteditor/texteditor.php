<?php

namespace FinalProject\Components;

use FinalProject\Components\Component;

require_once(__DIR__ . '/../component.php');

class TextEditor extends Component
{
    private $dest = '';
    private $isEdit = true;

    public function render()
    {
?>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/4.3.0/marked.min.js"></script>

            <style>
                ul {
                    list-style: inside !important;
                }
            </style>
        </head>

        <div class="w-full h-fit overflow-auto <?= (!($this->isEdit) ? 'bg-transparent' : 'bg-dark-primary p-4 shadow-md rounded-lg') ?>">
            <?php if ($this->isEdit): ?>
                <div class="flex flex-wrap gap-2 mb-4 *:px-4 *:h-8 *:bg-white *:text-black *:text-sm *:font-medium *:rounded-sm" id="markdown-toolbar">
                    <button type="button" class="hover:bg-primary" onclick="insertMarkdown('**', '**')">
                        <img src="public/icons/bold.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="insertMarkdown('*', '*')">
                        <img src="public/icons/italic.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="insertMarkdown('# ', '')">
                        <img src="public/icons/heading.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="insertMarkdown('- ', '')">
                        <img src="public/icons/list.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="insertMarkdown('<br>', '')">
                        <img src="public/icons/newline.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="insertMarkdown('- [', ']()')">
                        <img src="public/icons/url.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="insertMarkdown('![image](', ')')">
                        <img src="public/icons/img.svg" class="w-4 h-4" alt="">
                    </button>
                </div>
            <?php endif; ?>

            <div class="flex flex-col md:flex-row w-full h-full border <?= (!($this->isEdit) ? 'border-none' : 'border-white') ?> rounded-md" id="lessScroll">
                <textarea required id="markdown-input" class="p-3 w-full bg-white whitespace-pre border-r focus:outline-none <?= (!($this->isEdit) ? 'hidden' : '') ?>" oninput="updatePreview()" placeholder="ระบุรายละเอียดของงานที่นี่..." style="min-height: 350px;"></textarea>
                <input class="hidden" type="text" name="description" id="desc-input">
                <div id="markdown-preview" class="p-3 w-full <?= ($this->isEdit ? 'bg-primary md:h-full' : 'bg-transparent') ?> overflow-auto text-white"></div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', updatePreview);
            const textarea = document.getElementById('markdown-input');

            textarea.addEventListener('keypress', (e) => {
                console.log(e)

            })

            function updatePreview() {
                // textarea.value = <?= $this->dest ?>;

                // const htmlString = '<p>Hello World</p><p>Hello Human</p>';
                // <\/[^>]+>

                console.log(`<?= addslashes($this->dest) ?>`)

                const text = `<?= addslashes($this->dest) ?>`
                    .replace(/<br\s*\/?>/gi, '\n')
                    .replace(/<h1[^>]*>(.*?)<\/h1>/gi, '# $1\n')
                    .replace(/<(?:em|i)[^>]*>(.*?)<\/(?:em|i)>/gi, '*$1*\n')
                    .replace(/<\/?p>/gi, '')
                    .replace(/<a\s+href="(.*?)">(.*?)<\/a>/gi, '[$2]($1)')
                    .replace(/<li>(.*?)<\/li>/gi, '- $1\n')
                    .replace(/<\/?ul>/gi, '')
                    .replace(/<img\s+src="(.*?)"\s+alt="(.*?)"\s*\/?>/gi, '![$2]($1)')

                console.log(text);

                textarea.defaultValue = text.trim();

                const previewElement = document.getElementById('markdown-preview');

                // marked : ajax libs
                const markdownPrase = marked.parse(textarea.value);
                document.getElementById('desc-input').value = markdownPrase.trim();

                previewElement.innerHTML = markdownPrase;

                // console.log(markdownPrase)
            }

            function insertMarkdown(prefix, suffix) {
                // console.log(prefix)
                // console.log(suffix)

                const textarea = document.getElementById('markdown-input');
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const selectedText = textarea.value.substring(start, end);

                // console.log(start)
                // console.log(end)
                // console.log(textarea.value);

                textarea.value =
                    textarea.value.substring(0, start) +
                    prefix + selectedText + suffix +
                    textarea.value.substring(end);

                updatePreview();

                textarea.focus();

                if (start === end) {
                    textarea.selectionStart = start + prefix.length;
                    textarea.selectionEnd = start + prefix.length;
                } else {
                    textarea.selectionStart = end + prefix.length + suffix.length;
                    textarea.selectionEnd = end + prefix.length + suffix.length;
                }
            }
        </script>
<?php

    }

    public function updatetextarea(string $description = "", bool $isEdit = true)
    {
        $this->dest = $description;
        $this->isEdit = $isEdit;
    }
}
