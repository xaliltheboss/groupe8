

<?php
session_start();
if (!isset($_SESSION['student'])) {
    // Rediriger vers la page de connexion si l'étudiant n'est pas connecté
    header("Location: ../index.php");
    exit();
}

// Vérifier si le formulaire de modification de mot de passe a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $new_password = $_POST['new_password'];

    // Mettre à jour le mot de passe de l'étudiant dans la base de données (à remplacer par votre logique de mise à jour)
    // Ici, nous supposons que l'ID de l'étudiant est stocké dans $_SESSION['student_id']
    $student_id = $_SESSION['student_id'];
    // Code de mise à jour du mot de passe...
    echo "Votre mot de passe a été mis à jour avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le mot de passe</title>
</head>
<body>
    <h1>Modifier le mot de passe</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" id="new_password" name="new_password" required><br><br>
        <input type="submit" value="Modifier le mot de passe">
    </form>
    <a href="student_dashboard.php">Retour au tableau de bord</a>
</body>
</html>
