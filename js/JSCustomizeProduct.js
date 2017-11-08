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
    updatePriceBag(e);
    var sum = 0;
    subtotalElements = document.getElementsByClassName("price-subtotal");
    for (var i = 0; i < subtotalElements.length; i++) {
        sum += parseFloat(subtotalElements[i].innerHTML);
    }

    document.getElementById("total-price").innerHTML = sum.toFixed(2)
}

function updateStock (e, inputType) {
    if (inputType == "color") {
        selectedColor = e.value;
    } else if (inputType == "size") {
        selectedSize = e.value;
    }

    var stock;
    if (typeof inventory_arr[selectedColor][selectedSize] === 'undefined') {
        stock = 0;
    } else {
        stock = inventory_arr[selectedColor][selectedSize];
    }
    var qtyInputElement = document.getElementById("product-quantity");
    if (stock < 1) {
        document.getElementById("option--quantity").style.display = "none";
        document.getElementById("button--addtobag").style.display = "none";
        document.getElementById("button--outofstock").style.display = "inherit";
    } else {
        document.getElementById("option--quantity").style.display = "flex";
        document.getElementById("button--addtobag").style.display = "inherit";
        document.getElementById("button--outofstock").style.display = "none";
        if (qtyInputElement.value > stock) {
            qtyInputElement.value = stock;
            document.getElementById("product-price-subtotal").innerHTML = (stock *  parseFloat(document.getElementById("product-price-single").innerHTML.substr(1))).toFixed(2)
        }
        qtyInputElement.setAttribute("max", stock);
    }
}

function updatePriceProduct(e) {
    var regexp = /^\d*$/;
    if (!regexp.test(e.value) || e.value == 0) {
        e.value = 1
    }

    document.getElementById("product-price-subtotal").innerHTML = (e.value *  parseFloat(document.getElementById("product-price-single").innerHTML.substr(1))).toFixed(2);
}

function updatePriceBag(e) {
    var regexp = /^\d*$/;
    if (!regexp.test(e.value) || e.value == 0) {
        e.value = 1
    }

    var elementId = e.getAttribute("id");
    var sepId = elementId.split("_");
    var sepIdLength = sepId.length;
    sepId = sepId.slice(0,sepIdLength-1);
    document.getElementById(sepId.join("_") + "_price-subtotal").innerHTML = (e.value *  parseFloat(document.getElementById(sepId.join("_") + "_price-single").innerHTML.substr(1))).toFixed(2);
}

function updateShipping(e) {
    var shipType = e.value;
    var price;
    if (shipType == "standard") {
        price = 6.00;
    } else if (shipType == "express") {
        price = 18.00;
    }
    document.getElementById("shipping-price").innerHTML = price.toFixed(2);
    document.getElementById("grandtotal-price").innerHTML = (parseFloat(document.getElementById("subtotal-price").innerHTML) + price).toFixed(2);
}

function handleQuantityChange(element) {
    var xhr = new XMLHttpRequest();

    var quantity = (element.value),
        id       = (element.id).split('_').slice(0, 1),
        color    = (element.id).split('_').slice(1, 2),
        size     = (element.id).split('_').slice(2, 3);

    xhr.open('POST', './bag.php', true);

    // Send the proper header information along with the request
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('Update', '1');

    // Log in console when xhr succeed
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            console.log('Cart session updated.' + id + color + size);
        }
    }

    // Send quantity to update, id and color of the cart item
    xhr.send('new_quantity=' + quantity + '&cart_id=' + id + '&cart_color=' + color + '&cart_size=' + size);

    updateTotal(element);
}

function removeFromCart(e) {
    var xhr = new XMLHttpRequest();

    var index = e.getAttribute("id").split("_").slice(1,2);

    xhr.open('POST', './bag.php', true);

    // Send the proper header information along with the request
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('Remove', '1');

    // Send quantity to update, id and color of the cart item
    xhr.send('remove_item=' + index);
    window.location.reload();
    window.location.href = "bag.php";

}

function initProductImage(button_id) {
    var element = document.getElementById(button_id);
    pickColor(element);
}