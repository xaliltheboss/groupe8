

<?php
// Connexion à la base de données
require_once "../includes/config.php";
session_start();
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: ../index.php");
    exit();
}
// Récupérer les matières depuis la base de données
$sql = "SELECT id_matiere, libelle_matiere FROM matieres";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Sélection de la matière</title>
</head>
<body>
    <h1>Sélectionnez une matière :</h1>
    <form action="../traitement.php" method="get">
        <label for="matiere">Matière :</label>
        <select name="id_matiere" id="matiere">
            <?php
            // Vérifier si des matières sont disponibles
            if ($result->num_rows > 0) {
                // Parcourir les résultats et afficher chaque option du menu déroulant
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id_matiere"] . "'>" . $row["libelle_matiere"] . "</option>";
                }
            } else {
                echo "<option value=''>Aucune matière disponible</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Afficher les notes">
    </form>
</body>
</html>
