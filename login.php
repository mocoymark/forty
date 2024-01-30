  <?php

include_once 'fortydb.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `usertbl` WHERE `email` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['id'] = $row['id']; 
            header("Location: contact.php");
            exit;
        } else {
            $errors[] = "Invalid email or password";
        }
    } else {
        $errors[] = "Invalid email or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Sign In</title>
   <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    h1 {
      color: #333;
      margin-bottom: 20px;
    }

    form {
      width: 300px;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    input {
      width: 100%;
      margin-bottom: 15px;
      padding: 10px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    input[type='text'],
    input[type='password'] {
      color: #555;
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
 <?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
 <?php endif; ?>
 <h1>Sign in</h1>
 <form action="login.php" method="post">
  <input type="text" name="email" id="mail-email" placeholder="Email" />
  <input type="password" name="password" id="mail-password" placeholder="Password" />
  <input type="submit" name="submit" id="mail-submit" value="Sign In" />
 </form>
</body>
</html>
  
  
  
