<!DOCTYPE html>
<html>
<head>
    <title>User Data Form</title>
    <style>
        /* Your existing CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <h2>User Data Form</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        // Database connection
        $servername = "database.cro4tmy0fvoq.ap-southeast-1.rds.amazonaws.com";
        $username = "admin";
        $password = "admin123";
        $database = "userdata";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $email = $_POST['email'];

            $sql = "INSERT INTO users (username, email) VALUES ('$username', '$email')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>New record created successfully</p>";
            } else {
                echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }

        // Fetch and display user data
        $result = $conn->query("SELECT * FROM users");
        if ($result->num_rows > 0) {
            echo "<h2>User Data</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No user data found.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
