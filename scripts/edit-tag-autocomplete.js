$(document).ready(function() {
    const tagInput = $('#widget-tags-input');
    const tagsContainer = $('.tags-container');
    let allTags = [];
    let selectedSuggestionIndex = -1;

    // Fetch all tags from server
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

    // Show suggestions
    function showSuggestions(input) {
        clearSuggestions();
        
        if (input.length < 1) return;

        const matches = allTags.filter(tag => 
            tag.toLowerCase().includes(input.toLowerCase()) && 
            !tagsContainer.find('.tag').text().toLowerCase().includes(tag.toLowerCase())
        );

        if (matches.length === 0) return;

        // Inline suggestion (best prefix match)
        const prefixMatches = matches.filter(tag => 
            tag.toLowerCase().startsWith(input.toLowerCase())
        );
        
        if (prefixMatches.length > 0) {
            const bestMatch = prefixMatches[0];
            const remaining = bestMatch.substring(input.length);
            
            // Create a measurement element with the exact same styles
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
            
            // Get input position and padding
            const inputOffset = tagInput.offset();
            const inputPadding = parseInt(tagInput.css('padding-left')) || 0;
            
            // Create and position the inline suggestion
            const inlineSuggestion = $(`<span id="tag-suggestion" class="tag-suggestion">${remaining}</span>`);
            
            // Position it precisely after the typed text
            inlineSuggestion.css({
                'left': inputOffset.left + inputPadding + textWidth + 2, // +2px for cursor
                'top': inputOffset.top + (tagInput.outerHeight() / 2)
            });
            
            $('body').append(inlineSuggestion);
        }

        // Dropdown suggestions
        const dropdown = $(`<div id="tag-suggestions" class="tag-suggestions"></div>`);
        
        matches.slice(0, 5).forEach((tag, index) => {
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
            
            dropdown.append(item);
        });
        
        // Position dropdown below input
        dropdown.css({
            'position': 'absolute',
            'left': tagInput.offset().left,
            'top': tagInput.offset().top + tagInput.outerHeight() + 2,
            'width': tagInput.outerWidth()
        });
        
        $('body').append(dropdown);
    }

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
            
            // Scroll into view
            selected[0].scrollIntoView({
                block: 'nearest',
                behavior: 'smooth'
            });
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

        // Reposition on window resize
        $(window).on('resize', function() {
            if ($('#tag-suggestions').length || $('#tag-suggestion').length) {
                showSuggestions(tagInput.val().trim());
            }
        });
    }

    // Update tags when new ones are saved
    $(document).on('tagAdded', fetchAllTags);

    fetchAllTags();
    setupAutocomplete();
});