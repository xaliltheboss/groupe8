<?php
 require_once "../includes/config.php";

// Vérifier si un étudiant et une matière sont sélectionnés
if (isset($_GET['id_etudiant']) && isset($_GET['id_etudiant'])) {
    $student_id = $_GET['id_etudiant'];
    $subject_id = $_GET['id_etudiant'];

    // Récupérer les informations de l'étudiant
 
    $sql_student = "SELECT * FROM etudiants WHERE id_etudiant = '$student_id'";
    $result_student = $conn->query($sql_student);

    if ($result_student->num_rows > 0) {
        $student = $result_student->fetch_assoc();
        $student_name = $student['prenom'] . ' ' . $student['nom'];

        // Récupérer les informations de la matière
        $sql_subject = "SELECT libelle_matiere FROM matieres WHERE id_matiere = '$subject_id'";
        $result_subject = $conn->query($sql_subject);

        if ($result_subject->num_rows > 0) {
            $subject = $result_subject->fetch_assoc();
            $subject_name = $subject['libelle_matiere'];

            // Récupérer la note de l'étudiant dans cette matière
            $sql_note = "SELECT valeur_note FROM notes WHERE id_etudiant = '$student_id' AND id_matiere = '$subject_id'";
            $result_note = $conn->query($sql_note);

            if ($result_note->num_rows > 0) {
                $note = $result_note->fetch_assoc();
                $student_note = $note['valeur_note'];
            } else {
                $student_note = "Aucune note enregistrée pour cette matière.";
            }
        } else {
            // La matière spécifiée n'existe pas
            echo "Matière introuvable.";
            exit();
        }
    } else {
        // L'étudiant spécifié n'existe pas
        echo "Étudiant introuvable.";
        exit();
    }

    $conn->close();
} else {
    // Aucun étudiant ou matière spécifiés
    echo "Veuillez sélectionner un étudiant et une matière.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notes de l'étudiant <?php echo $student_name; ?> dans <?php echo $subject_name; ?></title>
</head>
<body>
    <h1>Notes de l'étudiant <?php echo $student_name; ?> dans <?php echo $subject_name; ?></h1>
    <p>Note : <?php echo $student_note; ?></p>
    <p><a href="   <p><a href="accueil.student.php">Retour au tableau de bord</a></p>.php">Retour au tableau de bord</a></p>
</body>
</html>
