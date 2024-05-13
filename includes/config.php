<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "etudiant";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Échec de la connexion à la base de données : " . $conn->connect_error);
// }
?>

<?php
// Informations de connexion à la base de données
$servername = "localhost"; // Adresse du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$dbname = "etudiant"; // Nom de la base de données

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}else {
    // En cas de succès, afficher un message de confirmation
    echo "Connexion à la base de données réussie !";}
?>
