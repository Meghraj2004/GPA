<?php
    $data = json_decode(file_get_contents('data.json'), true);
   
    // If all required fields are present, proceed with data processing
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gpa";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
	$first_name = $data['first_name'];
		$last_name =  $data['last_name'];
		$email = $data['email'];
		$phone_number = $data['phone_number'];
		$date_of_birth = $data['date_of_birth'] ;
		$gender = $data['gender'];
		$username = $data['username'];
		$password =$data['password'];
		$color_password =$data['passwordFieldColor'];
		$category =$data['category'];
        $current_timestamp = time(); 
        
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	echo "Hi";
	 $graphical_pass=$_GET['hiddenpass']; 
    $sql = "INSERT INTO users (first_name, last_name, email, phone_number, date_of_birth, gender, username, password, `GraphicalPassword`, created_at, ColorPassword, category)
        VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$date_of_birth', '$gender', '$username', '$password', '$graphical_pass', FROM_UNIXTIME($current_timestamp), '$color_password', '$category')";


// Execute the query (example using mysqli)
if ($conn->query($sql) === TRUE) {
    header("Location:login.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();

  
?>
