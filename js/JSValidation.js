function toggleAccountCheckout(e) {
    if (e.checked) {
        var emailElement = document.getElementById("checkout-email");
        var passwordElement = document.getElementById("checkout-password");
        var verifyPasswordElement = document.getElementById("checkout-password-verify");
        emailElement.setAttribute("class", emailElement.getAttribute("class").substr(0,emailElement.getAttribute("class").length-12));
        passwordElement.setAttribute("class", passwordElement.getAttribute("class").substr(0,passwordElement.getAttribute("class").length-12));
        verifyPasswordElement.setAttribute("class", verifyPasswordElement.getAttribute("class").substr(0,verifyPasswordElement.getAttribute("class").length-12));
        document.getElementsByName("email")[0].required = true;
        document.getElementsByName("password")[0].required = true;
        document.getElementsByName("password--verify")[0].required = true;
    } else {
        var emailElement = document.getElementById("checkout-email");
        var passwordElement = document.getElementById("checkout-password");
        var verifyPasswordElement = document.getElementById("checkout-password-verify");
        emailElement.setAttribute("class", emailElement.getAttribute("class") + " u-is-hidden");
        passwordElement.setAttribute("class", passwordElement.getAttribute("class") + " u-is-hidden");
        verifyPasswordElement.setAttribute("class", verifyPasswordElement.getAttribute("class") + " u-is-hidden");
        document.getElementsByName("email")[0].required = false;
        document.getElementsByName("password")[0].required = false;
        document.getElementsByName("password--verify")[0].required = false;
    }
}

function toggleAccountProfile() {
    var buttonElement = document.getElementById("profile-change-password");
    var oldpasswordElement = document.getElementById("profile-oldpassword");
    var passwordElement = document.getElementById("profile-password");
    var verifyPasswordElement = document.getElementById("profile-verifypassword");
    buttonElement.setAttribute("class", buttonElement.getAttribute("class") + " u-is-hidden");
    oldpasswordElement.setAttribute("class", oldpasswordElement.getAttribute("class").substr(0,oldpasswordElement.getAttribute("class").length-12))
    passwordElement.setAttribute("class", passwordElement.getAttribute("class").substr(0,passwordElement.getAttribute("class").length-12))
    verifyPasswordElement.setAttribute("class", verifyPasswordElement.getAttribute("class").substr(0,verifyPasswordElement.getAttribute("class").length-12))
    document.getElementsByName("password--old")[0].required = true;
    document.getElementsByName("password")[0].required = true;
    document.getElementsByName("password--verify")[0].required = true;

}