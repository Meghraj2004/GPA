<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Images from MySQL</title>
    <style>
        #body {
           background-color: rgba(255, 255, 255, 0.5); /* light gray background */
			 position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
			 background-color:grey;
        }
        .header {
			background-color: white;
			padding: 20px;
			border: 1px solid #ccc;
			width: 90%; /* Adjusted width for responsiveness */
			max-width: 700px; /* Maximum width for larger screens */
			box-shadow: 0px 0px 10px 2px rgba(8, 14, 44, 0.1);
			margin: 50px auto;
			border-radius: 20px;
			text-align: center; /* Center align the content horizontally */
			display: flex;
			justify-content: center; /* Center horizontally */
			align-items: center; /* Center vertically */
			height: 50px; /* Fixed height for the header */
		}
		@media screen and (max-width: 768px) {
			.header {
				padding: 15px; /* Adjust padding for smaller screens */
				height: auto; /* Allow height to adjust based on content */
				flex-direction: column; /* Stack content vertically on smaller screens */
			}
		}
		.header button{
			margin:100px;
		}
		.footer {
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            width: 700px;
            box-shadow: 0px 0px 10px 2px rgba(8, 14, 44, 0.1);
            
            border-radius: 20px;
            text-align: center; /* Center align the content horizontally */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 50px; /* Fixed height for the header */
        }
		
        .white-bg {
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            width: 85vw; /* Full width of the viewport */
        height: 70vh; /* set height to 500px */
            box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.1); /* add shadow */
            margin: 50px auto; /* center div horizontally */
            border-radius: 20px; /* add border radius */
            overflow: auto; /* enable scrolling if content exceeds div height */
        }
        .image-container2 {
            max-width: 25%; /* Set a fixed width for the image container */
            max-height: 30%; /* Set a fixed height for the image container */
            border: 1px solid #ccc;
            box-shadow: 0px 5px 10px 2px rgba(8, 14, 44, 0.5);
            display: inline-block; /* Set to inline-block to allow multiple containers to be displayed in the same row */
            margin: 10px; /* Add margin to separate image containers horizontally */
            cursor: pointer; /* Add cursor pointer to indicate clickable */
			transition: transform 1s ease;
			border-radius: 12px;
			justify-content:center;
        }
        .image-container2 img {
			
			border-radius: 2px;
        }
        .image-container {
            width: 200px; /* Set a fixed width for the image container */
            height: 150px; /* Set a fixed height for the image container */
            border: 1px solid #ccc;
            position:center;
            box-shadow: 0px 5px 10px 2px rgba(8, 14, 44, 0.5);
            display: inline-block; /* Set to inline-block to allow multiple containers to be displayed in the same row */
            margin-left: 150px; /* Add margin to separate image containers horizontally */
            margin-top: 55px;
			margin-bottom: 55px;
			cursor: pointer; /* Add cursor pointer to indicate clickable */
			transition: transform 1s ease;
			border-radius: 12px;
        }

        .image-container img {
			width: 200px; /* Set a fixed width for the image container */
            height: 150px;
            max-width: 100%; /* Ensure the image fills the container */
            max-height: 100%; /* Ensure the image fills the container */
			border-radius: 12px;
        }
		.dialog {
			margin-top:500px;
			display: none;
			position: fixed;
		    border-radius:2%;
			top: 50%;
			left: 40%;
			transform: translate(-50%, -50%);
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
			padding: 2px;
			z-index: 1000;
			width: 40%;
			height:10%;
            position: relative;
		}
		.dialog img {
			width:550px;
			height:350px;
			max-width: 100%;
			height: auto;
			display: block;
			margin: 10px;
			
		}
		.dialog .close-icon {
			position: absolute;
			top: 10px;
			right: 10px;
			cursor: pointer;
			font-size: 24px; /* Increased font size */
			color: #333;
			font-weight: bold; /* Make it bold */
		}
		.blur-background {
			filter: blur(5px); /* Adjust blur intensity as needed */
			pointer-events: none; /* Prevent interaction with blurred background */
		}
        .dialog-blur {
			backdrop-filter: blur(0px); /* Apply backdrop filter for blur effect */
			background-color: rgba(255, 255, 255, 0.8); /* Adjust background color opacity */
			pointer-events: auto; /* Enable interaction with dialog */
		}
		.non-blur-content {
    backdrop-filter: brightness(100%); /* or backdrop-filter: none; */
    /* Additional styles for the non-blur content */
}  
		.image-container:hover {
			transform: scale(1.1); /* Scale up by 5% on hover */
			box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3); /* Adjust shadow on hover */
		}

    </style>
