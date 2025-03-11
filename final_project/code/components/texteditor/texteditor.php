<?php

namespace FinalProject\Components;

use FinalProject\Components\Component;

require_once(__DIR__ . '/../component.php');

class TextEditor extends Component
{
    private $dest = '';
    private $isEdit = true;
    private $editorId = '';

    public function __construct($editorId = null)
    {
        $this->editorId = $editorId ?: 'editor-' . uniqid();
    }

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

        <div class="text-editor-component w-full h-fit overflow-auto <?= (!($this->isEdit) ? 'bg-transparent' : 'bg-dark-primary p-4 shadow-md rounded-lg') ?>" data-editor-id="<?= $this->editorId ?>">
            <?php if ($this->isEdit): ?>
                <div class="editor-toolbar flex flex-wrap gap-2 mb-4 *:px-4 *:h-8 *:bg-white *:text-black *:text-sm *:font-medium *:rounded-sm">
                    <button type="button" class="hover:bg-primary" onclick="TextEditorManager.insertMarkdown('<?= $this->editorId ?>', '**', '**')">
                        <img src="public/icons/bold.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="TextEditorManager.insertMarkdown('<?= $this->editorId ?>', '*', '*')">
                        <img src="public/icons/italic.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="TextEditorManager.insertMarkdown('<?= $this->editorId ?>', '# ', '')">
                        <img src="public/icons/heading.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="TextEditorManager.insertMarkdown('<?= $this->editorId ?>', '- ', '')">
                        <img src="public/icons/list.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="TextEditorManager.insertMarkdown('<?= $this->editorId ?>', '<br>', '')">
                        <img src="public/icons/newline.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="TextEditorManager.insertMarkdown('<?= $this->editorId ?>', '[', ']()')">
                        <img src="public/icons/url.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="TextEditorManager.insertMarkdown('<?= $this->editorId ?>', '![image](', ')')">
                        <img src="public/icons/img.svg" class="w-4 h-4" alt="">
                    </button>
                    <button type="button" class="hover:bg-primary hover:text-white" onclick="TextEditorManager.selectAllContent('<?= $this->editorId ?>')">
                        <img src="public/icons/select-all.svg" class="w-4 h-4" alt="Select All">
                    </button>
                </div>
            <?php endif; ?>

            <div class="editor-container flex flex-col md:flex-row w-full h-full border <?= (!($this->isEdit) ? 'border-none' : 'border-white') ?> rounded-md">
                <textarea required class="editor-input p-3 w-full bg-white whitespace-pre border-r focus:outline-none <?= (!($this->isEdit) ? 'hidden' : '') ?>"
                    oninput="TextEditorManager.updatePreview('<?= $this->editorId ?>')"
                    placeholder="ระบุรายละเอียดของงานที่นี่..."
                    style="min-height: 350px;"
                    data-editor-id="<?= $this->editorId ?>"></textarea>

                <input class="editor-hidden-input hidden" name="description" type="text" name="description-<?= $this->editorId ?>" data-editor-id="<?= $this->editorId ?>">
                <div class="editor-preview p-3 w-full <?= ($this->isEdit ? 'bg-primary h-[clamp(200px, 20vh, 100%)]' : 'bg-transparent') ?> overflow-auto text-white" data-editor-id="<?= $this->editorId ?>"></div>
            </div>
        </div>

