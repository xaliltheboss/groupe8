<?php
require_once "../includes/config.php";

// Vérifier si la clé 'id_formation' existe dans $_GET
if (isset($_GET['id_formation'])) {
    // Récupérer l'ID de la formation spécifiée dans l'URL
    $id_formation = $_GET['id_formation'];

    // Récupérer la liste des étudiants inscrits dans la formation spécifiée
    $sql = "SELECT e.matricule, e.nom, e.prenom
            FROM etudiants e
            INNER JOIN formations f ON e.id_formation = f.id_formation
            WHERE f.id_formation = '$id_formation'";
    $result = $conn->query($sql);
    echo "<h2>Liste des étudiants dans la formation</h2>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Matricule: " . $row["matricule"]. " - Nom: " . $row["nom"]. " - Prénom: " . $row["prenom"]. "<br>";
        }
    } else {
        echo "Aucun étudiant inscrit dans cette formation.";
    }
    $conn->close();
} else {
    // Si 'id_formation' n'est pas défini dans $_GET, afficher un message d'erreur
    echo "L'ID de la formation n'est pas spécifié dans l'URL.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants dans la formation</title>
</head>
<body>
    <h1>Liste des étudiants dans la formation</h1>
    <form action="" method="get">
        <label for="id_formation">ID de la formation :</label>
        <input type="text" id="id_formation" name="id_formation" required>
        <input type="submit" value="Afficher la liste des étudiants">
    </form>
</body>
</html>
