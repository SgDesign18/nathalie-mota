// Gestion de la modale contact
document.addEventListener("DOMContentLoaded", function () {
    const contactBtn = document.querySelectorAll(".open-modal");
    const popupOverlay = document.querySelector(".popup-overlay");
    const referenceInput = document.querySelector("#ref");
  
    // Ouverture de la pop contact au clic sur un lien contact
    contactBtn.forEach((contact) => {
        contact.addEventListener("click", () => {
            popupOverlay.classList.remove("hidden");
            const reference = contact.dataset.reference;
            if (typeof reference !== "undefined") {
                referenceInput.value = reference;
            } else {
                referenceInput.value = "";
            }
        });
    });
  
    // Refermeture de la pop contact au clic sur la zone de fond ou sur le bouton de fermeture
    popupOverlay.addEventListener("click", (e) => {
        if (e.target.classList.contains("popup-overlay") || e.target.classList.contains("close-modal")) {
            popupOverlay.classList.add("hidden");
        }
    });
  });