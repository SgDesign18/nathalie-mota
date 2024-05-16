jQuery(document).ready(function($) {
    var page = 1;

    function loadPhotos() {
        var dateValue = $('#date-filter').val() === 'oldest' ? 'ASC' : 'DESC';
        var data = {
            'action': 'filter_photos',
            'page': page,
            'category': $('#category-filter').val(),
            'format': $('#format-filter').val(),
            'date': dateValue
        };

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                $('.photo-grid').empty();
                $('.photo-grid').append(response);

                // Vérifier la présence du champ caché pour cacher le bouton
                if ($('#no-more-photos').length > 0) {
                    $('#load-more-btn').hide();
                } else {
                    $('#load-more-btn').show();
                }
            }
        });
    }

    $('.select-filter').change(function() {
        page = 1;
        loadPhotos();
    });
});


// Couleur des filtres à revoir

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
  