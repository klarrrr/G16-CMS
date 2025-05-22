document.addEventListener('keydown', function (event) {
    // Disable Ctrl+S
    if (event.ctrlKey && event.key === 's') {
        event.preventDefault();
    }

    // Disable Ctrl+B
    if (event.ctrlKey && event.key === 'b') {
        event.preventDefault();
    }

    // Disable Ctrl+Shift+I
    if (event.ctrlKey && event.shiftKey && event.key === 'I') {
        event.preventDefault();
    }

    // Disable Ctrl+Shift+>
    if (event.ctrlKey && event.shiftKey && event.key === '>') {
        event.preventDefault();
    }

    // Disable Ctrl+Shift+>
    if (event.ctrlKey && event.shiftKey && event.key === '<') {
        event.preventDefault();
    }

    // Disable F12
    if (event.key === 'F12') {
        event.preventDefault();
    }



});