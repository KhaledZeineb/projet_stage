<?php
$servername = "localhost"; // Database host (usually localhost)
$username = "root"; // Database username
$password = ""; // Database password
$database = "mydb"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name']; // Utilisez 'tmp_name'
    $folder = 'Images/' . $file_name;

    $query = mysqli_query($conn, "INSERT INTO photo_de_profile (photo) VALUES ('$file_name')");
    if (move_uploaded_file($tempname, $folder)) {
        echo "<h2>File uploaded successfully</h2>";
    } else {
        echo "<h2>File not uploaded</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" id="image">
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
    <div>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM photo_de_profile");
        while ($row = mysqli_fetch_assoc($res)) {
            ?>
            <img src="Images/<?php echo $row['photo']; ?>" alt="Uploaded Image" />
            <?php
        }
        ?>
    </div>
</body>
</html>