        <script>
            if (typeof TextEditorManager === 'undefined') {
                window.TextEditorManager = {
                    editors: {},

                    initEditor: function(editorId, defaultValue = '') {
                        const container = document.querySelector(`.text-editor-component[data-editor-id="${editorId}"]`);
                        if (!container) return;

                        const editor = {
                            container: container,
                            input: container.querySelector('.editor-input'),
                            preview: container.querySelector('.editor-preview'),
                            hiddenInput: container.querySelector('.editor-hidden-input')
                        };

                        this.editors[editorId] = editor;

                        if (defaultValue) {
                            editor.input.value = this.convertHtmlToMarkdown(defaultValue);
                            this.updatePreview(editorId);
                        }

                        this.setupPreviewEvents(editorId);
                    },

                    updatePreview: function(editorId) {
                        const editor = this.editors[editorId];
                        if (!editor) return;

                        const markdownText = editor.input.value;
                        const htmlContent = marked.parse(markdownText);

                        editor.preview.innerHTML = htmlContent;
                        editor.hiddenInput.value = htmlContent.trim();
                    },

                    insertMarkdown: function(editorId, prefix, suffix) {
                        const editor = this.editors[editorId];
                        if (!editor) return;

                        const textarea = editor.input;
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;
                        const selectedText = textarea.value.substring(start, end);

                        textarea.value =
                            textarea.value.substring(0, start) +
                            prefix + selectedText + suffix +
                            textarea.value.substring(end);

                        this.updatePreview(editorId);

                        textarea.focus();

                        if (start === end) {
                            textarea.selectionStart = start + prefix.length;
                            textarea.selectionEnd = start + prefix.length;
                        } else {
                            textarea.selectionStart = start + prefix.length;
                            textarea.selectionEnd = start + prefix.length + selectedText.length;
                        }
                    },

                    selectAllContent: function(editorId) {
                        const editor = this.editors[editorId];
                        if (!editor) return;

                        editor.input.focus();
                        editor.input.select();
                    },

                    setupPreviewEvents: function(editorId) {
                        const editor = this.editors[editorId];
                        if (!editor) return;

                        editor.preview.addEventListener('click', (e) => {
                            const target = e.target;

                            if (target.tagName === 'P') {
                                this.prepareToInsertMarkdownSpecify(editorId, target.textContent);
                            } else if (target.tagName === 'LI') {
                                this.prepareToInsertMarkdownSpecify(editorId, '- ' + target.textContent);
                            } else if (target.tagName === 'H1') {
                                this.prepareToInsertMarkdownSpecify(editorId, '# ' + target.textContent);
                            } else if (target.tagName === 'EM' || target.tagName === 'I') {
                                this.prepareToInsertMarkdownSpecify(editorId, '*' + target.textContent + '*');
                            } else if (target.tagName === 'STRONG' || target.tagName === 'B') {
                                this.prepareToInsertMarkdownSpecify(editorId, '**' + target.textContent + '**');
                            } else if (target.tagName === 'A') {
                                const href = target.getAttribute('href');
                                this.prepareToInsertMarkdownSpecify(editorId, '[' + target.textContent + '](' + href + ')');
                            } else if (target.tagName === 'IMG') {
                                const src = target.getAttribute('src');
                                const alt = target.getAttribute('alt');
                                this.prepareToInsertMarkdownSpecify(editorId, '![' + alt + '](' + src + ')');
                            }
                        });

                        const allElements = editor.preview.querySelectorAll('*');
                        allElements.forEach(function(el) {
                            el.style.cursor = 'pointer';
                        });
                    },

                    prepareToInsertMarkdownSpecify: function(editorId, searchText) {
                        const editor = this.editors[editorId];
                        if (!editor) return;

                        const content = editor.input.value;

                        const index = content.indexOf(searchText);
                        if (index !== -1) {
                            editor.input.focus();
                            editor.input.setSelectionRange(index, index + searchText.length);
                        }
                    },

                    convertHtmlToMarkdown: function(html) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html.trim();

                        let markdown = '';
                        this.handleProcess(tempDiv, markdown);

                        let result = this.applyMarkdownReplacements(tempDiv.innerHTML);
                        return result;
                    },

                    handleProcess: function(parentNode) {},

                    applyMarkdownReplacements: function(html) {
                        return html
                            .replace(/<br\s*\/?>/gi, '\n')
                            .replace(/<h1[^>]*>(.*?)<\/h1>/gi, '# $1\n')
                            .replace(/<(?:em|i)[^>]*>(.*?)<\/(?:em|i)>/gi, '*$1*\n')
                            .replace(/<\/?p>/gi, '')
                            .replace(/<a\s+href="(.*?)">(.*?)<\/a>/gi, '[$2]($1)')
                            .replace(/<li>(.*?)<\/li>/gi, '- $1\n')
                            .replace(/<\/?ul>/gi, '')
                            .replace(/<img\s+src="(.*?)"\s+alt="(.*?)"\s*\/?>/gi, '![$2]($1)')
                            .trim();
                    },

                    getAllContent: function(editorId) {
                        const editor = this.editors[editorId];
                        if (!editor) return null;

                        return {
                            markdown: editor.input.value,
                            html: editor.preview.innerHTML
                        };
                    },

                    queryElements: function(editorId, selector) {
                        const editor = this.editors[editorId];
                        if (!editor) return [];

                        return Array.from(editor.preview.querySelectorAll(selector));
                    }
                };
            }

            document.addEventListener('DOMContentLoaded', function() {
                TextEditorManager.initEditor('<?= $this->editorId ?>', `<?= (addslashes($this->dest)) ?>`);
            });
        </script>
<?php

    }

    public function updatetextarea(string $description = "", bool $isEdit = true)
    {
        $this->dest = $description;
        $this->isEdit = $isEdit;
    }
}
