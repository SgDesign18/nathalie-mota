// Bouton charger plus

jQuery(document).ready(function($) {
    var loadedPhotos = [];
    var page = 1;

    $('#load-more-btn').on('click', function() {
        page++;
        var data = {
            'action': 'load_more_photos',
            'page': page,
            'category': $('#category-filter').val(),
            'format': $('#format-filter').val(),
            'order': $('#date-filter').val() === 'oldest' ? 'ASC' : 'DESC',
            'loaded_photos': loadedPhotos
        };

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.trim() === '') {
                    $('#load-more-btn').hide();
                } else {
                    $('.photo-grid').append(response);

                    // Vérifier la présence du champ caché pour cacher le bouton
                    if ($('#no-more-photos').length > 0) {
                        $('#load-more-btn').hide();
                    } else {
                        $('#load-more-btn').show();
                    }

                    $('.photo-grid .photo-item').each(function() {
                        var photo_id = $(this).data('photo-id');
                        if (!loadedPhotos.includes(photo_id)) {
                            loadedPhotos.push(photo_id);
                        }
                    });
                }
            }
        });
    });
});
