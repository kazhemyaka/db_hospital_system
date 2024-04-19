function showPhoneNumberForm() {
    event.preventDefault();

    if (document.getElementById("phone_number_form").style.display == "none") {
        document.getElementById("phone_number_form").style.display = "block";
    } else {
        document.getElementById("phone_number_form").style.display = "none";
    }
}

function showEmailForm() {
    event.preventDefault();

    if (document.getElementById("email_form").style.display == "none") {
        document.getElementById("email_form").style.display = "block";
    } else {
        document.getElementById("email_form").style.display = "none";
    }
}

function showPasswordForm() {
    event.preventDefault();

    if (document.getElementById("password_form").style.display == "none") {
        document.getElementById("password_form").style.display = "block";
    } else {
        document.getElementById("password_form").style.display = "none";
    }
}