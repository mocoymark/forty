

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
</head>
   <style>
        h1 {
            text-align: center;
            color: #333;
            margin-top: 10%;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: darkgreen;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: green;
        }
        .error {
            text-align: center;
            background-color: #ffcccc;
            color: #cc0000;
            border: 1px solid #cc0000;
            padding: 1px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .error ul {
            list-style-type: none;
            padding: 0;
        }

        .error li {
            margin-bottom: 5px;
        }
    </style>
<body>
 <h1>Edit Contact</h1>
 <form action="" method="post">
  <input type="text" name="name" id="mail-name" placeholder="name">
  <input type="text" name="company" placeholder="company">
  <input type="number" name="phone" id="company-phone">
  <input type="text" name="email" id="company-email">
  <input type="submit" name="submit" value="submit">
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
