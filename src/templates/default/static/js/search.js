document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search_input');
    const searchIcon = document.querySelector('.search_icon i');
    const searchCount = document.querySelector('.search_icon p');
    const noResult = document.querySelector('.no-result');

    if (!searchInput) return;

    if (searchCount) searchCount.style.display = 'none';

    const updateResults = () => {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach((row) => {
            const [col1, col2] = [row.cells[0], row.cells[1]];
            const matches = (col1 && col1.innerText.toLowerCase().includes(searchTerm)) ||
                (col2 && col2.innerText.toLowerCase().includes(searchTerm));
            row.setAttribute('visible', matches ? 'true' : 'false');
        });

        const jobCount = document.querySelectorAll('table tbody tr[visible="true"]').length;

        if (searchInput.value === '') {
            if (searchIcon) searchIcon.style.display = '';
            if (searchCount) searchCount.style.display = 'none';
        } else {
            if (searchIcon) searchIcon.style.display = 'none';
            if (searchCount) searchCount.style.display = '';
        }

        if (searchCount) searchCount.textContent = jobCount;

        if (noResult) {
            noResult.style.display = jobCount === 0 ? '' : 'none';
        }
    };

    searchInput.addEventListener('input', updateResults);
    updateResults();
});
