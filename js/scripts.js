
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

  // Gestion du menu responsive
  (function ($) {
    $(document).ready(function () {
      // Gestion de la fermeture et de l'ouverture du menu
      // dans une modale pour la version mobile
      $(".btn-modal").click(function (e) {
        $(".modal-content").toggleClass("animate-modal");
        $(".modal-content").toggleClass("open");
        $(".btn-modal").toggleClass("close");
      });
      $("a").click(function () {
        if ($(".modal-content").hasClass("open")) {
          $(".modal-content").removeClass("animate-modal");
          $(".modal-content").removeClass("open");
          $(".btn-modal").removeClass("close");
        }
      });
    });
  })(jQuery);
