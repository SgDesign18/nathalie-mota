
document.addEventListener("DOMContentLoaded", function () {
    const contactBtn = document.querySelectorAll(".open-modal");
    const popupOverlay = document.querySelector(".popup-overlay");

    // Ouverture de la pop contact au clic sur un lien contact
    contactBtn.forEach((contact) => {
        contact.addEventListener("click", () => {
            popupOverlay.classList.remove("hidden");
        });
    });

    // Refermeture de la pop contact au clic
    popupOverlay.addEventListener("click", (e) => {
        if (e.target.className == "popup-overlay") {
            popupOverlay.classList.add("hidden");
        }
    });
});

