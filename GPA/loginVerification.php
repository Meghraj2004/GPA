<?php
    $data = json_decode(file_get_contents('dataforlogin.json'), true);
   
			// If all required fields are present, proceed with data processing
			$mysqli = new mysqli("localhost", "root", "", "gpa");

		// Check connection
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: " . $mysqli->connect_error;
			exit();
		}


		$username = $data['username'];
		$p_password =$data['password'];
		$p_color_password =$data['passwordFieldColor'];
		$p_category =$data['category'];
        $graphical_pass=$_GET['hiddenpass']; 
        
    // Check connection
    
		$query = "SELECT ColorPassword, password, category, GraphicalPassword FROM users WHERE username = ?";
		$stmt = $mysqli->prepare($query);

		// Bind parameters and execute query
		$stmt->bind_param("s", $username);
		$stmt->execute();

		// Bind variables to store results
		$stmt->bind_result($colorPassword, $password, $category,$GPA);

		// Fetch the result into variables
		if ($stmt->fetch()) {
			// Check if provided password matches stored password hash
			if ($p_password== $password) {
				if($p_category==$category &&  $colorPassword==$p_color_password && $graphical_pass==$GPA){
					echo "Successs";
				}else{
					echo "Failssssss";
				}
				
			} else {
				// Incorrect password
				echo "Incorrect password.<br>".$p_password.$password;
			}
		} else {
			// No user found with the provided username
			echo "No user found with username: " . $username;
		}


		// Close statement and connection
		$stmt->close();
		
		



// Close the connection
$mysqli->close();

  
?>
