function pickColor(e) {
    var elementId = e.getAttribute("id");
    var sepId = elementId.split("_");
    var sepIdLength = sepId.length;
    var color = sepId[sepIdLength-1];
    var productId = sepId[sepIdLength-2];
    var imgElement = document.getElementById(sepId[0] + "_img_" + productId);
    imgElement.src = "./images/" + productId + "_" + color + ".jpg";
}


function updateTotal(e) {
    updatePrice(e);
    var sum = 0;
    subtotalElements = document.getElementsByClassName("price-subtotal");
    for (var i = 0; i < subtotalElements.length; i++) {
        sum += parseFloat(subtotalElements[i].innerHTML);
    }

    document.getElementById("total-price").innerHTML = sum.toFixed(2)
}

function updatePrice(e) {
    var regexp = /^\d*$/;
    if (!regexp.test(e.value) || e.value == 0) {
        e.value = 1
    }
    //check vs stock

    var elementId = e.getAttribute("id");
    var sepId = elementId.split("_");
    var sepIdLength = sepId.length;
    sepId = sepId.slice(0,sepIdLength-1);
    document.getElementById(sepId.join("_") + "_price-subtotal").innerHTML = (e.value *  parseFloat(document.getElementById(sepId.join("_") + "_price-single").innerHTML.substr(1))).toFixed(2);
}

function initProductImage(button_id) {
    var element = document.getElementById(button_id);
    pickColor(element);
}