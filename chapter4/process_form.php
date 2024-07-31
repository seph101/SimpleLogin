<?php
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate_username($username) {
    if (preg_match('/^[a-zA-Z0-9]{5,20}$/', $username)) {
        return true;
    }
    return false;
}

function validate_email($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function validate_password($password) {
    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        return true;
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);

    $errors = [];

    if (!validate_username($username)) {
        $errors[] = "Username must be alphanumeric and 5-20 characters long.";
    }

    if (!validate_email($email)) {
        $errors[] = "Invalid email format.";
    }

    if (!validate_password($password)) {
        $errors[] = "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    if (empty($errors)) {
        // Process the registration (e.g., save to database)
        echo "Registration successful!";
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
