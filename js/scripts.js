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
  

  
// Fonction pour mettre à jour les liens vers les images complètes dans lightbox.js
function updatePhotoFullLinksArray() {
}



// Gestion des filtres et du chargement initial des photos
jQuery(document).ready(function($) {
    // Définir la variable globale pour la page
    let page = 1;

    // Fonction pour charger les photos filtrées lorsqu'un filtre est modifié
    $('#category-filter, #format-filter, #date-filter').change(loadFilteredPhotos);

    // Charger les photos initiales
    loadFilteredPhotos();

    // Fonction pour charger les photos filtrées
    function loadFilteredPhotos() {
        const category = $('#category-filter').val();
        const format = $('#format-filter').val();
        const date = $('#date-filter').val();

        // Réinitialiser la page à 1 pour charger les nouvelles photos
        page = 1;

        // Effectuer la requête AJAX pour charger les photos filtrées
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'load_photos_by_filters',
                category: category,
                format: format,
                date: date,
                page: page // Transmettre la valeur de la page
            },
            success: function(response) {
                // Mettre à jour la grille de photos avec la réponse de la requête
                $('.photo-grid').html(response);
                // Mettre à jour les liens vers les images complètes après avoir chargé les nouvelles photos
                updatePhotoFullLinksArray();
                // Cacher le bouton "Charger plus" lorsque des filtres de catégorie ou de format sont appliqués
                $('#load-more-btn').toggle(!(category || format));
            }
        });
    }

    // Gestion du bouton "Charger plus"
    $('#load-more-btn').on('click', function() {
        page++;
        let data = {
            'action': 'load_more_photos',
            'page': page,
            'category': $('#category-filter').val(),
            'format': $('#format-filter').val(),
            'date': $('#date-filter').val()
        };
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
            success: function(response) {
                $('.photo-grid').append(response);
                if (response.trim() === '') {
                    $('#load-more-btn').hide();
                }
                updatePhotoFullLinksArray();

                
            }
        
        });
    });
});
