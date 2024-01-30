<?php

include_once 'fortydb.php';

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = sanitize($_POST['firstname']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $rePassword = sanitize($_POST['re-password']);

    $sql = "SELECT * FROM `usertbl` WHERE `email` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Email already exists";
    }

    if ($password !== $rePassword) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `usertbl`(`name`, `email`, `password`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $firstname, $email, $hashedPassword);
        if ($stmt->execute()) {
            header("Location: index.html");
            exit;
        } else {
            $errors[] = "Failed to register. Please try again.";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <style>
        body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
}

h1 {
  text-align: center;
  color: #333;
  margin-top: 50px;
}

form {
  width: 300px;
  margin: 0 auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

input {
  width: 100%;
  margin-bottom: 10px;
  padding: 10px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 5px;
}

input[type='text'],
input[type='password'] {
  color: #555;
}

input[type='text']:focus,
input[type='password']:focus {
  outline: none;
  border-color: #007bff;
}
.error {
    justify-content: center;
    align-items: center;
    text-align: center;
    margin-top: 1rem;
    background-color: #f8d7da;
    color: #721c24; 
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #f5c6cb; 
    border-radius: 5px;

}

.error ul {
    list-style-type: none; 
    padding: 0;
    margin: 0;
}

.error li {
    margin-bottom: 5px;
}

input[type='submit'] {
  background-color: #4caf50;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s;
}

input[type='submit']:hover {
  background-color: #45a049;
}

    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Registration</h1>
    <form action="registration.php" method="post">
        <input type="text" name="firstname" id="mail-name" placeholder="First Name" required>
        <input type="email" name="email" id="mail-email" placeholder="Email" required>
        <input type="password" name="password" id="mail-password" placeholder="Password" required>
        <input type="password" name="re-password" id="mail-repassword" placeholder="Confirm Password" required>
        <input type="submit" name="submit" id="mail-submit" value="Submit">
    </form>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>
