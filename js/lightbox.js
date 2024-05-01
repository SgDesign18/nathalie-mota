jQuery(document).ready(function($) {
    let photoFullLinksArray = []; // Tableau pour stocker les liens vers les images

    // Fonction pour fermer la lightbox actuelle
    function closeLightbox() {
        const currentLightbox = $('.lightbox');
        currentLightbox.remove();
        $('body').removeClass("lightbox-active");
    }

 // Fonction pour charger tous les liens vers les images depuis le serveur
 function loadAllPhotoLinks() {
    // Vérifier si les liens ont déjà été chargés
    if (photoFullLinksArray.length > 0) {
        return Promise.resolve(); // Renvoyer une promesse résolue si les liens sont déjà chargés
    } else {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: ajax_object.ajax_url, // URL de l'action AJAX définie dans functions.php
                type: 'POST',
                data: {
                    action: 'load_all_photo_links' // Action à exécuter dans WordPress
                },
                success: function(response) {
                    // Mettre à jour le tableau avec les liens vers les images
                    photoFullLinksArray = response.map(photo => ({
                        href: photo.href,
                        reference: photo.reference,
                        category: photo.category,
                        order: photo.order // Ajouter l'attribut order à chaque photo
                    })).sort((a, b) => a.order - b.order);
                    console.log("Tous les liens vers les images sont chargés :", photoFullLinksArray); // Vérifier le contenu de photoFullLinksArray
                    resolve(); // Résoudre la promesse une fois que les liens sont chargés
                },
                error: function(xhr, status, error) {
                    console.error(error); // Afficher l'erreur dans la console en cas d'échec de la requête AJAX
                    reject(error); // Rejeter la promesse en cas d'erreur
                }
            });
        });
    }
}



  // Fonction pour ouvrir la lightbox
function openLightbox(imageUrl) {
    // Chercher l'index de la photo actuelle dans le tableau trié photoFullLinksArray
    const currentPhotoIndex = photoFullLinksArray.findIndex(link => link.href === imageUrl);

    // Création de la lightbox et de son contenu
    const lightbox = $('<div class="lightbox active"></div>');
    $('body').addClass("lightbox-active");

    const lightboxContent = $('<div class="lightbox-content"></div>');

    const image = $('<img class="lightbox-image" src="' + imageUrl + '">');
    lightboxContent.append(image);

    if (currentPhotoIndex !== -1) { // Vérifier si l'index est valide
        const currentPhoto = photoFullLinksArray[currentPhotoIndex];
        const referenceText = currentPhoto.reference;
        const categoryText = currentPhoto.category ? currentPhoto.category.map(cat => cat.name).join(', ') : '';

        const photoInfo = $('<div class="photo-info"><span class="reference">' + referenceText + '</span> <span class="category">' + categoryText + '</span></div>');
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

        lightbox.data('currentPhotoIndex', currentPhotoIndex); // Stocker l'index de la photo actuelle dans la lightbox
    } else {
        console.error("Index de photo introuvable");
    }

    lightbox.append(lightboxContent);
    $('body').append(lightbox);
}


   

    // Gestionnaire d'événements délégué pour les liens de la lightbox
    $(document).on("click", ".photo-full-link", function(event) {
        event.preventDefault();
        const imageUrl = $(this).attr('href');
        openLightbox(imageUrl);
    });

// Fonction pour afficher l'image suivante
function showNextImage() {
    const lightbox = $('.lightbox');
    let currentPhotoIndex = lightbox.data('currentPhotoIndex');
    if (currentPhotoIndex !== undefined && currentPhotoIndex !== null) { // Vérifier si l'index est valide
        currentPhotoIndex = (currentPhotoIndex + 1) % photoFullLinksArray.length;
        const nextPhoto = photoFullLinksArray[currentPhotoIndex];
        if (nextPhoto && nextPhoto.href !== undefined) { // Vérifier si le lien est valide
            const nextPhotoUrl = nextPhoto.href;
            const nextReference = nextPhoto.reference;
            const nextCategory = nextPhoto.category ? nextPhoto.category.map(cat => cat.name).join(', ') : '';
            $('.lightbox-image').attr('src', nextPhotoUrl);
            $('.lightbox-content .reference').text(nextReference);
            $('.lightbox-content .category').text(nextCategory);
            lightbox.data('currentPhotoIndex', currentPhotoIndex); // Mettre à jour l'index de la photo actuelle dans la lightbox
        }
    }
}
// Fonction pour afficher l'image précédente
function showPreviousImage() {
    const lightbox = $('.lightbox');
    let currentPhotoIndex = lightbox.data('currentPhotoIndex');
    if (currentPhotoIndex !== undefined && currentPhotoIndex !== null) { // Vérifier si l'index est valide
        currentPhotoIndex = (currentPhotoIndex - 1 + photoFullLinksArray.length) % photoFullLinksArray.length;
        const previousPhoto = photoFullLinksArray[currentPhotoIndex];
        if (previousPhoto) {
            const previousPhotoUrl = previousPhoto.href;
            const previousReference = previousPhoto.reference;
            const previousCategory = previousPhoto.category ? previousPhoto.category.map(cat => cat.name).join(', ') : '';
            $('.lightbox-image').attr('src', previousPhotoUrl);
            $('.lightbox-content .reference').text(previousReference);
            $('.lightbox-content .category').text(previousCategory);
            lightbox.data('currentPhotoIndex', currentPhotoIndex);
        }
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






// Attendre le chargement complet des liens vers les images avant d'ouvrir la lightbox
loadAllPhotoLinks().then(function() {
    // Appeler la fonction pour ouvrir la lightbox ici
    console.log("Tous les liens vers les images sont chargés :", photoFullLinksArray);
}).catch(function(error) {
    console.error("Une erreur s'est produite lors du chargement des liens vers les images :", error);
});
});