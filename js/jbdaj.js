const searchInput = document.getElementById('search');
        const clearButton = document.getElementById('clear');
        const searchHistoryList = document.getElementById('search-history');
        const cards = document.querySelectorAll('.card');
        let searchHistory = [];

        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            updateCardsDisplay(searchValue);
        });

        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            updateCardsDisplay('');
        });

        searchInput.addEventListener('change', function() {
            const searchValue = this.value;
            if (searchValue && !searchHistory.includes(searchValue)) {
                searchHistory.push(searchValue);
                updateSearchHistory();
            }
        });

        searchHistoryList.addEventListener('click', function(e) {
            if (e.target.tagName === 'LI') {
                searchInput.value = e.target.textContent;
                updateCardsDisplay(e.target.textContent.toLowerCase());
            }
        });

        function updateCardsDisplay(searchValue) {
            cards.forEach(card => {
                const name = card.getAttribute('data-name').toLowerCase();
                if (name.includes(searchValue)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function updateSearchHistory() {
            searchHistoryList.innerHTML = '';
            searchHistory.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                searchHistoryList.appendChild(li);
            });
        }

    icon.classList.toggle("active");
