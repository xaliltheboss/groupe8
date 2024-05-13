<?php
require_once "../includes/config.php";

// Récupérer la liste des étudiants depuis la base de données
$sql = "SELECT * FROM etudiants";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants inscrits</title>
</head>
<body>
    <h1>Liste des étudiants inscrits</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Formation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Vérifier si la requête a retourné des résultats
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["matricule"] . "</td>";
                    echo "<td>" . $row["nom"] . "</td>";
                    echo "<td>" . $row["prenom"] . "</td>";
                    echo "<td>" . $row["adresse"] . "</td>";
                    echo "<td>" . $row["telephone"] . "</td>";
                    

                    // Récupérer le libellé de la formation à partir de son ID
                    $formation_id = $row["id_formation"];
                    $sql_formation = "SELECT libelle_formation FROM formations WHERE id_formation = '$formation_id'";
                    $result_formation = $conn->query($sql_formation);
                    if ($result_formation && $result_formation->num_rows > 0) {
                        $formation = $result_formation->fetch_assoc();
                        echo "<td>" . $formation["libelle_formation"] . "</td>";
                    } else {
                        echo "<td>Formation inconnue</td>";
                    }
                    echo "<td><a href='update_student_info.php?id_etudiant=" . $row['id_etudiant'] . "'>Modifier</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Aucun étudiant inscrit.</td></tr>";
            }
            // Fermer le résultat de la requête et la connexion à la base de données
            if ($result) {
                $result->close();
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
