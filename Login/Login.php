<?php
session_start();

include '../db_connect.php'; // Ensure this connects to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query to fetch the user's details
    $sql = "SELECT * FROM Login WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Bind the username
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user's data
        $row = $result->fetch_assoc();

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $row['password'])) {
            // Store user data in the session
            $_SESSION['UserID'] = $row['userID'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username']; // Store the username (or full name if available)

            // Redirect user based on their role
            if ($row['role'] == 'admin') {
                header("Location: ../Administrator/AdminPage/AdminPage.php?role=admin");
            } elseif ($row['role'] == 'customer') {
                header("Location: ../Module 2/userdashboard.php?role=customer");
            } elseif ($row['role'] == 'staff') {
                header("Location: ../Staff/StaffDashboard/Staff Dashboard.php?role=staff");
            }
            exit();
        } else {
            // Display an error message if the password is incorrect
            echo "<p style='color: red;'>Invalid username or password!</p>";
        }
    } else {
        // Display an error message if no user is found
        echo "<p style='color: red;'>Invalid username or password!</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RapidPrint Login</title>
	<link rel="icon" href="UMPSAlogo.png" type="image/png">
    <link rel="stylesheet" href="LoginCSS.css">
    <script src="LoginScript.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="UMPSAlogo.png" alt="Logo">
            <span class="brandName">RapidPrint</span>
        </div>
        
        <button class="home-button" onclick="window.location.href='../Webpage/Webpage.html';">Home</button>
    </div>

    <div class="container">
        <form method="POST">
            <h2>Login</h2>
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
