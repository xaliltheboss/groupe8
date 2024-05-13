<?php
session_start();
require_once "../includes/config.php";

// Vérifier si l'étudiant est connecté
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: ..index/.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $student_id = $_SESSION['id_etudiant'];

    // Vérifier si les champs ne sont pas vides
    if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
        // Vérifier si le nouveau mot de passe correspond à la confirmation
        if ($new_password === $confirm_password) {
            // Vérifier si l'ancien mot de passe correspond au mot de passe actuel de l'étudiant
            $sql_check_password = "SELECT motdepasse FROM etudiants WHERE id_etudiant = ?";
            $stmt_check_password = $conn->prepare($sql_check_password);
            $stmt_check_password->bind_param("i", $student_id);
            $stmt_check_password->execute();
            $result_check_password = $stmt_check_password->get_result();

            if ($result_check_password->num_rows == 1) {
                $row = $result_check_password->fetch_assoc();
                // $hashed_password = $row['mot_de_passe'];

                if (password_verify($old_password)) {
                    // Mettre à jour le mot de passe dans la base de données
                    // $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql_update_password = "UPDATE etudiants SET motdepasse = ? WHERE id_etudiant = ?";
                    $stmt_update_password = $conn->prepare($sql_update_password);
                    $stmt_update_password->bind_param("si", $student_id);

                    if ($stmt_update_password->execute()) {
                        $success_message = "Mot de passe mis à jour avec succès.";
                    } else {
                        $error_message = "Erreur lors de la mise à jour du mot de passe.";
                    }
                } else {
                    $error_message = "Ancien mot de passe incorrect.";
                }
            } else {
                $error_message = "Impossible de vérifier le mot de passe actuel.";
            }
        } else {
            $error_message = "Le nouveau mot de passe et la confirmation ne correspondent pas.";
        }
    } else {
        $error_message = "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification du mot de passe</title>
</head>
<body>
    <h2>Modification du mot de passe</h2>
    <?php if(isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <?php if(isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <label for="old_password">Ancien mot de passe :</label><br>
        <input type="password" id="old_password" name="old_password" required><br><br>
        <label for="new_password">Nouveau mot de passe :</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>
        <label for="confirm_password">Confirmer le nouveau mot de passe :</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <input type="submit" value="Modifier le mot de passe">
    </form>
</body>
</html>
