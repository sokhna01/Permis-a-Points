<?php
session_start();
include 'includes/header.php';
include 'includes/footer.php';
if ($_SESSION['logged_in'] !== true) {
    header('Location: index.php');
}

$matricule = $_GET['matricule'];


$conn = mysqli_connect('localhost', 'root', '', 'Permisapoints');

// write SQL query
$sql = "SELECT * FROM infractions";

// execute query and loop through results
$result = mysqli_query($conn, $sql);
?>

<div class="sub-nav">
    <ul>
        <li><a href="#">Actualités</a></li>
        <li><a href="#">Agence</a></li>
        <li><a href="#">Historique de traitements</a></li>
        <li><a href="#">Mon Planning</a></li>
        <li><a href="#">Mon compte</a></li>
        <div id="logoutdiv">
            <a id="logoutLink" href="logout.php?logout"><img id="logout" src="images/se-deconnecter.png"></a>
        </div>
    </ul>
</div>
<button onclick="window.history.back();" class="back-button">Retour</button>
<form method="post" class="form-widths">
    <div class="container">
        <label for="numeroP"><b>N° de permis</b></label>
        <input type="text" class="form-control" id="numeroP" placeholder="N° de permis" name="numeroP" required>
        <br> <br> <br> <br>
        <label for="infractions">Choisir l'infraction: </label><br>
        <select id="selectInfractions" name="infraction">
            <option value="" selected>Choisissez une infraction</option>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['titre'] . '">' . $row['titre'] . '</option>';
            }
            // close database connection
            mysqli_close($conn);
            ?>
        </select>
        <br> <br> <br> <br> <br> <br>
        <input type="submit" name="valider" id="signalerInfraction" value="Valider">
    </div>
</form>
<?php
if (isset($_POST['valider'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'Permisapoints');
    // Vérifie si la valeur a été envoyée
    $infractionCommise = addslashes($_POST['infraction']);
    $numeroPermis = addslashes($_POST['numeroP']);

    // Récupérer le nombre de points avant l'infraction
    $sql1 = "SELECT nbPoints from automobilistes where numeroPermis='$numeroPermis'";
    $result1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
        $points_avant = $row['nbPoints'];
        echo "Nombre de points avant l'infraction : " . $points_avant . "<br>";
    }

    $sql2 = "SELECT * FROM infractions WHERE titre = '$infractionCommise'";
    $result2 = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($result2) > 0) {
        $row = mysqli_fetch_assoc($result2);
        if (!empty($row['points'])) {
            $nbPoints = $row['points'];
            $stmt = mysqli_prepare($conn, "UPDATE automobilistes SET nbPoints = nbPoints - ? WHERE numeroPermis = ?");
            mysqli_stmt_bind_param($stmt, 'is', $nbPoints, $numeroPermis);
            mysqli_stmt_execute($stmt);
            if (mysqli_affected_rows($conn) > 0) {
                $stmt = mysqli_prepare($conn, "SELECT numeroPermis, nom, prenom, nbPoints FROM automobilistes WHERE numeroPermis = ?");
                mysqli_stmt_bind_param($stmt, "s", $numeroPermis);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $numeroPermis, $nom, $prenom, $points_apres);
                mysqli_stmt_fetch($stmt);

                // escape variables properly with addslashes()
                $nom = addslashes($nom);
                $prenom = addslashes($prenom);
                echo "<script>
                    showPopupInfraction('$nom', '$prenom', '$infractionCommise',$nbPoints, $points_apres);
                </script>";

                // Insérer l'infraction dans la table de l'historique
                // $sql3 = "INSERT INTO historique (numero_permis, infraction, dateInfraction,  points_avant, points_apres, matricule_agent) VALUES ('$numeroPermis', NOW(), '$infractionCommise', '$points_avant', '$points_apres')";
                // if (!mysqli_query($conn, $sql3)) {
                //     echo "Error: " . mysqli_error($conn);
                // }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Erreur : la valeur de points de l'infraction est vide.";
        }
    } else {
        echo "Erreur : aucune ligne renvoyée pour l'infraction sélectionnée.";
    }
}
?>