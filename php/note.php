<?php

ob_start();

$conn = new mysqli("localhost", "root", "", "GI");

if ($conn->connect_error) {
    die("Connection au serveur echouee!");
}

// Ajout d'heures
$stmt = $conn->prepare("UPDATE etudiant SET Heures_abs = COALESCE(Heures_abs, 0)");
$stmt->execute();


$sql = "SELECT Nom, Prenom, Heures_abs FROM etudiant";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nom = $row['Nom'];
        $prenom = $row['Prenom'];
        $hours = $row['Heures_abs'];
        $absence = 0;

        if (isset($_POST["absence-" . str_replace(" ", "_", $nom) . "-" . str_replace(" ", "_", $prenom)])) {
            $absence = 1;
        }

        if ($absence == 1) {
            $new_absence = $hours + 1;
            $stmt = $conn->prepare("UPDATE etudiant SET Heures_abs = ? WHERE Nom = ? AND Prenom = ?");
            $stmt->bind_param("iss", $new_absence, $nom, $prenom);
            $stmt->execute();
        }
    }
}

// Fermeture de connection
$stmt->close();
$conn->close();
echo "Les heures d'absence ont été mises à jour avec succès.";
echo "<br><br><form action='../'>";
echo "<button type='submit'>Retourner à la page d'accueil</button>";
echo "</form>";
?>
