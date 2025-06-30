$(document).ready(function () {
    let selectedIndex = -1;
    let recentSearches = JSON.parse(localStorage.getItem('recentSearches')) || [];
    
    $('#search-input, #search-input-mobile').on('input', function () {
        let query = $(this).val().trim();
        if (query.length > 0) {
            fetchSuggestions(query);
        } else {
            showRecentSearches();
        }
    });

    $('#search-input, #search-input-mobile').on('focus', function () {
        let query = $(this).val().trim();
        if (query.length === 0) showRecentSearches();
    });

    function fetchSuggestions(query) {
        let formAction = searchSuggestionUrl;
        $.ajax({
            url: formAction,
            method: 'GET',
            data: { query: query },
            success: function (data) {
                showGroupedSuggestions(data.suggestions, query);
            },
            error: function () {
                console.log('Error fetching suggestions');
            }
        });
    }

    function showGroupedSuggestions(suggestions, query) {
        let suggestionsList = $('.suggestions');
        suggestionsList.empty();
        selectedIndex = -1;
    
        if (suggestions.length > 0) {
            // Separate suggestions (non-products) and products
            const regularSuggestions = suggestions.filter(s => s.type !== 'product');
            const productSuggestions = suggestions.filter(s => s.type === 'product');
            
            // Add section header for suggestions
            if (regularSuggestions.length > 0) {
                suggestionsList.append('<li class="suggestion-header">Suggestions</li>');
                
                regularSuggestions.forEach(function (suggestion) {
                    let suggestionItem = $('<li>').addClass('suggestion-item').data('title', suggestion.title);
                    suggestionItem.html(`
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center;">
                                <i class="fa fa-search" style="font-size: 14px; margin-right: 5px;"></i>
                                <span class="sugg-p-name">${highlightMatch(suggestion.title, query)}</span>
                            </div>
                            ${suggestion.type === 'recent' ? '<i class="fa fa-times remove-recent" style="cursor: pointer;"></i>' : ''}
                        </div>
                    `);
                    suggestionItem.on('click', function (e) {
                        if (!$(e.target).hasClass('remove-recent')) {
                            selectSuggestion(suggestion.title);
                        }
                    });
                    suggestionsList.append(suggestionItem);
                });
            }
            
            // Add section header for products
            if (productSuggestions.length > 0) {
                suggestionsList.append('<li class="suggestion-header">Products</li>');
                
                productSuggestions.forEach(function (suggestion) {
                    let productUrl = `/products/${suggestion.slug}/${suggestion.attributes_value}`;
                    let suggestionItem = $('<li>').addClass('suggestion-item suggestion-product results--products').data('title', suggestion.title);
                    suggestionItem.html(`
                        <a href="${productUrl}">                                
                            ${suggestion.image ? `
                            <div class="results-products__image grid__image-ratio">
                                <img src="${suggestion.image}" alt="${suggestion.title}">
                            </div>
                            ` : ''}
                            <div class="results-products__info">
                                <span class="pro-sg-name">${highlightMatch(suggestion.title, query)}</span>
                                <span class="grid-product__vendor">${suggestion.category}</span>
                                <span class="grid-product__price">${suggestion.offer_rate}</span>
                            </div>
                        </a>
                    `);
                    suggestionItem.on('click', function () {
                        selectSuggestion(suggestion.title);
                    });
                    suggestionsList.append(suggestionItem);
                });
            }
        } else {
            suggestionsList.append('<li>No suggestions found</li>');
        }
        
        // Handle delete button for recent searches
        $('.remove-recent').on('click', function(e) {
            e.stopPropagation();
            let searchText = $(this).closest('.suggestion-item').data('title');
            recentSearches = recentSearches.filter(item => item !== searchText);
            localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
            showRecentSearches();
        });
        
        suggestionsList.show();
    }

    function showRecentSearches() {
        let suggestionsList = $('.suggestions');
        suggestionsList.empty();
        selectedIndex = -1;

        if (recentSearches.length > 0) {
            suggestionsList.append('<li class="suggestion-header">Recent Searches <span class="clear-all suggestion-clear-btn">Clear all</span></li>');
            
            recentSearches.forEach(function (search) {
                let item = $('<li>')
                    .addClass('suggestion-item')
                    .data('title', search)
                    .html(`
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center;">
                                <i class="fa fa-history" style="font-size: 14px; margin-right: 5px;"></i>
                                <span>${search}</span>
                            </div>
                            
                        </div>
                    `)
                    .on('click', function (e) {
                        if (!$(e.target).hasClass('remove-recent')) {
                            selectSuggestion(search);
                        }
                    });
                suggestionsList.append(item);
            });
            
            // Clear all functionality
            $('.clear-all').on('click', function(e) {
                e.stopPropagation();
                recentSearches = [];
                localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
                suggestionsList.hide();
            });
            
            suggestionsList.show();
        } else {
            suggestionsList.hide();
        }
    }

    function highlightMatch(text, query) {
        let regex = new RegExp('(' + query + ')', 'gi');
        return text.replace(regex, '<span style="color: black; font-weight: bold;">$1</span>');
    }

    function selectSuggestion(value) {
        $('#search-input, #search-input-mobile').val(value);
        saveToRecentSearches(value);
        autoSubmitForm(value);
        $('.suggestions').hide();
    }

    function saveToRecentSearches(value) {
        if (!recentSearches.includes(value)) {
            recentSearches.unshift(value);
            if (recentSearches.length > 5) recentSearches.pop();
            localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
        }
    }

    $('#search-input, #search-input-mobile').on('keydown', function (e) {
        let suggestions = $('.suggestions li.suggestion-item'); 
        if (suggestions.length === 0) return;
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = (selectedIndex + 1) % suggestions.length; 
            updateSuggestionHighlight(suggestions);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = (selectedIndex - 1 + suggestions.length) % suggestions.length; 
            updateSuggestionHighlight(suggestions);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (selectedIndex >= 0) {
                let selectedText = $(suggestions[selectedIndex]).data('title');
                $('#search-input, #search-input-mobile').val(selectedText);
                selectSuggestion(selectedText);
            } else {
                autoSubmitForm($(this).val().trim());
            }
        }
    });
    
    function updateSuggestionHighlight(suggestions) {
        suggestions.removeClass('selected'); 
        if (selectedIndex >= 0) {
            let activeItem = $(suggestions[selectedIndex]);
            activeItem.addClass('selected');
            activeItem[0].scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }
    }

    function autoSubmitForm(query) {
        let form = $('#search-input').is(':focus') 
            ? $('#search-form') 
            : $('#search-mobile-form');
        let actionUrl = form.attr('action') + '?query=' + encodeURIComponent(query);
        window.location.href = actionUrl;
    }

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-box').length) {
            $('.suggestions').hide();
        }
    });
});