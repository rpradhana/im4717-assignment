var counter = 0;
function addInventory() {
    var inventoriesElement = document.getElementById("inventories");
    counter += 1;
    var inventoryDiv = document.createElement('div');
    inventoryDiv.setAttribute("id", "inventory_" + counter);
    inventoryDiv.setAttribute("class", "u-m-medium--bottom");

    var inputColor = document.createElement('input');
    inputColor.setAttribute("type", "text");
    inputColor.setAttribute("name", "color[]");
    inputColor.setAttribute("class", "input--text");
    inputColor.setAttribute("id", "color_" + counter);
    inputColor.setAttribute("placeholder", "Color" );
    inputColor.style.width = "5rem";
    inputColor.style.marginRight = "1rem";
    inputColor.required = true;

    var inputSize = document.createElement('input');
    inputSize.setAttribute("type", "text");
    inputSize.setAttribute("name", "size[]");
    inputSize.setAttribute("class", "input--text");
    inputSize.setAttribute("id", "size_" + counter);
    inputSize.setAttribute("placeholder", "Size");
    inputSize.style.width = "5rem";
    inputSize.style.marginRight = "1rem";
    inputSize.required = true;

    var inputStock = document.createElement('input');
    inputStock.setAttribute("type", "text");
    inputStock.setAttribute("name", "stock[]");
    inputStock.setAttribute("class", "input--text");
    inputStock.setAttribute("id", "stock_" + counter);
    inputStock.setAttribute("placeholder", "Stock" );
    inputStock.style.width = "5rem";
    inputStock.style.marginRight = "1rem";
    inputStock.required = true;

    var inputImage = document.createElement('input');
    inputImage.setAttribute("name", "image[]");
    inputImage.setAttribute("type", "file");
    inputImage.setAttribute("id", "image_" + counter);
    inputImage.required = true;

    inventoryDiv.appendChild(inputColor);
    inventoryDiv.appendChild(inputSize);
    inventoryDiv.appendChild(inputStock);
    inventoryDiv.appendChild(inputImage);

    inventoriesElement.appendChild(inventoryDiv);
}

function removeInventory() {
    if (counter > 0) {
        var inventoriesElement = document.getElementById("inventories");
        inventoriesElement.removeChild(document.getElementById("inventory_" + counter));
        counter -= 1;
    }
}