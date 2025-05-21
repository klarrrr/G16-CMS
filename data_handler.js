$(document).ready(function () {
    // Sign In
    $('#sign-in-btn').on('click', function () {
        const email = $('#sign-in-email').val();
        const pass = $('#sign-in-pass').val();

        $.ajax({
            url: 'login.php',
            method: 'POST',
            data: { email: email, pass: pass },
            dataType: 'json',
            success: function (result) {
                if (result.status === 'success') {
                    window.location.href = 'editor-dashboard.php';
                } else {
                    alert(result.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Response:", xhr.responseText);
                alert("Something went wrong. Check the console.");
            }
        });
    });

    // Sign In - Trigger with Enter key
    $('#sign-in-email, #sign-in-pass').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#sign-in-btn').click();
        }
    });

    // Sign Up
    $('#sign-up-btn').on('click', function () {
        const first = $('#reg-first-name').val();
        const last = $('#reg-last-name').val();
        const email = $('#reg-email').val();
        const pass = $('#reg-pass').val();
        const re_pass = $('#reg-re-pass').val();

        if (pass !== re_pass) {
            alert("Passwords do not match!");
            return;
        }

        $.ajax({
            url: 'register.php',
            method: 'POST',
            data: { first, last, email, pass },
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    alert("Account created! You can now log in.");
                    $('#back-sign-in').click();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Response:", xhr.responseText);
                alert("Registration failed. See console.");
            }
        });
    });

    // Sign Up - Trigger with Enter key
    $('#reg-first-name, #reg-last-name, #reg-email, #reg-pass, #reg-re-pass').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#sign-up-btn').click();
        }
    });

    // Toggle View
    $('#create-account').click(function () {
        $('#sign-in-container').hide();
        $('#sign-up-container').show();
    });

    $('#back-sign-in').click(function () {
        $('#sign-up-container').hide();
        $('#sign-in-container').show();
    });
});
