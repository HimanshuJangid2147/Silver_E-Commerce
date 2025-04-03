// Create a new JavaScript file: public/js/search.js

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.top-form-control input[name="s"]');
    const searchResultsContainer = document.createElement('div');
    searchResultsContainer.classList.add('search-results-dropdown');
    searchResultsContainer.style.display = 'none';

    // Position the results container
    if (searchInput) {
        const searchForm = searchInput.closest('.top-form-control');
        searchForm.style.position = 'relative';
        searchForm.appendChild(searchResultsContainer);

        let debounceTimer;

        // Add event listener for input
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            // Clear previous timeout
            clearTimeout(debounceTimer);

            // Hide results if query is empty
            if (query.length === 0) {
                searchResultsContainer.style.display = 'none';
                return;
            }

            // Debounce to prevent too many requests
            debounceTimer = setTimeout(() => {
                // Fetch search results
                fetch(`/api/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Build results HTML
                        if (data.length > 0) {
                            let resultsHtml = '<ul class="quick-search-results">';

                            data.forEach(product => {
                                resultsHtml += `
                                    <li>
                                        <a href="/products/${product.slug}/${product.product_id}">
                                            <div class="product-image">
                                                <img src="${product.image}" alt="${product.product_name}">
                                            </div>
                                            <div class="product-info">
                                                <h4>${product.product_name}</h4>
                                                <p class="price">₹${product.price}</p>
                                            </div>
                                        </a>
                                    </li>
                                `;
                            });

                            resultsHtml += `
                                <li class="view-all">
                                    <a href="/search?s=${encodeURIComponent(query)}">
                                        View all results
                                    </a>
                                </li>
                            </ul>`;

                            searchResultsContainer.innerHTML = resultsHtml;
                            searchResultsContainer.style.display = 'block';
                        } else {
                            searchResultsContainer.innerHTML = '<div class="no-results">No products found</div>';
                            searchResultsContainer.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });
            }, 300); // Wait 300ms after user stops typing
        });

        // Close results when clicking outside
        document.addEventListener('click', function(event) {
            if (!searchForm.contains(event.target)) {
                searchResultsContainer.style.display = 'none';
            }
        });
    }
});
