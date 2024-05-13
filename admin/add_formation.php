<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure le fichier de configuration de la base de données
    require_once "../includes/config.php";

//     // Définir les variables avec les données du formulaire
//     $id_formation = $_POST["id_formation"];
//     $libelle_formation = $_POST["libelle_formation"];
 

//     // Préparer la requête SQL pour insérer un nouvel étudiant
//     $sql = "INSERT INTO formations (id_formation, libelle_formation) VALUES (?, ?)";

//     // Préparer la déclaration
//     $stmt = $conn->prepare($sql);


//     // Liaison des paramètres
//     $stmt->bind_param("is", $id_formation, $libelle_formation);


//     // Exécution de la requête
//     if ($stmt->execute()) {
//         // Redirection vers une page de confirmation
//         header("Location: confirmation.php");
//         exit();
//     } else {
//         // Gérer les erreurs
//         echo "Erreur: " . $conn->error;
//     }

//     // Fermer la déclaration
//     $stmt->close();
// }

// Fermer la connexion à la base de données
// $conn->close();
// Récupérer les données du formulaire
$libelle_formation = $_POST['libelle_formation'];
$matieres = $_POST['matieres']; // Cette variable devrait être un tableau contenant les matières associées à la formation

// Préparer et exécuter la requête SQL pour ajouter la formation
$sql_formation = "INSERT INTO formations (libelle_formation) VALUES ('$libelle_formation')";
if ($conn->query($sql_formation) === TRUE) {
    $formation_id = $conn->insert_id; // Récupérer l'ID de la formation ajoutée

    // Ajouter les matières associées à la formation
    // foreach ($matieres as $matiere) {
    //     $sql_matiere = "INSERT INTO matieres (libelle_matiere, id_formation) VALUES ('$matiere', '$formation_id')";
    //     $matiere_string = implode(', ', $matiere);
    //     if ($conn->query($sql_matiere) !== TRUE) {
    //         echo "Erreur lors de l'ajout de la matière: " . $conn->error;
    //         // Possibilité de gérer les erreurs ici (par exemple, arrêter la boucle)
    //     }
    // }
    foreach ($matieres as $matiere) {
        $codeMatiere = $matiere[0]; // Extraire le code de la matière
        $libelleMatiere = $matiere[1]; // Extraire le libellé de la matière
        // Insérer le code de la matière dans la base de données
        $sql_matiere = "INSERT INTO matieres (code_matiere, libelle_matiere, id_formation) VALUES ('$codeMatiere', '$libelleMatiere', '$formation_id')";
        if ($conn->query($sql_matiere) !== TRUE) {
            echo "Erreur lors de l'ajout de la matière: " . $conn->error;
            // Possibilité de gérer les erreurs ici (par exemple, arrêter la boucle)
        }
    }
    
    
    echo "La formation et les matières associées ont été ajoutées avec succès.";
} else {
    echo "Erreur lors de l'ajout de la formation: " . $conn->error;
}
// Fermer la connexion à la base de données
$conn->close();
}

?>




<!-- Formulaire pour ajouter une formation -->
<!-- <form action="add_formation.php" method="post">
    <label for="id_formation">Identifiant de la formation :</label>
    <input type="text" id="id_formation" name="id_formation" required>

    <label for="libelle_formation">Libellé de la formation :</label>
    <input type="text" id="libelle_formation" name="libelle_formation" required>

    <input type="submit" value="Ajouter Formation">
</form> -->


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une nouvelle formation</title>
</head>
<body>
    <h1>Créer une nouvelle formation</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="libelle_formation">Libellé de la formation :</label>
        <input type="text" id="libelle_formation" name="libelle_formation" required><br><br>

        <label for="matieres">Matières associées :</label><br>
        <div id="matieres">
            <input type="text" name="matieres[0][]" placeholder="Code de la matière" required>
            <input type="text" name="matieres[0][]" placeholder="Libellé de la matière" required>
            <button type="button" onclick="addMatiere()">Ajouter une matière</button>
        </div><br>

        <input type="submit" value="Créer la formation">
    </form>

    <script>
        let matiereCount = 1;

        function addMatiere() {
            matiereCount++;
            let matiereDiv = document.createElement('div');
            matiereDiv.innerHTML = '<input type="text" name="matieres[' + matiereCount + '][]" placeholder="Code de la matière" required> ' +
                                    '<input type="text" name="matieres[' + matiereCount + '][]" placeholder="Libellé de la matière" required>';
            document.getElementById('matieres').appendChild(matiereDiv);
        }
    </script>
</body>
</html>
