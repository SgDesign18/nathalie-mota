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
    function openLightbox(imageUrl) {
      // Création de la lightbox et de son contenu
      const lightbox = $('<div class="lightbox active"></div>');
      $('body').addClass("lightbox-active");
  
      const lightboxContent = $('<div class="lightbox-content"></div>');
  
      const image = $('<img class="lightbox-image" src="' + imageUrl + '">');
      lightboxContent.append(image);
  
      const referenceText = $(this).data('reference');
      const categoryText = $(this).closest('.photo-item').find('.photo-category').text(); // Utiliser la méthode text() pour récupérer le texte brut de la catégorie
  
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
  
      // Ajouter tous les liens de photos à photoFullLinksArray (une seule fois)
      const photoFullLinksArray = Array.from(photoFullLinks);
      const currentPhotoIndex = photoFullLinksArray.findIndex(link => link.getAttribute('href') === imageUrl);
  
      lightbox.data('photoFullLinksArray', photoFullLinksArray);
      lightbox.data('currentPhotoIndex', currentPhotoIndex);
      console.log(photoFullLinksArray);
      lightbox.append(lightboxContent);
      $('body').append(lightbox);
    }
  
    // Gestionnaire d'événements délégué pour les liens de la lightbox
    $(document).on("click", ".photo-full-link", function(event) {
      event.preventDefault();
      const imageUrl = $(this).attr('href');
      openLightbox.call(this, imageUrl);
    });
  
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

