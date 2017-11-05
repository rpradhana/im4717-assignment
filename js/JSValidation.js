
/**
 * Error with message
 * Use this to show input error with a message
 * Input must be nested inside a span.input (!)
 * target  = any child element of span.input
 * message = error string
 */

function showErrorWithMessage(target, message) {
    if (target) {
        target.parentNode.setAttribute('data-attr', message);
        addClass(target.parentNode, 'input--invalid');
    }
    else console.log('No target found for showErrorWithMessage()');
};

function hideErrorWithMessage(target) {
    if (target) {
        target.parentNode.setAttribute('data-attr', '');
        removeClass(target.parentNode, 'input--invalid');
    }
    else console.log('No target found for hideErrorWithMessage()');
};

/**
 * Simple error
 * Add red border to target element
 * Applicable to any input field
 * target  = input field
 */

function showSimpleError(target) {
    if (target) {
        addClass(target.parentNode, 'u-is-invalid');
    }
}
function hideSimpleError(target) {
    if (target) {
        removeClass(target.parentNode, 'u-is-invalid');
    }
}

function validateEmail() {
    var email = document.getElementById("email").value.trim();
    var regExp = /^[\w-_\.]+@[\w_-]+(\.[\w_-]+){0,2}\.\w{2,3}$/;
    if(regExp.test(email) == false){
        showErrorWithMessage($('#email'), "Invalid input");
        return false;
    } else {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './php/check-email.php', false);

        // Send the proper header information along with the request
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        var getEmailRegistered = xhr.onreadystatechange=function() {
            if (xhr.readyState==4 && xhr.status==200) {
                return (xhr.responseText === 'true');
            }
        }
        // Send email
        xhr.send('email=' + email);

        if (getEmailRegistered()) {
            showErrorWithMessage($('#email'), "Email already registered");
            return false;
        }
        hideErrorWithMessage($('#email'));
        return true;
    }
}

function validateOldPassword() {
    var passwordElement = document.getElementById("oldpassword");
    if (passwordElement.value.length < 6) {
        showErrorWithMessage($('#oldpassword'), "Old password should be > 6 characters");
        return false;
    }

    hideErrorWithMessage($('#oldpassword'));
    return true;
}

function validatePassword() {
    var passwordElement = document.getElementById("password");
    if (passwordElement.value.length < 6) {
        showErrorWithMessage($('#password'), "Password < 6 characters");
        return false;
    }

    hideErrorWithMessage($('#password'));

    if (document.getElementById("password--verify").value) {
        verifyPassword();
    }
    return true;
}

function verifyPassword() {
    var passwordElement = document.getElementById("password");
    var passwordVerifyElement = document.getElementById("password--verify");
    if (!passwordElement.value) {
        showErrorWithMessage($('#password'), "Enter your password");
        return false;
    } else if (passwordElement.value != passwordVerifyElement.value) {
        showErrorWithMessage($('#password--verify'), "Password mismatch");
        return false;
    }

    hideErrorWithMessage($('#password--verify'));
    return true;
}

function validateAccount() {
    return validateEmail() && validatePassword() && verifyPassword();
}

function validateName() {
    var regexp = /^[A-Za-z]+(\s[A-Za-z]*)*$/;
    if (!regexp.test(document.getElementById("name").value.trim())) {
        showErrorWithMessage($('#name'), "Name should contain only alphabets or spaces");
        return false;
    }
    hideErrorWithMessage($('#name'));
    return true;
}

function validatePhone() {
    var regexp = /^\+?(\d-?){8,16}$/;
    if (!regexp.test(document.getElementById("phone").value.trim())) {
        showErrorWithMessage($('#phone'), "Invalid phone number");
        return false;
    }
    hideErrorWithMessage($('#phone'));
    return true;
}

function validateBirthday() {
    var birthday = document.getElementById("birthday").value.trim();
    var regex = /^\d{4,4}-\d{1,2}-\d{1,2}$/;
    if (birthday && birthday.length !== 0) {

        if (!regex.test(birthday)) {
            showErrorWithMessage($('#birthday'), "Please format in YYYY-MM-DD");
            return false;
        }

        var currTime = (new Date()).getTime();
        var birthdayTime = Date.parse(birthday);
        if (isNaN(birthdayTime) || birthdayTime >= currTime) {
            showErrorWithMessage($('#birthday'), "Invalid birthday");
            return false;
        }


    }
    hideErrorWithMessage($('#birthday'));
    return true;

}

