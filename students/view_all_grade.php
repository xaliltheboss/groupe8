<?php
require_once "../includes/config.php";

// Vérifier si l'étudiant est connecté
session_start();
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: ../index.php");;
    exit();
}

// Récupérer l'identifiant de l'étudiant connecté
$student_id = $_SESSION['id_etudiant'];

// Récupérer les notes de l'étudiant dans toutes les matières
// $conn = connectDB();
$sql_all_grades = "SELECT matieres.libelle_matiere, notes.valeur_note 
                   FROM notes INNER JOIN matieres ON notes.id_matiere = matieres.id_matiere 
                   WHERE notes.id_etudiant = '$student_id'";
$result_all_grades = $conn->query($sql_all_grades);

if ($result_all_grades->num_rows > 0) {
    // Notes trouvées, afficher les résultats
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Toutes les notes de l'étudiant</title>
    </head>
    <body>
        <h1>Toutes les notes de l'étudiant</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_all_grades->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['libelle_matiere']; ?></td>
                        <td><?php echo $row['valeur_note']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <p><a href="accueil.student.php">Retour au tableau de bord</a></p>
    </body>
    </html>
    <?php
} else {
    // Aucune note enregistrée pour l'étudiant
    echo "Aucune note enregistrée pour l'étudiant.";
}

$conn->close();
?>
