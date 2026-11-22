sudo tee /var/www/html/login.php > /dev/null << 'EOF'
<?php
$servername = "atabase-server-lab7.c0jaqo8i0nqb.us-east-1.rds.amazonaws.com";
$username   = "admin";
$password   = "Huy428293*";
$dbname     = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ket noi khong thanh cong: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM User WHERE userName=? AND password=?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Ban da dang nhap thanh cong";
    } else {
        echo "Ban da dang nhap khong thanh cong";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dang nhap</title>
</head>
<body>
    <h2>Dang nhap</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Ten dang nhap:</label>
        <input type="text" name="username"><br><br>
        <label>Mat khau:</label>
        <input type="password" name="password"><br><br>
        <input type="submit" value="Dang nhap">
    </form>
</body>
</html>
EOF
sudo sed -i "s|MAT_KHAU_RDS|$PW|" /var/www/html/login.php
sudo chown -R www-data:www-data /var/www/html/
unset PW