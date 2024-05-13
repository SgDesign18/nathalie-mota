jQuery(document).ready(function($) {
    // Variable pour suivre le numéro de page
    var page = 1;

    // Fonction pour charger les photos en fonction des filtres
    function loadPhotos() {
        var dateValue = $('#date-filter').val(); // Récupérer la valeur du filtre de date
        if (dateValue === 'oldest') {
            dateValue = 'ASC'; // Si l'utilisateur choisit "plus ancien", définissez la valeur sur "ASC"
        } else {
            dateValue = 'DESC'; // Sinon, définissez la valeur sur "DESC" (par défaut pour "plus récent")
        }

        var data = {
            'action': 'filter_photos',
            'page': page,
            'category': $('#category-filter').val(),
            'format': $('#format-filter').val(),
            'date': dateValue // Utiliser la valeur de dateValue
        };

        // Effectuer la requête AJAX
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                // Vider la grille des photos existantes
                $('.photo-grid').empty();

                // Ajouter les nouvelles photos à la grille
                $('.photo-grid').append(response);

                // Mettre à jour le bouton "Charger plus" en fonction de la réponse
                if (response.trim() === 'no_more') {
                    $('#load-more-btn').hide(); // Masquer le bouton s'il n'y a plus de photos à charger
                } else {
                    $('#load-more-btn').show(); // Afficher le bouton s'il y a des photos à charger
                }
            }
        });
    }

    // Gestion des filtres
    $('.select-filter').change(function() {
        // Réinitialiser la pagination à la première page
        page = 1;
        // Charger les photos avec les nouveaux filtres
        loadPhotos();
    });
});


// Couleur des filtres
document.addEventListener("DOMContentLoaded", function() {
    const selectFilters = document.querySelectorAll('.select-filter');
    // Ajoute un écouteur d'événements à chaque menu déroulant
    selectFilters.forEach(select => {
        // Ecoute l'événement de survol des options
        select.addEventListener('mouseover', function() {
            this.style.backgroundColor = '#FFD6D6'; // Change la couleur de fond au survol
        });
        // Ecoute l'événement de sortie du survol des options
        select.addEventListener('mouseout', function() {
            this.style.backgroundColor = ''; // Réinitialise la couleur de fond
        });
        // Ecoute l'événement de changement (clic) sur une option
        select.addEventListener('change', function() {
            // Réinitialise la couleur de fond de toutes les options
            this.querySelectorAll('option').forEach(option => {
                option.style.backgroundColor = '';
                option.style.color = '';
            });
            // Change la couleur de fond de l'option sélectionnée
            const selectedOption = this.querySelector('option:checked');
            selectedOption.style.backgroundColor = '#E00000'; // Couleur de fond au clic
            selectedOption.style.color = '#fff'; // Couleur du texte au clic
        });
    });
  });
  