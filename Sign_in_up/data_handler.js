$(document).ready(function () {
    // Sign In
    $('#sign-in-btn').on('click', function () {
        const email = $('#sign-in-email').val();
        const pass = $('#sign-in-pass').val();

        $.post("login.php", { email: email, pass: pass }, function(data) {
            try {
                var result = typeof data === "object" ? data : JSON.parse(data);
        
                if (result.status === 'success') {
                    window.location.href = 'sample-page.php'; // ✅ or your destination
                } else {
                    alert(result.message);
                }
            } catch (e) {
                console.error("Failed to parse JSON:", data);
                alert("Something went wrong. Check server error or connection.");
            }
        });
        
        
    });
-

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

        $.post('register.php', { first, last, email, pass }, function (res) {
            const data = JSON.parse(res);
            if (data.status === 'success') {
                alert("Account created! You can now log in.");
                $('#back-sign-in').click();
            } else {
                alert(data.message);
            }
        });
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
