<?php
require_once "../includes/config.php";


// Vérifier si l'administrateur est connecté
session_start();
if (!isset($_SESSION['ID'])) {
    header("Location: ../index.php");
    exit();
}

// Vérifier si le formulaire d'ajout d'administrateur a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'adresse e-mail est déjà utilisée
    $conn = connectDB();
    $sql_check_email = "SELECT * FROM administrateurs WHERE email = '$email'";
    $result_check_email = $conn->query($sql_check_email);

    if ($result_check_email->num_rows > 0) {
        $error_message = "L'adresse e-mail est déjà associée à un administrateur.";
    } else {
        // Hacher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insérer le nouvel administrateur dans la base de données
        $sql_insert_admin = "INSERT INTO administrateurs (email, mot_de_passe) VALUES ('$email', '$hashed_password')";
        if ($conn->query($sql_insert_admin) === TRUE) {
            $success_message = "Nouvel administrateur ajouté avec succès.";
        } else {
            $error_message = "Erreur lors de l'ajout de l'administrateur : " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un nouvel administrateur</title>
</head>
<body>
    <h1>Ajouter un nouvel administrateur</h1>
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <?php if (isset($success_message)) : ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Ajouter l'administrateur">
    </form>
    <p><a href="admin_dashboard.php">Retour au tableau de bord</a></p>
</body>
</html>
