<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $graduationYear = $_POST["graduation_year"];
    $mobileNumber = $_POST["mobile_number"];
    $whatsappNumber = $_POST["whatsapp_number"];
    $technicalSkills = $_POST["technical_skills"];
    $aboutMe = $_POST["about_me"];
    
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registration";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute an SQL statement to insert the form data into the database table
    $sql = "INSERT INTO registration (name, email, graduation_year, mobile_number, whatsapp_number, technical_skills, about_me)
            VALUES ('$name', '$email', '$graduationYear', '$mobileNumber', '$whatsappNumber', '$technicalSkills', '$aboutMe')";

    if ($conn->query($sql) === TRUE) {
        // Retrieve and handle the uploaded resume
        $resume = $_FILES["resume"]["name"];
        $resumeTempPath = $_FILES["resume"]["tmp_name"];
        $resumeDestination = "resumes/" . $resume;
        move_uploaded_file($resumeTempPath, $resumeDestination);
        
        // Store the resume file path in the database
        $resumePath = "resumes/" . $resume;
        $sqlResume = "UPDATE registration SET resume='$resumePath' WHERE email='$email'";
        $conn->query($sqlResume);
        
        // Redirect to a success page
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
