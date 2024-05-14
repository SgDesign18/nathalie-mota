jQuery(document).ready(function($) {
    // Clic sur la flèche précédente
    $('#arrow-left').on('click', function() {
        var currentPhotoID = $(this).data('photo-id'); // Récupérer l'ID de la photo à partir de l'attribut data
        $.ajax({
            url: ajax_object.ajax_url, // Utiliser la variable définie dans la page PHP pour l'URL AJAX
            type: 'POST',
            data: {
                action: 'get_adjacent_photo_thumbnail',
                photo_id: currentPhotoID,
                direction: 'previous'
            },
            success: function(response) {
                $('.img-min').html(response);
            }
        });
    });

    // Clic sur la flèche suivante
    $('#arrow-right').on('click', function() {
        var currentPhotoID = $(this).data('photo-id'); // Récupérer l'ID de la photo à partir de l'attribut data
        $.ajax({
            url: ajax_object.ajax_url, // Utiliser la variable définie dans la page PHP pour l'URL AJAX
            type: 'POST',
            data: {
                action: 'get_adjacent_photo_thumbnail',
                photo_id: currentPhotoID,
                direction: 'next'
            },
            success: function(response) {
                $('.img-min').html(response);
            }
        });
    });
});
