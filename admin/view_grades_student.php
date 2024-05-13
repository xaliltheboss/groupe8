<?php
require_once "../includes/config.php";

// Traitement du formulaire si soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération du numéro de matricule saisi
    $matricule = $_POST['matricule'];

    // Récupérer les informations de l'étudiant
    // $conn = connectDB();
    $sql_student = "SELECT * FROM etudiants WHERE matricule = '$matricule'";
    $result_student = $conn->query($sql_student);

    if ($result_student->num_rows > 0) {
        $student = $result_student->fetch_assoc();
        $student_id = $student['id_etudiant'];
        $student_name = $student['prenom'] . ' ' . $student['nom'];

        // Récupérer les notes de l'étudiant dans toutes les matières
        $sql_notes = "SELECT matieres.libelle_matiere, notes.valeur_note 
                      FROM notes INNER JOIN matieres ON notes.id_matiere = matieres.id_matiere 
                      WHERE notes.id_etudiant = '$student_id'";
        $result_notes = $conn->query($sql_notes);
    } else {
        // Aucun étudiant trouvé avec ce numéro de matricule
        echo "Aucun étudiant trouvé avec ce numéro de matricule.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consulter les notes de l'étudiant</title>
</head>
<body>
    <h1>Consulter les notes de l'étudiant</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="matricule">Numéro de matricule de l'étudiant :</label>
        <input type="text" id="matricule" name="matricule" required><br><br>

        <input type="submit" value="Consulter les notes">
    </form>
    <?php if (isset($result_notes) && $result_notes->num_rows > 0) : ?>
        <h2>Notes de l'étudiant <?php echo $student_name; ?></h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_notes->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row["libelle_matiere"]; ?></td>
                        <td><?php echo $row["valeur_note"]; ?></td>
                        <td><a href="update_grades.php?id_etudiant=<?php echo $student_id; ?>&id_matiere=<?php echo $row['id_matiere']; ?>">Modifier</a></td>
                        
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <p><a href="admin_dashboard.php">Retour au tableau de bord</a></p>
</body>
</html>
