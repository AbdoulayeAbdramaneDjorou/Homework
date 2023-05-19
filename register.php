<!DOCTYPE html>
<html>
<head>
    <title>Student Registration Form</title>
</head>
<body>
    <h1>Student Registration Form</h1>

    <?php
    // Validate and process the form data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate input
        $full_name = test_input($_POST["full_name"]);
        $email = test_input($_POST["email"]);
        $gender = $_POST["gender"];

        // Perform server-side validation
        $errors = array();

        if (empty($full_name)) {
            $errors[] = "Full name is required";
        }

        if (empty($email)) {
            $errors[] = "Email address is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        if (empty($gender)) {
            $errors[] = "Gender is required";
        }

        // If there are no validation errors, insert the data into the database
        if (empty($errors)) {
            // Database connection details
            $servername = "localhost";
            $username = "route";
            $password = "";
            $dbname = "register";

            // Create a new PDO instance
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // Prepare and execute the SQL query
            $stmt = $conn->prepare("INSERT INTO student (full_name, email, gender) VALUES (:full_name, :email, :gender)");
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':gender', $gender);
            $stmt->execute();

            echo "Registration successful!";
        } else {
            // Display validation errors
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    }

    // Function to sanitize input data
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
</body>
</html>
