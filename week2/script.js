const getParams = () => {
    console.group('Getting params...');
    var urlParams = new URLSearchParams(window.location.search);
    var content = urlParams.get('content');

    const allContentElements = document.querySelectorAll('[id^="cat"]');
    allContentElements.forEach(element => {
        element.style.display = 'none';
    });

    const containerTarget = document.getElementById(`cat${content}`);
    if (content.match("\\d+")) {
        containerTarget.style.display = 'flex';

    } else {
        allContentElements.forEach(element => {
            element.style.display = 'flex';
        });

    }

    window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth'
    }); 

    console.groupEnd()
}

const onNavigateToContent = (page) => {
    console.group(`+ Navigate to content page ${page} +`);

    const url = new URL(window.location);
    url.searchParams.set('content', page);
    window.history.pushState({}, '', url);

    getParams();

    console.groupEnd();
}