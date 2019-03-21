var postnordCost = "20";
var upsCost = "200";
var schenkerCost = "100";

window.addEventListener("load", function () {
    // Koppla lyssnare till samtliga overlay kopplade knappar:
    //admin.php, alterCustomer.php och alterAdmin.php
    document.getElementById("changePasswordButton").addEventListener("click", displayOverlay);
    document.getElementById("cancelPasswordButton").addEventListener("click", removeOverlay);
    document.getElementById("savePasswordButton").addEventListener("click", removeOverlay);
    document.getElementById("postnordCheckbox").addEventListener("click", changeDeliveryChoicePostnord);
    document.getElementById("upsCheckbox").addEventListener("click", changeDeliveryChoiceUPS);
    document.getElementById("schenkerCheckbox").addEventListener("click", changeDeliveryChoiceSchenker);
});

function displayOverlay() {
    document.getElementById("overlay_center").classList.add("visible");
}

/* Dölj #overlay genom att ta bort klassen visible */
function removeOverlay() {
    document.getElementById("overlay_center").classList.remove("visible");
}

function changeDeliveryChoiceSchenkerButton() {
    var schenker = document.getElementById("schenker").classList.contains("backgroundChosen");
    if (schenker) {
    } else {
        document.getElementById("schenker").classList.add("backgroundChosen");
        document.getElementById("schenker").classList.remove("backgroundNotChosen");
        document.getElementById("postnord").classList.remove("backgroundChosen");
        document.getElementById("postnord").classList.add("backgroundNotChosen");
        document.getElementById("ups").classList.remove("backgroundChosen");
        document.getElementById("ups").classList.add("backgroundNotChosen");
        document.getElementById("deliveryCost").textContent = schenkerCost;
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "delivery");
        input.setAttribute("value", schenkerCost);
        input.setAttribute("id", "deliveryCostHidden");
        document.getElementById("deliveryCost").appendChild(input);
        var totalBasket = document.getElementById("totalBasket").textContent;
        var totalCost = Number(totalBasket) + Number(schenkerCost);
        document.getElementById("totalCost").textContent = String(totalCost);
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "delivery");
        input.setAttribute("value", totalCost);
        input.setAttribute("id", "totalCostHidden");
        document.getElementById("totalCost").appendChild(input);
    }
    return false;
}

function changeDeliveryChoiceUPSButton() {
    var ups = document.getElementById("ups").classList.contains("backgroundChosen");
    if (ups) {
    } else {
        document.getElementById("ups").classList.add("backgroundChosen");
        document.getElementById("ups").classList.remove("backgroundNotChosen");
        document.getElementById("postnord").classList.remove("backgroundChosen");
        document.getElementById("postnord").classList.add("backgroundNotChosen");
        document.getElementById("schenker").classList.remove("backgroundChosen");
        document.getElementById("schenker").classList.add("backgroundNotChosen");
        document.getElementById("deliveryCost").textContent = upsCost;
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "delivery");
        input.setAttribute("value", upsCost);
        input.setAttribute("id", "deliveryCostHidden");
        document.getElementById("deliveryCost").appendChild(input);
        var totalBasket = document.getElementById("totalBasket").textContent;
        var totalCost = Number(totalBasket) + Number(upsCost);
        document.getElementById("totalCost").textContent = String(totalCost);
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "totalCost");
        input.setAttribute("value", totalCost);
        input.setAttribute("id", "totalCostHidden");
        document.getElementById("totalCost").appendChild(input);
    }
    return false;
}

function changeDeliveryChoicePostnordButton() {
    var postnord = document.getElementById("postnord").classList.contains("backgroundChosen");
    if (postnord) {
    } else {
        document.getElementById("postnord").classList.add("backgroundChosen");
        document.getElementById("postnord").classList.remove("backgroundNotChosen");
        document.getElementById("ups").classList.remove("backgroundChosen");
        document.getElementById("ups").classList.add("backgroundNotChosen");
        document.getElementById("schenker").classList.remove("backgroundChosen");
        document.getElementById("schenker").classList.add("backgroundNotChosen");
        document.getElementById("deliveryCost").textContent = postnordCost;
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "delivery");
        input.setAttribute("value", postnordCost);
        input.setAttribute("id", "deliveryCostHidden");
        document.getElementById("deliveryCost").appendChild(input);
        var totalBasket = document.getElementById("totalBasket").textContent;
        var totalCost = Number(totalBasket) + Number(postnordCost);
        document.getElementById("totalCost").textContent = String(totalCost);
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "totalCost");
        input.setAttribute("value", totalCost);
        input.setAttribute("id", "totalCostHidden");
        document.getElementById("totalCost").appendChild(input);
    }
    return false;
}

