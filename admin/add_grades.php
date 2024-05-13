<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure le fichier de configuration de la base de données
    require_once "../includes/config.php";

    // Récupérer les données du formulaire
    $matricule_etudiant = $_POST['matricule_etudiant'];
    $code_matiere = $_POST['code_matiere'];
    $note = $_POST['note'];

    // Récupérer l'id de l'étudiant en fonction du matricule
    $sql_etudiant = "SELECT id_etudiant FROM etudiants WHERE matricule = ?";
    $stmt_etudiant = $conn->prepare($sql_etudiant);
    $stmt_etudiant->bind_param("s", $matricule_etudiant);
    $stmt_etudiant->execute();
    $result_etudiant = $stmt_etudiant->get_result();

    if ($result_etudiant->num_rows > 0) {
        $row_etudiant = $result_etudiant->fetch_assoc();
        $id_etudiant = $row_etudiant['id_etudiant'];

        // Récupérer l'id de la matière en fonction du code
        $sql_matiere = "SELECT id_matiere FROM matieres WHERE code_matiere = ?";
        $stmt_matiere = $conn->prepare($sql_matiere);
        $stmt_matiere->bind_param("s", $code_matiere);
        $stmt_matiere->execute();
        $result_matiere = $stmt_matiere->get_result();

        if ($result_matiere->num_rows > 0) {
            $row_matiere = $result_matiere->fetch_assoc();
            $id_matiere = $row_matiere['id_matiere'];

            // Préparer et exécuter la requête SQL pour ajouter la note
            $sql_note = "INSERT INTO notes (id_etudiant, id_matiere, valeur_note) VALUES (?, ?, ?)";
            $stmt_note = $conn->prepare($sql_note);
            $stmt_note->bind_param("iii", $id_etudiant, $id_matiere, $note);

            if ($stmt_note->execute()) {
                echo "La note a été ajoutée avec succès.";
            } else {
                echo "Erreur lors de l'ajout de la note: " . $conn->error;
            }
        } else {
            echo "Code de matière invalide.";
        }
    } else {
        echo "Matricule d'étudiant invalide.";
    }

    // Fermer les déclarations
    $stmt_etudiant->close();
    $stmt_matiere->close();
    $stmt_note->close();
    // Fermer la connexion à la base de données
    $conn->close();
}
?>

<!-- Formulaire pour ajouter une note d'un étudiant -->
<form action="add_grades.php" method="post">
    <label for="matricule_etudiant">Matricule de l'étudiant :</label>
    <input type="text" id="matricule_etudiant" name="matricule_etudiant" required>

    <label for="code_matiere">Code de la matière :</label>
    <input type="text" id="code_matiere" name="code_matiere" required>

    <label for="note">Note :</label>
    <input type="number" step="0.01" id="note" name="note" required>

    <input type="submit" value="Ajouter Note">
</form>