function validateRegistration() {
    return validateAccount() && validateName() && validatePhone() && validateBirthday();
}

function validateAccountUpdate() {
    return validatePhone() && validateBirthday() && validateEmail();
}

function validateCheckout() {
    var isValid = validateName() && validatePhone() && validateBirthday();
    if (document.getElementById("create-account").checked) {
        isValid = isValid && validateAccount();
    }
    return isValid && validateCard();
}

function validateCardNumber() {
    var regex = /\d{9,19}/;
    if (!regex.test(document.getElementById("card-number").value.trim())) {
        showErrorWithMessage($('#card-number'), "Invalid card");
        return false;
    }
    hideErrorWithMessage($('#card-number'));
    return true;
}

function validateCardYear() {
    var regex = /\d{4,4}/;
    var year = document.getElementById("card-year").value.trim();
    if (!regex.test(year) || (new Date(year)).getFullYear() < (new Date()).getFullYear()) {
        showErrorWithMessage($('#card-year'), "Invalid year");
        return false;
    }
    hideErrorWithMessage($('#card-year'));
    return true;
}

function validateCardCVV() {
    var regex = /\d{3,4}/;
    if (!regex.test(document.getElementById("card-cvv").value.trim())) {
        showErrorWithMessage($('#card-cvv'), "Invalid CVV");
        return false;
    }
    hideErrorWithMessage($('#card-cvv'));
    return true;
}

function validateCard () {
    return validateCardNumber() && validateCardYear() && validateCardCVV();
}

function validatePrice(e){
    var id = e.id;
    var priceTest = e.value;
    var regExp = /^((\d+(\.\d{0,2})?)|(\d*(\.\d{1,2})?))$/;

    var isvalid = true;
    if(regExp.test(priceTest) == false ){
        var lastDotIndex = priceTest.lastIndexOf(".");
        if (lastDotIndex > 0 && priceTest.substr(lastDotIndex+1).length > 2) {
            priceTest = priceTest.substr(0,lastDotIndex+3);
            if (regExp.test(priceTest) == false) {
                showSimpleError($('#' + id ));
                isvalid = false;
            } else {
                hideSimpleError($('#' + id));
                e.value = priceTest;
            }
        } else {
            showSimpleError($('#' + id ));
            isvalid = false;
        }
    }
    else {
        hideSimpleError($('#' + id));
    }

    if (isvalid && id == "price--max" && e.value) {
        if (e.value < document.getElementById("price--min").value) {
            isvalid = false;
            showSimpleError($('#' + id ));
        }
    }
    return isvalid;
}

function validateSidebar() {
    return validatePrice(document.getElementById("price--min")) && validatePrice(document.getElementById("price--max"));
}

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


function toggleGender(e){
    var genderToggled = e.id.substr(8);
    if(genderToggled == "women"){
        if (e.checked || !document.getElementById("gender--men").checked) {
            var labelvar = document.getElementById("innerSHRT");
            labelvar.innerHTML = "Shirts and Blouses";
            var show2 = document.getElementById("option--DRSS");
            show2.style.display = "block";
            var show3 = document.getElementById("option--SKTS");
            show3.style.display = "block";
        } else {
            var labelvar = document.getElementById("innerSHRT");
            labelvar.innerHTML = "Shirts";
            var hide2 = document.getElementById("option--DRSS");
            hide2.style.display = "none";
            document.getElementById("category--DRSS").checked = false;
            var hide3 = document.getElementById("option--SKTS");
            hide3.style.display = "none";
            document.getElementById("category--SKTS").checked = false;
        }
    } else  {
        if (e.checked && !document.getElementById("gender--women").checked) {
            var labelvar = document.getElementById("innerSHRT");
            labelvar.innerHTML = "Shirts";
            var hide2 = document.getElementById("option--DRSS");
            hide2.style.display = "none";
            document.getElementById("category--DRSS").checked = false;
            var hide3 = document.getElementById("option--SKTS");
            hide3.style.display = "none";
            document.getElementById("category--SKTS").checked = false;
        } else  {
            var labelvar = document.getElementById("innerSHRT");
            labelvar.innerHTML = "Shirts and Blouses";
            var show2 = document.getElementById("option--DRSS");
            show2.style.display = "block";
            var show3 = document.getElementById("option--SKTS");
            show3.style.display = "block";
        }
    }
}

