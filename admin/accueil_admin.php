
<?php
session_start();
if (!isset($_SESSION['ID'])) {
    // Rediriger vers la page de connexion si l'administrateur n'est pas connecté
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord de l'administrateur</title>
</head>
<body>
    <h1>Bienvenue sur le tableau de bord de l'administrateur</h1>
    <ul>
        <li><a href="add_student.php">Inscrire un étudiant</a></li>
        <li><a href="add_formation.php">Ajouter une formation et des matières</a></li>
        <li><a href="add_grades.php">Ajouter des notes d'un étudiant</a></li>
        <li><a href="views_all_student.php">Voir tous les étudiants inscrits</a></li>
        <li><a href="view_students_formation.php">Voir les étudiants par formation</a></li>
        <li><a href="view_grades_student.php">Voir les notes d'un étudiant</a></li>
        <!-- <li><a href="update_student_info.php">Modifier les informations d'un étudiant</a></li> -->
        <li><a href="update_note.php">Modifier les notes d'un étudiant</a></li>
        <li><a href="../logout.php">Déconnexion</a></li>
    </ul>
</body>
</html>
