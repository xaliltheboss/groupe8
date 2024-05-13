
<?php
session_start();
if (!isset($_SESSION['id_etudiant'])) {
    // Rediriger vers la page de connexion si l'étudiant n'est pas connecté
    header("Location: ../index.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 0 20px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
            margin-bottom: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur notre site</h1>
        <p>Notre site permet aux étudiants de consulter leurs notes d'examen en ligne.</p>
     
        <ul>
        <li><a href="view_student_info.php">Voir mes informations administratives</a></li>
        <li><a href="view_grade_subject.php">Voir mes notes dans une matière</a></li>
        <li><a href="view_all_grade.php">Voir toutes mes notes</a></li>
        <li><a href="change_password.php">Modifier mon mot de passe</a></li>
        
        <li><a href="../logout.php">Déconnexion</a></li>
    </ul>
    </div>
</body>
</html>

