<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Note d'absence</title>
</head>
<body>
    <div class="nav">
        <a href="../">Home</a>
        <a href="../Inscription/">Inscription</a>
        <a class="active" href="#">Note d'absence</a>
        <a href="../Bilan">Bilan d'absence</a>
    </div>  
    <h1>Note d'absence</h1>
    <br><br>
    <form action="../php/note.php" method="post">
        <?php

        $conn = new mysqli("localhost", "root");


        if ($conn->connect_error) {
            die("Connection au serveur echouee!");
        }

        $conn->query("USE GI");


        //Affichage
        $sql = "SELECT Nom, Prenom, Heures_abs FROM etudiant";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            echo "<table>\n
                <tr>\n
                    <td>Nom</td>\n
                    <td>Prenom</td>\n
                    <td>Absent(e)</td>\n
                </tr>\n";
            while($row = $result->fetch_assoc()){
                $nom = $row['Nom'];
                $prenom = $row['Prenom'];
                echo "<tr>
                        <td>" . $row['Nom'] ."</td>\n
                        <td>" . $row['Prenom'] . "</td>\n
                        <td><input type=\"checkbox\" name=\"absence-$nom-$prenom\" value=\"checked\"></td>\n
                    </tr>\n";
            }
            echo "</table>\n
                <br><input type=\"submit\">\n";
        }
        else{
            echo "0 results";
        }

        //Fermeture de connection
        $conn->close();

        ?>
    </table>
    </form>
</body>
</html>