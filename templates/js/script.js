$(document).ready(function () {
    $('#login-auth').hide()
    $('#pass-auth').hide()
    $('#login-reg').hide();
    $('#email-reg').hide();
    $('#repeatPass-reg').hide();
    $('#password-reg').hide();

    // Functionality to show/hide registration form
    $("#showRegistrationFormButton").click(function(){
        $("#registrationForm").toggle();
        $("#loginForm").hide(); // Hide login form when showing registration form
    });

    // Functionality to show/hide login form
    $("#showLoginFormButton").click(function(){
        $("#loginForm").toggle();
        $("#registrationForm").hide(); // Hide registration form when showing login form
    });

    // Handle auth form
    $('#auth-form').on("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        // Send POST request to backend.php
        $.post("./app/View/backend.php", $(this).serialize(), function (response) {
            // Process JSON response from php
            if (response.success) {
                $('#auth-form')[0].reset();
                $('#login-auth').hide()
                $('#pass-auth').hide()
                $('#loginForm').toggle();
                $('#console-label').html('Login is success!')
            }
            else {
                $('#auth-form')[0].reset();
                if (!response.error.login) {
                    $('#login-auth').hide()
                }
                if (response.error.login) {
                    $('#login-auth').html(response.error.login).show();
                }
                if (!response.error.password){
                    $('#pass-auth').hide();
                }
                if (response.error.password){
                    $('#pass-auth').html(response.error.password).show();
                }
            }
        }, 'json');
    });

    $('#reg-form').on("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        // Send POST request to backend.php
        $.post("./app/View/backend.php", $(this).serialize(), function (response) {
            // Process JSON response from php
            if (response.success) {
                $('#reg-form')[0].reset();
                $('#login-reg').hide();
                $('#email-reg').hide();
                $('#repeatPass-reg').hide();
                $('#password-reg').hide();
                $('#registrationForm').toggle();
                $('#console-label').html('Registration is success!');
            }
            else {
                $('#reg-form')[0].reset();
                if (!response.error.login) {
                    $('#login-reg').hide()
                }
                if (response.error.login) {
                    $('#login-reg').html(response.error.login).show();
                }
                if (!response.error.password){
                    $('#password-reg').hide();
                }
                if (response.error.password){
                    $('#password-reg').html(response.error.password).show();
                }
                if (!response.error.repeatPass){
                    $('#repeatPass-reg').hide();
                }
                if (response.error.repeatPass){
                    $('#repeatPass-reg').html(response.error.repeatPass).show();
                }
                if (!response.error.email){
                    $('#email-reg').hide();
                }
                if (response.error.email){
                    $('#email-reg').html(response.error.email).show();
                }
            }
        }, 'json');
    });
});