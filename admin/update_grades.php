<?php
   require_once "../includes/config.php";

// Vérifier si un étudiant est sélectionné
if (isset($_GET['id_etudiant'])) {
    $student_id = $_GET['id_etudiant'];

    // Récupérer les informations de l'étudiant
    // $conn = connectDB();
    $sql_student = "SELECT * FROM etudiants WHERE id_etudiant = '$student_id'";
    $result_student = $conn->query($sql_student);

    if ($result_student->num_rows > 0) {
        $student = $result_student->fetch_assoc();
        $student_name = $student['prenom'] . ' ' . $student['nom'];

        // Récupérer les notes de l'étudiant
        $sql_notes = "SELECT notes.id_note, matieres.libelle_matiere, notes.valeur_note 
                      FROM notes INNER JOIN matieres ON notes.id_matiere = matieres.id_matiere 
                      WHERE notes.id_etudiant = '$student_id'";
        $result_notes = $conn->query($sql_notes);
    } else {
        // L'étudiant spécifié n'existe pas
        echo "Étudiant introuvable.";
        exit();
    }

    $conn->close();
} else {
    // Aucun étudiant spécifié
    echo "Veuillez sélectionner un étudiant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les notes de l'étudiant <?php echo $student_name; ?></title>
</head>
<body>
    <h1>Modifier les notes de l'étudiant <?php echo $student_name; ?></h1>
    <?php if ($result_notes->num_rows > 0) : ?>
        <form method="post" action="">
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
            <table >
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
                            <td><input type="text" name="notes[<?php echo $row["id_note"]; ?>]" value="<?php echo $row["valeur_note"]; ?>" required></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <br>
            <input type="submit" value="Enregistrer les modifications">
        </form>
    <?php else : ?>
        <p>Aucune note enregistrée pour cet étudiant.</p>
    <?php endif; ?>
    <p><a href="admin_dashboard.php">Retour au tableau de bord</a></p>
</body>
</html>
