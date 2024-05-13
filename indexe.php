<?php
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // $conn = connectDB();
    $sql = "SELECT * FROM utilisateurs WHERE login = '$login'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['mot_de_passe'];
        $user_type = $row['type'];

        if (password_verify($password, $hashed_password)) {
            // Connexion réussie, rediriger l'utilisateur vers son espace approprié
            session_start();
            $_SESSION['user_id'] = $row['id'];
            if ($user_type == 'etudiant') {
                // Redirection vers l'espace étudiant
                header("Location: accueil_student.php");
            } elseif ($user_type == 'administrateur') {
                // Redirection vers l'espace administrateur
                header("Location: accueil_admin.php");
            }
            exit();
        } else {
            $error_message = "Mot de passe incorrect.";
        }
    } else {
        $error_message = "Identifiant incorrect.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="login">Matricule ou email :</label>
        <input type="text" id="login" name="login" required><br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>





<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des notes d'examen</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- <div class="container">
    <h1>Consultation des notes d'examen</h1>
    <form id="consultationForm">
        <label for="matricule">Numéro de matricule:</label>
        <input type="text" id="matricule" name="matricule" required>
        <label for="matiere">Matière:</label>
        <input type="text" id="matiere" name="matiere" required>
        <button type="submit">Consulter</button>
    </form>
    <div id="result"></div>
</div> -->



<!-- Formulaire de connexion -->
<!-- <section id="connexion">
    <form action="connexion.php" method="post">
        <label for="login">Login :</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Connexion">
    </form>
</section> -->

<!-- Formulaire d'inscription d'un étudiant -->
<!-- <section id="inscription">
    <form action="inscription.php" method="post">
        <label for="matricule">Matricule :</label>
        <input type="text" id="matricule" name="matricule" required>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required>

        <input type="submit" value="Inscrire">
    </form>
</section> -->

<script src="script.js"></script>
</body>
</html>
