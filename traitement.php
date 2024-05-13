<?php

require_once "includes/config.php";
// Vérifier si l'étudiant est connecté
session_start();
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: ../a.php");
    exit();
}

// Vérifier si une matière est sélectionnée
if (isset($_GET['id_matiere'])) {
    $subject_id = $_GET['id_matiere'];

    // Récupérer l'identifiant de l'étudiant connecté
    $student_id = $_SESSION['id_etudiant'];

    // Récupérer les informations de la matière
    // $conn = connectDB();
    $sql_subject_info = "SELECT libelle_matiere FROM matieres WHERE id_matiere = '$subject_id'";
    $result_subject_info = $conn->query($sql_subject_info);

    if ($result_subject_info->num_rows > 0) {
        $subject_info = $result_subject_info->fetch_assoc();
        $subject_name = $subject_info['libelle_matiere'];

        // Récupérer la note de l'étudiant dans cette matière
        $sql_student_grade = "SELECT valeur_note FROM notes WHERE id_etudiant = '$student_id' AND id_matiere = '$subject_id'";
        $result_student_grade = $conn->query($sql_student_grade);

        if ($result_student_grade->num_rows > 0) {
            $student_grade = $result_student_grade->fetch_assoc();
            $grade = $student_grade['valeur_note'];
        } else {
            // Aucune note enregistrée pour cette matière
            $grade = "Aucune note enregistrée pour cette matière.";
        }
    } else {
        // La matière spécifiée n'existe pas
        echo "Matière introuvable.";
        exit();
    }

    $conn->close();
} else {
    // Aucune matière spécifiée
    echo "Veuillez sélectionner une matière.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notes de l'étudiant dans <?php echo $subject_name; ?></title>
</head>
<body>
    <h1>Notes de l'étudiant dans <?php echo $subject_name; ?></h1>
    <p><strong>Note :</strong> <?php echo $grade; ?></p>
    
    <p><a href="student_dashboard.php">Retour au tableau de bord</a></p>
</body>
</html>