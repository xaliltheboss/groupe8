<?php
require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $id_etudiant = $_POST['id_etudiant'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $id_formation = $_POST['id_formation'];

    // Préparer la requête SQL pour mettre à jour les informations de l'étudiant
    $sql = "UPDATE etudiants SET nom = ?, prenom = ?, adresse = ?, telephone = ?, id_formation = ? WHERE id_etudiant = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $nom, $prenom, $adresse, $telephone, $id_formation, $id_etudiant);

    // Exécuter la requête
    if ($stmt->execute()) {
        header("Location: students_list.php"); // Rediriger vers la liste des étudiants après la mise à jour
        exit();
    } else {
        echo "Erreur lors de la mise à jour des informations de l'étudiant: " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
}

// Récupérer les informations de l'étudiant à partir de l'URL
$id_etudiant = $_GET['id_etudiant'];
$sql = "SELECT * FROM etudiants WHERE id_etudiant = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_etudiant);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Aucun étudiant trouvé avec cet identifiant.";
    exit();
}

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les informations de l'étudiant</title>
</head>
<body>
    <h1>Modifier les informations de l'étudiant</h1>
    <form action="" method="post">
        <input type="hidden" name="id_etudiant" value="<?php echo $row['id_etudiant']; ?>">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $row['nom']; ?>" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $row['prenom']; ?>" required>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo $row['adresse']; ?>" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo $row['telephone']; ?>" required>

        <label for="id_formation">Formation :</label>
        <input type="text" id="id_formation" name="id_formation" value="<?php echo $row['id_formation']; ?>" required>

        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
