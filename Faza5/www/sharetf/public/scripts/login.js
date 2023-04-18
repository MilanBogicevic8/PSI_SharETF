// Autor: Aleksa Vučković
$(document).ready(function() {
    switchToLogin();
    $("#login-button").submit(login);
    $("#register-link").click(switchToRegister);
    $("#about-link").click(switchToAbout)
    $("#register-button").submit(register);
    $("#register-back-button").click(switchToLogin)
    $("#about-back-button").click(switchToLogin);
    localStorage.removeItem("admin");
})
function reset() {
    $("#login-email-error").html("");
    $("#login-password-error").html("");
    $("#register-email-error").html("");
    $("#register-password-error").html("");
    $("#register-error").html("");
}
function switchToRegister() {
    $("#login").hide();
    $("#register").show();
    $("#about").hide();
}
function switchToLogin() {
    $("#login").show();
    $("#register").hide();
    $("#about").hide();
}
function switchToAbout() {
    $("#login").hide();
    $("#register").hide();
    $("#about").show();
}
function login(event) {
    reset();
    let email = $("#login-email").val();
    let pass = $("#login-password").val();
    if (!checkEmail(email)) $("#login-email-error").html("Neispravan format email adrese!");
    else if (pass == "") $("#login-password-error").html("Morate uneti lozinku!");
    else return;
    event.preventDefault();
}
function register(event) {
    reset();
    let email = $("#register-email").val();
    let name = $("#register-name").val();
    let lastName = $("#register-last-name").val();
    let pass = $("#register-password").val();
    let pass2 = $("#register-password2").val();
    let img = $("#register-image").val();
    if (email == "" || name == "" || lastName == "" || pass == "") $("#register-error").html("Sva polja su obavezna osim slike!");
    else if (!checkEmail(email)) $("#register-email-error").html("Pogresan format!");
    else if (pass2 != pass) $("#register-password-error").html("Lozinke se ne poklapaju!");
    else return;
    event.preventDefault();
}
function checkEmail(email) {
    return (/^[a-z]{2}\d{6}[a-z]@student.etf.bg.ac.rs/.test(email));
}
