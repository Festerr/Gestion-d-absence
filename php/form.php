<?php

$conn = new mysqli("localhost", "root");


if ($conn->connect_error) {
    die("Connection au serveur echouee!");
}

//Creation de base de donnee
$db = $conn->query("SHOW DATABASES LIKE 'GI'");

if ($db->num_rows == 0) {
    $conn->query("CREATE DATABASE GI");
}
$conn->query("USE GI");

//Creation de table
$table = $conn->query("SHOW TABLES LIKE 'etudiant'");

if ($table->num_rows == 0) {
    $conn->query("CREATE TABLE etudiant (
        Nom varchar(20) NOT NULL,
        Prenom varchar(20) NOT NULL,
        Heures_abs int(3),
        UNIQUE KEY `idx_unique_nom_prenom` (`Nom`, `Prenom`)
    );");
}

//Insertion de donnees
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$abs = $_POST['absence'];

if (!empty($nom) && !empty($prenom)) {
    $stmt = $conn->prepare("INSERT INTO etudiant (Nom, Prenom, Heures_abs) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nom, $prenom, $abs);
    $stmt->execute();
    echo "Vos données ont été insérées avec succès !";
    $stmt->close();
} else {
    echo "Erreur: Nom ou prenom est vide!";
}

//Fermeture de connection
$conn->close();

?>