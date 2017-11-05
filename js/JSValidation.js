
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
    var email = document.getElementById("email").value;
    var regExp = /^[\w-_\.]+@[\w_-]+(\.[\w_-]+){0,2}\.[A-Za-z]{2,3}$/;
    if(regExp.test(email) == false){
        showErrorWithMessage($('#email'), "Invalid input");
        return false;
    } else {
        hideErrorWithMessage($('#email'));
        return true;
    }
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

var validatePriceMax = function(){
    var priceTest = document.getElementById("price--max").value;
    var regExp3 = /^[1-9]\d*$/;
    if((regExp3.test(priceTest) == false) || (document.getElementById("price--max").value < document.getElementById("price--min").value)){
        showSimpleError($('#price--max'));
    }

    else {
        hideSimpleError($('#price--max'));
    }
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

