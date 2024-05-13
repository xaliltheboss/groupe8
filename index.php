
<?php
// session_start(); // Démarrage de la session
// require_once "includes/config.php";
// // Connexion à la base de données


// // Vérification de la soumission du formulaire
// if(isset($_POST['connexion'])) {
//     $login = htmlspecialchars($_POST['login']);
//     $motdepasse = sha1($_POST['password']);

//     if(!empty($login) && !empty($motdepasse)) {
//         // Requête pour vérifier si l'utilisateur est un étudiant
//         $reqEtudiant = $conn->prepare("SELECT * FROM etudiants WHERE matricule = ? AND motdepasse = ?");
//         $reqEtudiant->execute(array($login, $motdepasse));
//         $etudiantExist = $reqEtudiant->rowCount();
        
//         // Requête pour vérifier si l'utilisateur est un administrateur
//         $reqAdmin = $conn->prepare("SELECT * FROM administrateur WHERE Email = ? AND mot_de_passe = ?");
//         $reqAdmin->execute(array($login, $motdepasse));
//         $adminExist = $reqAdmin->rowCount();

//         if($etudiantExist == 1) {
//             $etudiantInfo = $reqEtudiant->fetch();
//             $_SESSION['id_etudiant'] = $etudiantInfo['id'];
//             $_SESSION['matricule'] = $etudiantInfo['matricule'];
//             header("Location: accueil.student.php?id=".$_SESSION['id_etudiant']);
//         } else if($adminExist == 1) {
//             $adminInfo = $reqAdmin->fetch();
//             $_SESSION['id_admin'] = $adminInfo['id'];
//             $_SESSION['email'] = $adminInfo['email'];
//             header("Location: accueil_admin.php?id=".$_SESSION['id_admin']);
//         } else {
//             $erreur = "Identifiants incorrects ou utilisateur non trouvé.";
//         }
//     } else {
//         $erreur = "Tous les champs doivent être complétés !";
//     }
// }
?>
<?php
session_start(); // Démarrage de la session


// Connexion à la base de données
require_once "includes/config.php";

// Vérification de la soumission du formulaire
if(isset($_POST['connexion'])) {
    $login = htmlspecialchars($_POST['login']);
    // $motdepasse = sha1($_POST['password']);
    $motdepasse = $_POST['password'];

    if(!empty($login) && !empty($motdepasse)) {
        // Préparation de la requête pour vérifier si l'utilisateur est un étudiant
        $reqEtudiant = $conn->prepare("SELECT * FROM etudiants WHERE matricule = ? AND motdepasse = ?" );
        $reqEtudiant->bind_param("ss", $login, $motdepasse);
        $reqEtudiant->execute();
        $resultEtudiant = $reqEtudiant->get_result();

        // Préparation de la requête pour vérifier si l'utilisateur est un administrateur
        $reqAdmin = $conn->prepare("SELECT * FROM administrateur WHERE email = ? AND mot_de_passe = ?");
        $reqAdmin->bind_param("ss", $login, $motdepasse);
        $reqAdmin->execute();
        $resultAdmin = $reqAdmin->get_result();

        if($resultEtudiant->num_rows == 1) {
            $etudiantInfo = $resultEtudiant->fetch_assoc();
            $_SESSION['id_etudiant'] = $etudiantInfo['id_etudiant'];
            $_SESSION['matricule'] = $etudiantInfo['matricule'];
            var_dump($_SESSION);
            header("Location: students/accueil.student.php?id_etudiant=".$_SESSION['id_etudiant']);
        } else if($resultAdmin->num_rows == 1) {
            $adminInfo = $resultAdmin->fetch_assoc();
            $_SESSION['ID'] = $adminInfo['ID'];
            $_SESSION['email'] = $adminInfo['email'];
            var_dump($_SESSION); 
            header("Location: admin/accueil_admin.php?id=".$_SESSION['ID']);
        } else {
            $erreur = "Identifiants incorrects ou utilisateur non trouvé.";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion au système de notes</title>
    <!-- Assurez-vous d'inclure votre propre CSS pour le style -->
</head>
<body>
    <div class="container">
        
        <h2>Connexion</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="login">Matricule ou Email :</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" name="connexion" value="Se connecter">
            </div>
            <?php if(isset($erreur)): ?>
                <p class="error"><?php echo $erreur; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
