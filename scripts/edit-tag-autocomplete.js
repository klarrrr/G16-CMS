$(document).ready(function() {
    const tagInput = $('#widget-tags-input');
    const tagsContainer = $('.tags-container');
    let allTags = [];
    let selectedSuggestionIndex = -1;

    function fetchAllTags() {
        $.ajax({
            url: 'php-backend/fetch-all-tags.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                allTags = data;
                console.log("Tags loaded:", data);
            },
            error: function(xhr, status, error) {
                console.error("Error loading tags:", error);
            }
        });
    }

    function showSuggestions(input) {
        clearSuggestions();
        
        if (input.length < 1) return;

        const matches = allTags.filter(tag => 
            tag.toLowerCase().includes(input.toLowerCase()) && 
            !tagsContainer.find('.tag').text().toLowerCase().includes(tag.toLowerCase())
        );

        if (matches.length === 0) return;

        // Inline suggestion
        const prefixMatches = matches.filter(tag => 
            tag.toLowerCase().startsWith(input.toLowerCase())
        );
        
        if (prefixMatches.length > 0) {
            const bestMatch = prefixMatches[0];
            const remaining = bestMatch.substring(input.length);
            
            const measurement = $('<span>').css({
                'position': 'absolute',
                'visibility': 'hidden',
                'white-space': 'pre',
                'font-family': tagInput.css('font-family'),
                'font-size': tagInput.css('font-size'),
                'font-weight': tagInput.css('font-weight'),
                'letter-spacing': tagInput.css('letter-spacing'),
                'padding-left': tagInput.css('padding-left'),
                'border-left-width': tagInput.css('border-left-width')
            }).text(input).appendTo('body');
            
            const textWidth = measurement.width();
            measurement.remove();
            
            const inputPosition = tagInput.position();
            const inputPadding = parseInt(tagInput.css('padding-left')) || 0;
            
            const inlineSuggestion = $(`<span id="tag-suggestion" class="tag-suggestion">${remaining}</span>`);
            
            inlineSuggestion.css({
                'position': 'absolute',
                'left': inputPosition.left + inputPadding + textWidth + 2, 
                'top': inputPosition.top + (tagInput.outerHeight() / 2),
                'z-index': 9999
            });
            
            tagInput.parent().append(inlineSuggestion);
        }

        // Dropdown suggestions
        const dropdown = $(`<div id="tag-suggestions" class="tag-suggestions"></div>`);
        const dropdownList = $('<div class="tag-suggestions-list"></div>');
        
        matches.slice(0, 10).forEach((tag, index) => {
            const item = $(`<div class="tag-suggestion-item" data-index="${index}">${tag}</div>`);
            
            // Highlight matching portion
            if (input.length > 0) {
                const matchStart = tag.toLowerCase().indexOf(input.toLowerCase());
                if (matchStart >= 0) {
                    const before = tag.substring(0, matchStart);
                    const match = tag.substring(matchStart, matchStart + input.length);
                    const after = tag.substring(matchStart + input.length);
                    
                    item.html(`${before}<span class="tag-match">${match}</span>${after}`);
                }
            }
            
            dropdownList.append(item);
        });
        
        dropdown.append(dropdownList);
        
        dropdown.css({
            'position': 'absolute',
            'left': tagInput.position().left,
            'top': tagInput.position().top + tagInput.outerHeight() + 2,
            'width': tagInput.outerWidth(),
            'z-index': 9999
        });
        
        tagInput.parent().append(dropdown);
        
        const maxVisibleItems = 5;
        const itemHeight = 36; 
        const maxHeight = maxVisibleItems * itemHeight;
        
        dropdownList.css({
            'max-height': maxHeight + 'px',
            'overflow-y': 'auto'
        });
    }

    // Add scroll event listener to reposition suggestions on scroll
    $(window).on('scroll', function() {
        if ($('#tag-suggestions').length || $('#tag-suggestion').length) {
            showSuggestions(tagInput.val().trim());
        }
    });

    // Handle keyboard events
    function handleKeyEvents(e) {
        const suggestions = $('.tag-suggestion-item');
        
        switch(e.key) {
            case 'Tab':
                if ($('#tag-suggestion').length) {
                    e.preventDefault();
                    completeInlineSuggestion();
                }
                break;
                
            case 'ArrowDown':
                e.preventDefault();
                navigateSuggestions(1);
                break;
                
            case 'ArrowUp':
                e.preventDefault();
                navigateSuggestions(-1);
                break;
                
            case 'Enter':
                if (selectedSuggestionIndex >= 0) {
                    e.preventDefault();
                    selectSuggestion();
                }
                break;
                
            case 'Escape':
                clearSuggestions();
                break;
        }
    }

    function completeInlineSuggestion() {
        const suggestion = $('#tag-suggestion').text();
        tagInput.val(tagInput.val() + suggestion);
        clearSuggestions();
    }

    function navigateSuggestions(direction) {
        const count = $('.tag-suggestion-item').length;
        if (count === 0) return;
        
        selectedSuggestionIndex += direction;
        
        if (selectedSuggestionIndex < 0) {
            selectedSuggestionIndex = count - 1;
        } else if (selectedSuggestionIndex >= count) {
            selectedSuggestionIndex = 0;
        }
        
        updateSelectedSuggestion();
    }

    function selectSuggestion() {
        const selected = $(`.tag-suggestion-item[data-index="${selectedSuggestionIndex}"]`).text();
        tagInput.val(selected);
        clearSuggestions();
    }

    function updateSelectedSuggestion() {
        $('.tag-suggestion-item').removeClass('selected');
        if (selectedSuggestionIndex >= 0) {
            const selected = $(`.tag-suggestion-item[data-index="${selectedSuggestionIndex}"]`);
            selected.addClass('selected');
            
            // Scroll into view within the dropdown
            const dropdownList = $('.tag-suggestions-list');
            const dropdownHeight = dropdownList.height();
            const itemPosition = selected.position().top;
            const itemHeight = selected.outerHeight();
            
            if (itemPosition < 0) {
                dropdownList.scrollTop(dropdownList.scrollTop() + itemPosition);
            } else if (itemPosition + itemHeight > dropdownHeight) {
                dropdownList.scrollTop(dropdownList.scrollTop() + (itemPosition + itemHeight - dropdownHeight));
            }
        }
    }

    function clearSuggestions() {
        $('#tag-suggestion, #tag-suggestions').remove();
        selectedSuggestionIndex = -1;
    }

    // Initialize
    function setupAutocomplete() {
        tagInput.on('input', function() {
            showSuggestions($(this).val().trim());
        });

        tagInput.on('keydown', handleKeyEvents);

        $(document).on('click', '.tag-suggestion-item', function() {
            tagInput.val($(this).text());
            clearSuggestions();
            tagInput.focus();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#widget-tags-input, #tag-suggestions, .tag-suggestion').length) {
                clearSuggestions();
            }
        });

        $(window).on('resize', function() {
            if ($('#tag-suggestions').length || $('#tag-suggestion').length) {
                showSuggestions(tagInput.val().trim());
            }
        });
    }

    $(document).on('tagAdded', fetchAllTags);

    fetchAllTags();
    setupAutocomplete();
});