function addQuantity(a, b) {
    var quantityID = "productAmount" + a;
    var currentQuantity = document.getElementById(quantityID).value;
    var newQuantity = Number(currentQuantity) + 1;
    var priceID = "detailPriceHidden" + a;
    var totalDetailNode = document.getElementById("detailTotal" + a);
    var price = document.getElementById(priceID).value;
    price = Number(price);
    var partSumID = "detailTotalHidden" + a;
    var partSum = (price * newQuantity);
    partSum = partSum.toFixed(2);
    var deliveryCost = Number(document.getElementById("deliveryCostHidden").value);
    var totalBasketNode = document.getElementById("totalBasket");
    var totalCostNode = document.getElementById("totalCost");

    document.getElementById(quantityID).value = newQuantity;

    totalDetailNode.textContent = partSum;
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", partSumID);
    input.setAttribute("value", partSum);
    input.setAttribute("id", partSumID);
    totalDetailNode.appendChild(input);

    var totalCost = 0;

    for (i = 1; i <= b; i++) {
        var detailID = document.getElementById("detailTotalHidden" + i);
        var allDetails = Number(detailID.value);
        var totalCost = totalCost + allDetails;
    }
    var newTotalBasket = totalCost.toFixed(2);
    var totalCost = totalCost + deliveryCost;
    var newTotalCost = totalCost.toFixed(2);

    totalBasketNode.textContent = newTotalBasket;
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "totalBasketHidden");
    input.setAttribute("value", newTotalBasket);
    input.setAttribute("id", "totalBasketHidden");
    totalBasketNode.appendChild(input);

    totalCostNode.textContent = newTotalCost;
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "totalCost");
    input.setAttribute("value", newTotalCost);
    input.setAttribute("id", "totalCostHidden");
    totalCostNode.appendChild(input);

    return false;

}

function removeQuantity(a, b) {
    var quantityID = "productAmount" + a;
    var currentQuantity = document.getElementById(quantityID).value;
    var newQuantity = Number(currentQuantity) - 1;
    var priceID = "detailPriceHidden" + a;
    var totalDetailNode = document.getElementById("detailTotal" + a);
    var price = document.getElementById(priceID).value;
    price = Number(price);
    var partSumID = "detailTotalHidden" + a;
    var partSum = (price * newQuantity);
    partSum = partSum.toFixed(2);
    var deliveryCost = Number(document.getElementById("deliveryCostHidden").value);
    var totalBasketNode = document.getElementById("totalBasket");
    var totalCostNode = document.getElementById("totalCost");

    document.getElementById(quantityID).value = newQuantity;

    totalDetailNode.textContent = partSum;
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", partSumID);
    input.setAttribute("value", partSum);
    input.setAttribute("id", partSumID);
    totalDetailNode.appendChild(input);

    var totalCost = 0;

    for (i = 1; i <= b; i++) {
        var detailID = document.getElementById("detailTotalHidden" + i);
        var allDetails = Number(detailID.value);
        var totalCost = totalCost + allDetails;
    }
    var newTotalBasket = totalCost.toFixed(2);
    var totalCost = totalCost + deliveryCost;
    var newTotalCost = totalCost.toFixed(2);

    totalBasketNode.textContent = newTotalBasket;
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "totalBasketHidden");
    input.setAttribute("value", newTotalBasket);
    input.setAttribute("id", "totalBasketHidden");
    totalBasketNode.appendChild(input);

    totalCostNode.textContent = newTotalCost;
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "totalCost");
    input.setAttribute("value", newTotalCost);
    input.setAttribute("id", "totalCostHidden");
    totalCostNode.appendChild(input);

    if (newQuantity == 0) {
        deleteDetail(b);
        return true;
    } else {
        return false;
    }
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function deleteDetail(b, c) {

    // set cookies and reload page
    var a = 0;
    var name = "delete";
    var value = "delete";
    var days = 1;
    var i = 0;
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

    document.cookie = name + '=' + value + '; expires=' + date + '; path=/'

    for (i = 1; i <= b; i++) {

        var quantityID = "productAmount" + i;
        var currentQuantity = document.getElementById(quantityID).value;
        var productCodeID = "productCode" + i;
        var productCode = document.getElementById(productCodeID).value;

        if (i > c) {
            a = i - 1;
            var key = "productCode" + a;
            var keyvalue = productCode;
            document.cookie = key + '=' + keyvalue + '; expires=' + date + '; path=/';
            var key = "productAmount" + a;
            var keyvalue = currentQuantity;
            document.cookie = key + '=' + keyvalue + '; expires=' + date + '; path=/';
        } else if (i < c) {
            var key = "productCode" + i;
            var keyvalue = productCode;
            document.cookie = key + '=' + keyvalue + '; expires=' + date + '; path=/';
            var key = "productAmount" + i;
            var keyvalue = currentQuantity;
            document.cookie = key + '=' + keyvalue + '; expires=' + date + '; path=/';
        } else {
        }
    }

    var key = "productCode" + b;
    document.cookie = key + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
    var key = "productAmount" + b;
    document.cookie = key + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';

    name = "deliveryCost";
    value = document.getElementById("deliveryCostHidden").value;
    document.cookie = key + '=' + keyvalue + '; expires=' + date + '; path=/';
}