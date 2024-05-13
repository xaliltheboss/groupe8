



<?php
require_once "../includes/config.php";

// Vérifier si l'étudiant est connecté
session_start();
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: ../index.php");
    exit();
}

// Récupérer l'identifiant de l'étudiant connecté
$student_id = $_SESSION['id_etudiant'];

// Récupérer les informations de l'étudiant
// $conn = connectDB();
$sql_student_info = "SELECT * FROM etudiants WHERE id_etudiant = '$student_id'";
// $sql_student_info = "SELECT * FROM etudiants WHERE id_etudiant = ?";
$result_student_info = $conn->query($sql_student_info);

if ($result_student_info->num_rows > 0) {
    $student_info = $result_student_info->fetch_assoc();
    $matricule = $student_info['matricule'];
    $nom = $student_info['nom'];
    $prenom = $student_info['prenom'];
    $adresse = $student_info['adresse'];
    $telephone = $student_info['telephone'];
} else {
    // L'étudiant n'existe pas
    echo "Erreur : Impossible de récupérer les informations de l'étudiant.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations administratives de l'étudiant</title>
</head>
<body>
    <h1>Informations administratives de l'étudiant</h1>
    <p><strong>Matricule :</strong> <?php echo $matricule; ?></p>
    <p><strong>Nom :</strong> <?php echo $nom; ?></p>
    <p><strong>Prénom :</strong> <?php echo $prenom; ?></p>
    <p><strong>Adresse :</strong> <?php echo $adresse; ?></p>
    <p><strong>Téléphone :</strong> <?php echo $telephone; ?></p>
    <p><a href="change_password.php">Modifier le mot de passe</a></p>
</body>
</html>
