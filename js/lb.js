// Fonction pour afficher l'image suivante
function showNextImage() {
    const lightbox = $('.lightbox');
    const photoFullLinksArray = lightbox.data('photoFullLinksArray');
    if (photoFullLinksArray) {
        const currentPhotoIndex = lightbox.data('currentPhotoIndex');
        const nextPhotoIndex = (currentPhotoIndex + 1) % photoFullLinksArray.length;
        const nextPhotoLink = photoFullLinksArray[nextPhotoIndex];
        const nextPhotoUrl = nextPhotoLink.getAttribute('href');
        const nextReference = nextPhotoLink.getAttribute('data-reference');
        const nextCategory = $(nextPhotoLink).data('category'); // Utiliser .data() pour récupérer la catégorie

        $('.lightbox-image').attr('src', nextPhotoUrl);
        $('.lightbox-content .reference').text(nextReference);
        $('.lightbox-content .category').text(nextCategory);

        lightbox.data('currentPhotoIndex', nextPhotoIndex);
    }
}

// Fonction pour afficher l'image précédente
function showPreviousImage() {
    const lightbox = $('.lightbox');
    const photoFullLinksArray = lightbox.data('photoFullLinksArray');
    if (photoFullLinksArray) {
        const currentPhotoIndex = lightbox.data('currentPhotoIndex');
        const previousPhotoIndex = (currentPhotoIndex - 1 + photoFullLinksArray.length) % photoFullLinksArray.length;
        const previousPhotoLink = photoFullLinksArray[previousPhotoIndex];
        const previousPhotoUrl = previousPhotoLink.getAttribute('href');
        const previousReference = previousPhotoLink.getAttribute('data-reference');
        const previousCategory = $(previousPhotoLink).data('category'); // Utiliser .data() pour récupérer la catégorie

        $('.lightbox-image').attr('src', previousPhotoUrl);
        $('.lightbox-content .reference').text(previousReference);
        $('.lightbox-content .category').text(previousCategory);

        lightbox.data('currentPhotoIndex', previousPhotoIndex);
    }
}
