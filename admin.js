window.addEventListener("load", function () {
    // Koppla lyssnare till samtliga overlay kopplade knappar:
    //admin.php, alterCustomer.php och alterAdmin.php
    document.getElementById("changePasswordButton").addEventListener("click", displayOverlay);
    document.getElementById("cancelPasswordButton").addEventListener("click", removeOverlay);
    document.getElementById("savePasswordButton").addEventListener("click", removeOverlay);
});

function displayOverlay() {
    document.getElementById("overlay_center").classList.add("visible");
}

/* Dölj #overlay genom att ta bort klassen visible */
function removeOverlay() {
    document.getElementById("overlay_center").classList.remove("visible");
}