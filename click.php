<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
</head>
<body>

<?php
// Example array of image URLs
$imageUrls = array(
    'service-1.jpg',
    'service-2.jpg',
    'service-3.jpg',
    // Add more image URLs as needed
);

// Loop through the image URLs to create image tags
foreach ($imageUrls as $imageUrl) {
    echo '<img class="gallery-image" src="' . $imageUrl . '" alt="Image">';
}
?>

<script>
    // Add click event to each image tag
    var galleryImages = document.getElementsByClassName('gallery-image');

    for (var i = 0; i < galleryImages.length; i++) {
        galleryImages[i].addEventListener('click', function() {
            // Get the source of the clicked image
            var imageUrl = this.src;

            openPopup(imageUrl ); 
        });
    }

    function openPopup(imagePath) {
  const popupWindow = window.open('', '_blank', 'width=800,height=600');
  popupWindow.document.write(`

        <img src="${imagePath}" alt="Enlarged Image">

  `);
  popupWindow.document.close();
}

</script>

</body>
</html>