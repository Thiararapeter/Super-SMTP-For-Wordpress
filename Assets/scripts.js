document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.nav-tab');
    const tabContents = document.querySelectorAll('.super-tab-content');

    // Function to activate a tab and its content
    function activateTab(tab) {
        // Remove the 'active' class from all tabs and tab contents
        tabs.forEach(t => t.classList.remove('nav-tab-active'));
        tabContents.forEach(tc => tc.classList.remove('active'));

        // Add the 'active' class to the selected tab and its corresponding tab content
        tab.classList.add('nav-tab-active');
        const contentId = tab.getAttribute('href').substring(1);
        document.getElementById(contentId).classList.add('active');

        // Store the active tab in sessionStorage
        sessionStorage.setItem('activeTab', contentId);

        // Update the URL with the current tab
        const url = new URL(window.location.href);
        url.searchParams.set('tab', contentId);
        window.history.replaceState({}, '', url);
    }

    // Activate the 'SMTP Settings' tab by default or load the stored active tab
    const defaultTab = document.querySelector('.nav-tab.nav-tab-active');
    const storedTab = sessionStorage.getItem('activeTab') || defaultTab.getAttribute('href').substring(1);

    const url = new URL(window.location.href);
    const urlTab = url.searchParams.get('tab');

    if (urlTab && document.getElementById(urlTab)) {
        activateTab(document.querySelector(`.nav-tab[href="#${urlTab}"]`));
    } else {
        activateTab(defaultTab);
    }

    // Event listeners for tab clicks
    tabs.forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();
            activateTab(tab);
        });
    });
});
