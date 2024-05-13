<?php
session_start();

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure le fichier de configuration de la base de données
    require_once "includes/config.php";

    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Préparer la requête SQL pour vérifier l'authenticité des informations de connexion
    $sql = "SELECT * FROM utilisateurs WHERE login = ? AND mot_de_passe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'utilisateur existe dans la base de données
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['login'] = $login;
        $_SESSION['role'] = $row['role']; // Stocker le rôle de l'utilisateur dans la session
        if ($row['role'] == 'administrateur') {
            header("Location: admin/accueil_admin.php"); // Redirection vers le tableau de bord de l'administrateur
            exit();
        } elseif ($row['role'] == 'etudiant') {
            header("Location: students/accueil.student.php"); // Redirection vers le tableau de bord de l'étudiant
            exit();
        }
    } else {
        // Identifiants invalides
        $error = "Login ou mot de passe incorrect.";
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclure votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
