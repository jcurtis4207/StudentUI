function validatePasswords() {
    if (document.getElementById('new_password').value != document.getElementById('confirm_password').value) {
        alert("Passwords do not match");
    } else {
        document.getElementById('password-form').submit();
    }
}

// when document loads, add listeners to button
window.onload=function(){
    var submit_button = document.getElementById('submit-button');
    submit_button.addEventListener("click", validatePasswords);
}