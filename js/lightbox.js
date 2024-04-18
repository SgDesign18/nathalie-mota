document.addEventListener("DOMContentLoaded", function() {
    const photoFullLinks = document.querySelectorAll(".photo-full-link");

    // Fonction pour fermer la lightbox actuelle
    function closeLightbox() {
        const currentLightbox = document.querySelector('.lightbox');
        if (currentLightbox) {
            document.body.removeChild(currentLightbox);
            document.body.classList.remove("lightbox-active");
        }
    }

    photoFullLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du lien

            // Fermer la lightbox actuelle avant d'en ouvrir une nouvelle
            closeLightbox();

            const imageUrl = this.getAttribute("href");
            const overlay = this.closest('.overlay'); // Sélectionnez l'élément parent .overlay

            // Récupérer les informations de la photo à partir de l'élément parent .overlay
            const reference = overlay.querySelector('.photo-reference').textContent;
            const category = overlay.querySelector('.photo-category').textContent;

            // Créez la lightbox
            const lightbox = document.createElement("div");
            lightbox.classList.add("lightbox", "active"); // Ajoutez la classe lightbox et active

            // Ajoutez la classe lightbox-active au corps du document
            document.body.classList.add("lightbox-active");

            // Créez le conteneur pour le contenu de la lightbox
            const lightboxContent = document.createElement("div");
            lightboxContent.classList.add("lightbox-content"); // Ajoutez la classe lightbox-content

            // Créez l'image dans la lightbox
            const image = document.createElement("img");
            image.src = imageUrl;
            image.classList.add("lightbox-image"); // Ajoutez la classe lightbox-image
            lightboxContent.appendChild(image);

            // Ajouter les informations de la photo sous l'image
            const photoInfo = document.createElement("div");
            photoInfo.classList.add("photo-info");
            photoInfo.innerHTML = `<span class="reference">${reference}</span> <span class="category">${category}</span>`;
            lightboxContent.appendChild(photoInfo);

            // Récupérer les boutons de navigation de la lightbox depuis le HTML
            const prevBtn = document.querySelector(".prev-btn");
            const nextBtn = document.querySelector(".next-btn");
            const closeBtn = document.querySelector(".close");

            // Ajoutez les écouteurs d'événements pour les boutons de navigation
            prevBtn.addEventListener("click", showPreviousImage);
            nextBtn.addEventListener("click", showNextImage);

            // Ajoutez l'écouteur d'événement pour le bouton de fermeture
            closeBtn.addEventListener("click", closeLightbox);

            // Ajoutez le contenu de la lightbox au conteneur de la lightbox
            lightbox.appendChild(lightboxContent);

            // Ajoutez la lightbox à la page
            document.body.appendChild(lightbox);

            // Fermez la lightbox en cliquant sur l'image
            lightbox.addEventListener("click", function(e) {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });

            // Fonction pour afficher l'image suivante
            function showNextImage() {
                const nextLink = getNextLink(link);
                if (nextLink) {
                    nextLink.click();
                }
            }

            // Fonction pour afficher l'image précédente
            function showPreviousImage() {
                const previousLink = getPreviousLink(link);
                if (previousLink) {
                    previousLink.click();
                }
            }

            // Fonction pour obtenir le lien de l'image suivante
            function getNextLink(currentLink) {
                const links = Array.from(photoFullLinks);
                const index = links.indexOf(currentLink);
                return index < links.length - 1 ? links[index + 1] : null;
            }

            // Fonction pour obtenir le lien de l'image précédente
            function getPreviousLink(currentLink) {
                const links = Array.from(photoFullLinks);
                const index = links.indexOf(currentLink);
                return index > 0 ? links[index - 1] : null;
            }
        });
    });
});
