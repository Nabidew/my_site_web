<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_salle";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Nom']) && !empty($_POST['Nom']) && isset($_POST['Prenom']) && !empty($_POST['Prenom']) && isset($_POST['adresse']) && !empty($_POST['adresse'])
 && isset($_POST['Email']) && !empty($_POST['Email'])) {
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $adresse = $_POST['adresse'];
    $Email = $_POST['Email'];
    

    // Prepare the SQL statement
    $sql_insert = "INSERT INTO membree (Nom, Prenom,adresse, Email) VALUES (?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql_insert);
    
    // Bind the parameters
    $stmt->bind_param("ssss", $Nom ,$Prenom ,$adresse ,$Email);
    
    // Execute the statement
    if ($stmt->execute()) {
        header("Location:form.php"); // Rediriger vers la page des membres après l'ajout
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: bisque;
}

.form-container {
    width: 50%;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h3 {
    text-align: center;
    color:  #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    color: #555;
}

input[type="text"] {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 3px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
<div class="form-container">
    <h3>Add Member</h3>
    <form name="form" action="" method="POST">
        <label for="Nom">Nom:</label><br>
        <input type="text" id="Nom" name="Nom"><br>
        <label for="Prenom">Prenom:</label><br>
        <input type="text" id="Prenom" name="Prenom"><br>
        <label for="adresse">Adresse:</label><br>
        <input type="text" id="adresse" name="adresse"><br>
        <label for="Email">Email:</label><br>
        <input type="text" id="Email" name="Email"><br><br>
        <input type="submit" value="Add member">
    </form>
</div>
</body>
</html>
