<!DOCTYPE html>
<html>
<head>
    <title>Test Page</title>
</head>
<body>
    <div class="img-min" data-photo-id="63"></div>
    <button id="arrow-left">Left</button>
    <button id="arrow-right">Right</button>
    
    <script>
        let photosData = <?php echo $photos_data_json; ?>;
        console.log(photosData); // Ajoutez ceci pour déboguer
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof photosData === 'undefined') {
                console.error('photosData is not defined.');
                return;
            }
            console.log('photosData:', photosData);

            let slider = document.querySelector('.img-min');
            if (!slider) {
                console.error('Slider element not found.');
                return;
            }

            let currentIndex = photosData.findIndex(function(photo) {
                return photo.id === parseInt(slider.getAttribute('data-photo-id'));
            });

            if (currentIndex === -1) {
                console.error('Current photo not found in photosData.');
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

            document.getElementById('arrow-left').addEventListener('click', prevPhoto);
            document.getElementById('arrow-right').addEventListener('click', nextPhoto);
        });
    </script>
</body>
</html>
