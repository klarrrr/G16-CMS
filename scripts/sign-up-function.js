// Sign Up
document.getElementById("sign-up-btn").addEventListener("click", function () {
    const email = document.getElementById("reg-email").value;
    const password = document.getElementById("reg-pass").value;
    const re_password = document.getElementById("reg-re-pass").value;

    $.ajax({
        type: "POST",
        url: "create-account.php",
        data: {
            email: email,
            password: password,
            re_password: re_password,
        },
        success: function (response) {
            if (response.includes("Error") || response.includes("Invalid") || response.includes("match")) {
                alert(response);
            } else {
                window.location.href = "sample-page.php";
            }
        }
    });
});