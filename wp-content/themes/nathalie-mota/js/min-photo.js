document.addEventListener("DOMContentLoaded", function() {
    var slider = document.querySelector('.img-min');
    var arrowLeft = document.getElementById('arrow-left');
    var arrowRight = document.getElementById('arrow-right');

    var photosData = window.photosData;
    var currentIndex = photosData.findIndex(function(photo) {
        return photo.id === parseInt(slider.getAttribute('data-photo-id'));
    });

    function nextPhoto() {
        currentIndex = (currentIndex + 1) % photosData.length;
        updatePhoto();
    }

    function prevPhoto() {
        currentIndex = (currentIndex - 1 + photosData.length) % photosData.length;
        updatePhoto();
    }

    function updatePhoto() {
        var nextPhotoData = photosData[currentIndex];
        var nextPhotoUrl = nextPhotoData.permalink;
        var nextPhotoThumb = nextPhotoData.thumbnail_url;

        slider.innerHTML = '<a href="' + nextPhotoUrl + '" class="photo-link"><img src="' + nextPhotoThumb + '" class="photo-min" id="first-photo-thumbnail"></a>';
    }

    arrowLeft.addEventListener('click', prevPhoto);
    arrowRight.addEventListener('click', nextPhoto);
});
