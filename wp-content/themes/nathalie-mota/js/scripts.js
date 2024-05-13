jQuery(document).ready(function($) {
    // Initialiser une variable pour stocker les photos déjà chargées
    var loadedPhotos = [];

    // Variable pour suivre le numéro de page
    var page = 1;

    // Gestion du bouton "Charger plus"
    $('#load-more-btn').on('click', function() {
        // Incrémenter le numéro de page
        page++;

        // Préparer les données à envoyer via AJAX
        var data = {
            'action': 'load_more_photos',
            'page': page,
            'category': $('#category-filter').val(),
            'format': $('#format-filter').val(),
            'date': $('#date-filter').val(),
            'loaded_photos': loadedPhotos // Envoyer les photos déjà chargées
        };

        // Si le filtre "photos les plus anciennes" est sélectionné, inverser l'ordre de chargement
        if ($('#date-filter').val() === 'oldest') {
            data['order'] = 'ASC'; // Charger les photos dans l'ordre croissant (plus anciennes)
        }

        // Effectuer la requête AJAX
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                // Ajouter les nouvelles photos à la grille
                $('.photo-grid').append(response);

                // Cacher le bouton "Charger plus" si aucune nouvelle photo n'est retournée
                if (response.trim() === '') {
                    $('#load-more-btn').hide();
                }

                // Mettre à jour la liste des photos chargées
                $('.photo-grid .photo-item').each(function() {
                    var photo_id = $(this).data('photo-id');
                    if (!loadedPhotos.includes(photo_id)) {
                        loadedPhotos.push(photo_id);
                    }
                });
            }
        });
    });
});


