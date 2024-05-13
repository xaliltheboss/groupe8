<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../includes/config.php";
    $matricule = $_POST["matricule"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse = $_POST["adresse"];
    $telephone = $_POST["telephone"];
    $id_formation = $_POST['id_formation'];
    // Préparer la requête SQL pour insérer un nouvel étudiant
    $sql = "INSERT INTO etudiants (matricule, nom, prenom, adresse, telephone, id_formation) VALUES (?, ?, ?, ?, ?, ?)";

    // Préparer la déclaration
    $stmt = $conn->prepare($sql);
    
    // Liaison des paramètres
    $stmt->bind_param("sssssi", $matricule, $nom, $prenom, $adresse, $telephone, $id_formation);

    // Exécution de la requête
    if ($stmt->execute()) {
        // Redirection vers une page de confirmation
        header("Location: admin.php");
        exit();
    } else {
        // Gérer les erreurs
        echo "Erreur: " . $conn->error;
    }

    // Fermer la déclaration
    $stmt->close();
}



// Récupérer les formations depuis la base de données
$servername = "localhost"; // Adresse du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$dbname = "etudiant"; // Nom de la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
$sql_formations = "SELECT id_formation, libelle_formation FROM formations";
$result_formations = $conn->query($sql_formations);
// Fermer la connexion à la base de données
$conn->close();
?>

<!-- Formulaire d'inscription d'un étudiant -->
<form action="" method="post">
    <label for="matricule">Matricule :</label>
    <input type="text" id="matricule" name="matricule" required>

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" required>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" required>

    <label for="adresse">Adresse :</label>
    <input type="text" id="adresse" name="adresse" required>

    <label for="telephone">Téléphone :</label>
    <input type="text" id="telephone" name="telephone" required>

    <label for="id_formation">Formation :</label>
    <select id="id_formation" name="id_formation" required>
        <option value="">Sélectionner une formation</option>
        <?php
        // Afficher les options pour les formations disponibles
        if ($result_formations->num_rows > 0) {
            while ($row = $result_formations->fetch_assoc()) {
                echo "<option value='" . $row['id_formation'] . "'>" . $row['libelle_formation'] . "</option>";
            }
        }
        ?>
    </select><br><br>

    <input type="submit" value="Inscrire">
</form>
