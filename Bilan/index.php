<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilan d'absence</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<style>
    .green {color: green;} .orange {color: orange;} .red {color: red;}
</style>
<body>
    <div class="nav">
        <a href="../">Home</a>
        <a href="../Inscription/">Inscription</a>
        <a href="../Note d'absence/">Note d'absence</a>
        <a class="active" href="#">Bilan d'absence</a>
    </div>
    <h1>Bilan d'absence</h1>
    <br><br>
    </table>
        <?php

        $conn = new mysqli("localhost", "root");


        if ($conn->connect_error) {
            die("Connection au serveur echouee!");
        }

        $conn->query("USE GI");
        
        //Affichage
        $stmt = $conn->prepare("UPDATE etudiant SET Heures_abs = COALESCE(Heures_abs, 0)");
        $stmt->execute();
        $sql = "SELECT Nom, Prenom, Heures_abs FROM etudiant";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            echo "<table>\n
                <tr>\n
                    <td>Nom</td>\n
                    <td>Prenom</td>\n
                    <td>Total d'absence (h)</td>\n
                </tr>\n";
            while($row = $result->fetch_assoc()){
                echo "<tr>
                        <td>" . $row['Nom'] ."</td>\n
                        <td>" . $row['Prenom'] . "</td>\n
                        <td>" . $row['Heures_abs'] . "</td>\n
                    </tr>\n";
            }
            echo "</table>\n";
        }
        else{
            echo "0 results";
        }

        //Fermeture de connection
        $stmt->close();
        $conn->close();

        ?>
    </table>
    <script>
        window.addEventListener("load", function() {
            let rows = document.getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                let cell = rows[i].getElementsByTagName("td")[2];
                let value = parseInt(cell.innerText);
                if (value >= 20) {
                    cell.classList.add("red");
                } else if (value > 0) {
                    cell.classList.add("orange");
                } else {
                    cell.classList.add("green");
                }
            }
        });
    </script>
</body>
</html>