</head>
<body>
<div id="body">
<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the required fields are set in the $_GET array
    $required_fields = ['first_name', 'last_name', 'email', 'phone_number', 'date_of_birth', 'gender', 'username', 'password'];
    foreach ($required_fields as $field) {
        if (!isset($_GET[$field]) || empty($_GET[$field])) {
            die("Error: '$field' is required.");
        }
    }

    // If all required fields are present, proceed with data processing
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gpa";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Assuming you're sanitizing inputs before inserting into the database

		// Example of getting data from user input (you should sanitize and validate this data properly)
		$first_name = mysqli_real_escape_string($conn, $_GET['first_name']);
		$last_name = mysqli_real_escape_string($conn, $_GET['last_name']);
		$email = mysqli_real_escape_string($conn, $_GET['email']);
		$phone_number = mysqli_real_escape_string($conn, $_GET['phone_number']);
		$date_of_birth = mysqli_real_escape_string($conn, $_GET['date_of_birth']);
		$gender = mysqli_real_escape_string($conn, $_GET['gender']);
		$username = mysqli_real_escape_string($conn, $_GET['username']);
		$password = mysqli_real_escape_string($conn, $_GET['password']);
		$passwordFieldColor = mysqli_real_escape_string($conn, $_GET['passwordFieldColor']);
        $table = mysqli_real_escape_string($conn, $_GET['ownfield']);
		
		
			// Prepare a SELECT query to check if the username exists
			$query = "SELECT username FROM users WHERE username = ?";
			$stmt = $conn->prepare($query);

			// Bind the parameter
			$stmt->bind_param("s", $username);

			// Execute the query
			$stmt->execute();

			// Bind result variables
			$stmt->bind_result($existingUsername);

			// Fetch the result
			$stmt->fetch();

			// Check if a row was found (username exists)
			if ($existingUsername) {
				echo "<div class='header'  style='margin-top: 50px;'>
          <h2><b>Username '$username' already exists. Please choose a different username.</b></h2>
          <br><br><br>
          <input type='submit' value='Go Back' id='go_back_id' onclick=\"window.location.href = 'index.html';\">
      </div>";

				  exit();
				
			} 

			// Close statement and connection
			$stmt->close();


		// Create an array to store the data
		$data = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email' => $email,
			'phone_number' => $phone_number,
			'date_of_birth' => $date_of_birth,
			'gender' => $gender,
			'username' => $username,
			'password' => $password,
			'passwordFieldColor' => $passwordFieldColor,
			'category' => $table
		);
      
		// Convert the array to JSON format
		$json_data = json_encode($data, JSON_PRETTY_PRINT);

		// Specify the file name
		$file_name = 'data.json';

		// Write the JSON data to the file
		if (file_put_contents($file_name, $json_data)) {
			
		} else {
			echo "Unable to write data to $file_name.";
		}
		

    
    $sql = "SELECT path FROM $table";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='header'>
		    <form action='registrationFile.php' method='GET'>
            <h2><b>Select the Images as password for security purpose</b></h2><br><br>
			<input type='submit' value='Submit'>
			<input type='hidden' id='hiddenpass' name='hiddenpass'>
			</form>
        </div>
        <div class='white-bg'>
		";
        // Output data of each row
		 while ($row = $result->fetch_assoc()) {
            // Collect image paths into an array
            $image_paths[] = $row["path"];
        }
		shuffle($image_paths);
		foreach ($image_paths as $path) {
            echo "<div class='image-container'>
                    <img src='$path' name='img' id='myImage' alt='' onclick='handleImageClick(this)' style='border:none'>
                  </div>
				  ";
        }

        echo "</div>";
		
    } else {
        echo "0 results";
    }

    $conn->close();
}
?>

</div>
<div id="imageDialog" class="dialog" >
        <span class="close-icon" onclick="closeDialog()">&times;</span>
        
    </div>
<script>
var pass="";
var partCount=0;
document.getElementById('imageDialog').style.display = 'none';
function handleImageClick(img) {
    // Handle click event on the image (example: alert the image path)
	if(img.style.border !== "none"){
		img.style.border="none";
	}
	else{
		img.style.border = "2px solid blue";
		var imgDialog=document.getElementById('imageDialog');
		document.getElementById('imageDialog').style.display = 'block';
		splitImageIntoNineParts(img.src);
		
	}
}
 function closeDialog() {
	  var parentDiv=document.getElementById('imageDialog');
	      const children = parentDiv.children;

			// Loop through each child element
			for (let i = children.length - 1; i >= 0; i--) {
				const child = children[i];

				// Check if the element does not have the class 'close-icon'
				if (!child.classList.contains('close-icon')) {
					parentDiv.removeChild(child);
				}
			}
            parentDiv.style.display = 'none';
		
        }
 function splitImageIntoNineParts(imagePath) {
	        pass=pass+imagePath;
            var image = new Image();
           image.crossOrigin = "Anonymous"; // Enable CORS for the image if loading from a different origin
            image.src = imagePath;

            // Create a canvas element
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');

            // Wait for the image to load before processing
            image.onload = function() {
		
                var imageWidth = image.width;
                var imageHeight = image.height;

                // Calculate dimensions for each part
                var partWidth = imageWidth / 3;
                var partHeight = imageHeight / 3;

                var parts = [];
                
                // Loop through each part
                for (var row = 0; row < 3; row++) {
                    for (var col = 0; col < 3; col++) {
                        // Create new canvas for this part
                        canvas.width = partWidth;
                        canvas.height = partHeight;

                        // Draw part of the original image onto the canvas
                        ctx.drawImage(image, col * partWidth, row * partHeight, partWidth, partHeight, 0, 0, partWidth, partHeight);
                        
                        // Create new image element for this part
                        var partImage = new Image();
						partImage.name="part"+row+col+partCount;
						partImage.width=canvas.width;
						partImage.height=canvas.height;
						partCount++;
                        partImage.src = canvas.toDataURL(); // Convert canvas to data URL
                       
                        // Create a div container for each part
                        var container = document.createElement('div');
                        container.className = 'image-container2';
						 container.width = partImage.width; // Set the width of the image
							container.height = partImage.height;
                        container.appendChild(partImage);
						
						   (function(currentPartImage) {
                    currentPartImage.onclick = function() {
                       
							   if (pass.includes(currentPartImage.name)) {
									 pass = pass.replace(currentPartImage.name, '');
									 currentPartImage.parentNode.style.border="none";
								} else {
								   currentPartImage.parentNode.style.border="2px solid black";
									pass=pass+currentPartImage.name;
								}

                    };
                })(partImage); 
						var parentDiv=document.getElementById('imageDialog');
                         if(parentDiv.children.length<=9){
                        // Add the container to the main container
                          parentDiv.appendChild(container);
						 }
						
						
                    }
                }
 				
            };
           document.getElementById("hiddenpass").value+=pass;
           
        }


 
</script>

</body>
</html>
