class MarkdownEditor {
    constructor({
        textareaId, previewId, descInputId
    }) {
        this.textarea = document.getElementById(textareaId);
        this.previewElement = document.getElementById(previewId);
        this.descInput = document.getElementById(descInputId);

        document.addEventListener('DOMContentLoaded', () => this.updatePreview());
        this.textarea.addEventListener('keypress', (e) => console.log(e));
    }

    updatePreview(baseText) {
        // const text = `<?= addslashes($this->dest) ?>`
        const text = baseText
            .replace(/<br\s*\/?>/gi, '\n')
            .replace(/<h1[^>]*>(.*?)<\/h1>/gi, '# $1\n')
            .replace(/<(?:em|i)[^>]*>(.*?)<\/(?:em|i)>/gi, '*$1*\n')
            .replace(/<\/?p>/gi, '')
            .replace(/<a\s+href="(.*?)">(.*?)<\/a>/gi, '[$2]($1)')
            .replace(/<li>(.*?)<\/li>/gi, '- $1\n')
            .replace(/<\/?ul>/gi, '')
            .replace(/<img\s+src="(.*?)"\s+alt="(.*?)"\s*\/?>/gi, '![$2]($1)');

        this.textarea.defaultValue = text.trim();
        const markdownPrase = marked.parse(this.textarea.value);
        this.descInput.value = markdownPrase.trim();
        this.previewElement.innerHTML = markdownPrase;
    }

    insertMarkdown(prefix, suffix) {
        const start = this.textarea.selectionStart;
        const end = this.textarea.selectionEnd;
        const selectedText = this.textarea.value.substring(start, end);

        this.textarea.value =
            this.textarea.value.substring(0, start) +
            prefix + selectedText + suffix +
            this.textarea.value.substring(end);

        this.updatePreview();
        this.textarea.focus();

        if (start === end) {
            this.textarea.selectionStart = start + prefix.length;
            this.textarea.selectionEnd = start + prefix.length;
        } else {
            this.textarea.selectionStart = end + prefix.length + suffix.length;
            this.textarea.selectionEnd = end + prefix.length + suffix.length;
        }
    }
}

export default MarkdownEditor;
