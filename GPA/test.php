<html>
<head>
<style>
 .image-container2 {
            width: 80px; /* Set a fixed width for the image container */
            height: 60px; /* Set a fixed height for the image container */
            border: 1px solid #ccc;
            box-shadow: 0px 5px 10px 2px rgba(8, 14, 44, 0.5);
            display: inline-block; /* Set to inline-block to allow multiple containers to be displayed in the same row */
            margin: 12px; /* Add margin to separate image containers horizontally */
            cursor: pointer; /* Add cursor pointer to indicate clickable */
			transition: transform 1s ease;
			border-radius: 12px;
        }
        .image-container2 img {
			width: 80px; /* Set a fixed width for the image container */
            height: 60px;
            max-width: 100%; /* Ensure the image fills the container */
            max-height: 100%; /* Ensure the image fills the container */
			border-radius: 12px;
        }
</style>
<body>
<?php
// Function to split PNG image into 3x3 parts
function splitImageIntoNineParts($imagePath) {
    // Load image
    $image = imagecreatefrompng($imagePath);

    // Get image dimensions
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    // Calculate dimensions for each part
    $partWidth = $imageWidth / 3;
    $partHeight = $imageHeight / 3;

    $parts = [];

    // Loop through each part
    for ($row = 0; $row < 3; $row++) {
        for ($col = 0; $col < 3; $col++) {
            // Create new image for this part
            $part = imagecreatetruecolor($partWidth, $partHeight);

            // Set transparency for PNG
            imagesavealpha($part, true);
            $transparent = imagecolorallocatealpha($part, 0, 0, 0, 127);
            imagefill($part, 0, 0, $transparent);

            // Copy part from original image
            imagecopy($part, $image, 0, 0, $col * $partWidth, $row * $partHeight, $partWidth, $partHeight);

            // Store part in array
            $parts[] = $part;
        }
    }

    return $parts;
}


// Example usage:
$imagePath = "images/profile.png"; // Replace with your PNG image path
$parts = splitImageIntoNineParts($imagePath);

// Output each part (you can modify this based on your needs)
foreach ($parts as $index => $part) {
    imagepng($part, "part_$index.png"); // Save each part as PNG
	echo "<div class='image-container2'>
                    <img src='part_$index.png' alt='' onclick='handleImageClick(this)' style='border:none'>
                 </div>";
    imagedestroy($part); // Clean up memory
}


?>
</body>
</html>
