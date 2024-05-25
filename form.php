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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Nom']) && !empty($_POST['Nom']) && isset($_POST['Prenom']) && !empty($_POST['Prenom']) && isset($_POST['Email']) && !empty($_POST['Email'])) {
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];  // Corrected to ensure Prenom is captured
    $Email = $_POST['Email'];

    // Prepare the SQL statement
    $sql_insert = "INSERT INTO membree (Nom, Prenom,adresse, Email) VALUES (?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql_insert);
    
    // Bind the parameters
    $stmt->bind_param("sss", $Nom, $Prenom, $Email);  // Corrected to include Prenom
    
    // Execute the statement
    if ($stmt->execute()) {
       
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// Properly concatenate $id_admin in the SQL query
$sql_select = "SELECT membree.idm, membree.Nom , membree.Prenom,membree.adresse,membree.Email FROM membree";
$result = $conn->query($sql_select);

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
    padding: 0;
    background-color: bisque;
    width: 80%;
    margin: 50px auto;
    margin-top: 110px;
    margin-bottom: 30px;

}

h3 {
    text-align: center;
    background-color: violet;
    margin-top: 20px;
    color: #333;
}

.table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.btn-add {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
}

.btn-add:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
<h3>Membres list</h3>
<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Adresse</th>
            <th>Email</th>
           
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["Nom"] . "</td>
                        <td>" . $row["Prenom"] . "</td>
                        <td>" . $row["adresse"] . "</td>
                        <td>" . $row["Email"] . "</td>
                       
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No members found.</td></tr>";
        }
        ?>
    </tbody>
</table>
<div class="d-flex justify-content-between align-items-center mb-3" style="padding: 0 50px;">
    <form name="form" action="membre.php" method="POST"> <!-- Corrected action URL to point to form.php -->
        <button type="submit" class="btn btn-add">&#10009; Add member</button>
    </form>
</div>
</body>
</html>
