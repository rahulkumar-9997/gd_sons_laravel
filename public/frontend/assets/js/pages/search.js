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
                showSuggestions(data.suggestions, query);
            },
            error: function () {
                console.log('Error fetching suggestions');
            }
        });
    }

    function showSuggestions(suggestions, query) {
        let suggestionsList = $('.suggestions');
        suggestionsList.empty();
        selectedIndex = -1;
    
        if (suggestions.length > 0) {
            suggestions.forEach(function (suggestion) {
                let suggestionItem = $('<li>').addClass('suggestion-item');
                if (suggestion.image) {
                    suggestionItem.html(`
                        <div style="display: flex; align-items: center;">
                            <div class="suggestion-img">
                                <img src="${suggestion.image}" alt="${suggestion.title}" >
                            </div>
                            <span>${highlightMatch(suggestion.title, query)}</span>
                        </div>
                    `);
                } else {
                    suggestionItem.html(`
                        <div style="display: flex; align-items: center;">
                            <i class="fa fa-search" style="font-size: 14px; margin-right: 5px;"></i>
                            <span>${highlightMatch(suggestion.title, query)}</span>
                        </div>
                    `);
                }
                suggestionItem.on('click', function () {
                    selectSuggestion(suggestion.title);
                });
    
                suggestionsList.append(suggestionItem);
            });
        } else {
            suggestionsList.append('<li>No suggestions found</li>');
        }
        suggestionsList.show();
    }
    

    
    function showRecentSearches() {
        let suggestionsList = $('.suggestions');
        suggestionsList.empty();
        selectedIndex = -1;

        if (recentSearches.length > 0) {
            recentSearches.forEach(function (search) {
                let item = $('<li>')
                    .addClass('suggestion-item')
                    .text(search)
                    .on('click', function () {
                        selectSuggestion(search);
                    });
                suggestionsList.append(item);
            });
            suggestionsList.show();
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
        let suggestions = $('.suggestions li'); 
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
                selectSuggestion($(suggestions[selectedIndex]).text().trim());
            } else {
                //autoSubmitForm($('#search-input').val());
                autoSubmitForm($(this).val().trim());
            }
        }
    });
    
    
    
    function updateSuggestionHighlight(suggestions) {
        suggestions.removeClass('selected'); 
        if (selectedIndex >= 0) {
            let activeItem = $(suggestions[selectedIndex]);
            activeItem.addClass('selected');
            $('#search-input, #search-input-mobile').val(activeItem.text().trim());
        }
    }

   
    function autoSubmitForm(query) {
        //let form = $('#search-form, #search-mobile-form');
        let form = $('#search-input').is(':focus') 
        ? $('#search-form') 
        : $('#search-mobile-form');
        let actionUrl = form.attr('action') + '?query=' + encodeURIComponent(query);
        window.location.href = actionUrl;
    }

    
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-box').length) {
            $('#suggestions').empty().hide();
        }
    });
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.suggestions-list').length) {
            $('.suggestions-list').hide();
            $('.suggestions-list').data('value', null);
        }
    });
});
