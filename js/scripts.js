

document.addEventListener("DOMContentLoaded", function () {
  const contactBtn = document.querySelectorAll(".open-modal");
  const popupOverlay = document.querySelector(".popup-overlay");
  const referenceInput = document.querySelector("#ref"); 

  // Ouverture de la pop contact au clic sur un lien contact
  contactBtn.forEach((contact) => {
      contact.addEventListener("click", () => {
          popupOverlay.classList.remove("hidden");
          const reference = contact.dataset.reference;
          if (typeof reference !== "undefined") { // Vérifiez si la référence est définie
              referenceInput.value = reference; 
          } else {
              referenceInput.value = ""; // Si la référence n'est pas définie, laissez le champ vide
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



  // gestion des filtres 

  jQuery(document).ready(function($) {
    // Fonction pour charger les photos filtrées lorsqu'un filtre est modifié
    $('#category-filter, #format-filter, #date-filter').change(function() {
        loadFilteredPhotos();
    });

    function loadFilteredPhotos() {
        const category = $('#category-filter').val();
        const format = $('#format-filter').val();
        const date = $('#date-filter').val();

        // Effectuer la requête AJAX pour charger les photos filtrées
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'load_photos_by_filters',
                category: category,
                format: format,
                date: date
            },
            success: function(response) {
                // Mettre à jour la grille de photos avec la réponse de la requête
                $('.photo-grid').html(response);
            }
   
        });
    }
});



