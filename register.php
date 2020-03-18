<html>
<title>Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
  <link rel="stylesheet" href="styles.css"/>
  <style>
  .form {
    margin-left: auto;
    margin-right: auto;
    width: 30%;
  }
  </style>
</head>
<body>
<h1><a href="index.php" class="head">Simplified Technology Services Inc.</a></h1>
<div class="nav">
  <a href="operators.php">Operators</a>
  <a href="farms.php">Farms</a>
  <a href="fields.php">Fields</a>
  <a href="prices.php">Prices</a>
  <a href="crop.php">Crop</a>
  <a href="applicants.php">Applications</a>
  <a href="#Chemicals">Chemicals</a>
  <a href="#Feritalizers">Feritalizers</a>
  <a href="forms.php">Forms</a>
  <?php
  session_start();
  $server = "localhost";
  $uname = "client";
  $pword = "Pass";
try {
  $connection = new PDO("mysql:host=$server;dbname=simplifiedtechnologyservices",$uname,$pword);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::FETCH_ASSOC);
}
catch (PDOException $e){echo "failed to connect to database, " . $e->getMessage();}
if ($_SESSION['ID'] == null) {
  echo '<a href="login.php" class="Login">Login</a>';
}
else {
$sql = "SELECT name FROM users WHERE UserID = ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$_SESSION['ID']]);
$name = $stmt->fetch();
echo '<a href="#account">'.$name[0].'</a>';
}
  ?>
  </div>
  <div class="form">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <p>Name: <input  name="name"/></p>
    <p>Phone: <input  name="phone" type="number"/></p>
  <p>Email:
    <input name = "email"/></p>
  <p>Password:
    <input name = "password" type="password"/></p>
  <input type="submit"/>
  </form>
</div>
  <?php
  session_start();
  $server = "localhost";
  $uname = "client";
  $pword = "Pass";
try {
  $connection = new PDO("mysql:host=$server;dbname=simplifiedtechnologyservices",$uname,$pword);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::FETCH_ASSOC);
}
catch (PDOException $e){echo "failed to connect to database, " . $e->getMessage();}
if (empty($_REQUEST["email"])) {}
else {
$email = $_REQUEST["email"];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  exit("invalid email");
}
$sql = "SELECT email FROM users WHERE email = ?;";
$statement = $connection->prepare($sql);
$statement->execute([$email]);
$norepeat = $statement->fetch(PDO::FETCH_NUM);
if (!empty($norepeat)) {
  echo "email already in use";
}
else {
  $name = $_REQUEST["name"];
  $phone = $_REQUEST["phone"];
  $email = $_REQUEST["email"];
  $password = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
  $sql = "INSERT INTO users (name, phone, email, password) Values (?,?,?,?);";
  $statement = $connection->prepare($sql);
  $statement->execute([$name, $phone, $email, $password]);
  $sql = "SELECT UserID FROM users WHERE email = ? AND password = ?;";
  $statement = $connection->prepare($sql);
  $statement->execute([$email, $password]);
  $arr = $statement->fetch(PDO::FETCH_NUM);
if(!$arr) exit('<a href="register.php">Register</a>');
  $_SESSION['ID'] = $arr[0];
  header("Location: index.php");
}}
  ?>
</body>
</html>
