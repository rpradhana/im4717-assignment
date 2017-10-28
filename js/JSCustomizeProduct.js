function pickColor(e) {
    var elementId = e.getAttribute("id");
    var sepId = elementId.split("_");
    var sepIdLength = sepId.length;
    var color = sepId[sepIdLength-1];
    var productId = sepId[sepIdLength-2];
    var imgElement = document.getElementById(sepId[0] + "_img_" + productId);
    imgElement.src = "./images/" + productId + "_" + color + ".jpg";
}

function initProductImage(button_id) {
    var element = document.getElementById(button_id);
    pickColor(element);
}