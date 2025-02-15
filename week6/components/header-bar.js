const navbarTemplate = document.createElement('template');

navbarTemplate.innerHTML = `
<style>
    @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
  </style>
  <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md h-[72px]">
        <div class="flex max-w-screen-lg flex-wrap items-center justify-between mx-auto p-4">
            <a href="./" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="./public/images/school.png" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Student's</span>
            </a>

            <div class="flex w-fit justify-end gap-3">
                <button id="mock-student-btn" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                    Mock
                </button>
                <button id="add-student-btn" class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                    + Add student
                </button>
            </div>
        </div>
    </nav>
`;

class HeaderNavbar extends HTMLElement {
    constructor() {
        super();
    }

    connectedCallback() {
        const shadowRoot = this.attachShadow({ mode: 'closed' });

        shadowRoot.appendChild(navbarTemplate.content.cloneNode(true));
    }
}

customElements.define('header-bar', HeaderNavbar);