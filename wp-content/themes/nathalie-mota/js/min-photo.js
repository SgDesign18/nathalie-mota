document.addEventListener("DOMContentLoaded", function() {
    let slider = document.querySelector('.img-min');
    let arrowLeft = document.getElementById('arrow-left');
    let arrowRight = document.getElementById('arrow-right');

    if (typeof photosData === 'undefined' || !slider) {
        console.error('photosData est pas définie ou le slider est pas trouvé.');
        return;
    }

    let currentIndex = photosData.findIndex(function(photo) {
        return photo.id === parseInt(slider.getAttribute('data-photo-id'));
    });

    if (currentIndex === -1) {
        console.error('la photo est pas trouvée dans photosData.');
        return;
    }

    function nextPhoto() {
        currentIndex = (currentIndex + 1) % photosData.length;
        updatePhoto();
    }

    function prevPhoto() {
        currentIndex = (currentIndex - 1 + photosData.length) % photosData.length;
        updatePhoto();
    }

    function updatePhoto() {
        let nextPhotoData = photosData[currentIndex];
        let nextPhotoUrl = nextPhotoData.permalink;
        let nextPhotoThumb = nextPhotoData.thumbnail_url;

        slider.innerHTML = '<a href="' + nextPhotoUrl + '" class="photo-link"><img src="' + nextPhotoThumb + '" class="photo-min" id="first-photo-thumbnail"></a>';
    }

    arrowLeft.addEventListener('click', prevPhoto);
    arrowRight.addEventListener('click', nextPhoto);
});
