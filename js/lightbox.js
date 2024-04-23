jQuery(document).ready(function($) {
    const photoFullLinks = document.querySelectorAll(".photo-full-link");
    const photoFullLinksArray = Array.from(photoFullLinks);


    // Fonction pour fermer la lightbox actuelle
    function closeLightbox() {
        const currentLightbox = $('.lightbox');
        currentLightbox.remove();
        $('body').removeClass("lightbox-active");
    }

    // Fonction pour ouvrir la lightbox
    function openLightbox(imageUrl, reference, category) {
        // Création de la lightbox et de son contenu
        const lightbox = $('<div class="lightbox active"></div>');
        $('body').addClass("lightbox-active");

        const lightboxContent = $('<div class="lightbox-content"></div>');

        const image = $('<img class="lightbox-image" src="' + imageUrl + '">');
        lightboxContent.append(image);

        const photoInfo = $('<div class="photo-info"><span class="reference">' + reference + '</span> <span class="category">' + category + '</span></div>');
        lightboxContent.append(photoInfo);

        const closeBtn = $('<button class="close"><img src="' + imageDirectory + 'croix.png" alt="fermer la photo"></button>');
        closeBtn.on('click', closeLightbox);
        lightboxContent.append(closeBtn);

        const prevBtn = $('<button class="prev-btn"><img src="' + imageDirectory + 'prev.png" alt="image précédente"></button>');
        prevBtn.on('click', showPreviousImage);
        lightboxContent.append(prevBtn);

        const nextBtn = $('<button class="next-btn"><img src="' + imageDirectory + 'next.png" alt="image suivante"></button>');
        nextBtn.on('click', showNextImage);
        lightboxContent.append(nextBtn);

        lightbox.append(lightboxContent);
        $('body').append(lightbox);
    }

    // Gestionnaire d'événements délégué pour les liens de la lightbox
    $(document).on("click", ".photo-full-link", function(event) {
        event.preventDefault();
        const imageUrl = $(this).attr('href');
        const reference = $(this).closest('.photo-item').find('.photo-reference').text();
        const category = $(this).closest('.photo-item').find('.photo-category').text();
        openLightbox(imageUrl, reference, category);
    });

   // Fonction pour afficher l'image suivante
function showNextImage() {
    const currentIndex = photoFullLinksArray.findIndex(link => link.getAttribute('href') === $('.lightbox-image').attr('src'));
    if (currentIndex !== -1 && currentIndex < photoFullLinksArray.length - 1) {
        const nextLink = photoFullLinksArray[currentIndex + 1];
        const imageUrl = nextLink.getAttribute('href');
        $('.lightbox-image').attr('src', imageUrl);
    }
}

// Fonction pour afficher l'image précédente
function showPreviousImage() {
    const currentIndex = photoFullLinksArray.findIndex(link => link.getAttribute('href') === $('.lightbox-image').attr('src'));
    if (currentIndex !== -1 && currentIndex > 0) {
        const previousLink = photoFullLinksArray[currentIndex - 1];
        const imageUrl = previousLink.getAttribute('href');
        $('.lightbox-image').attr('src', imageUrl);
    }
}


    // Gestionnaire d'événements pour le bouton fermer
    $(document).on("click", ".close", function(event) {
        event.preventDefault();
        closeLightbox();
    });

    // Gestionnaire d'événements pour le bouton précédent dans la lightbox
    $(document).on("click", ".prev-btn", function(event) {
        event.preventDefault();
        showPreviousImage();
    });

    // Gestionnaire d'événements pour le bouton suivant dans la lightbox
    $(document).on("click", ".next-btn", function(event) {
        event.preventDefault();
        showNextImage();
    });
});
