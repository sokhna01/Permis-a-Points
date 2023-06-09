<?php
include 'includes/header.php';
include 'includes/footer.php';
session_start();
if ($_SESSION['logged_in'] !== true) {
    header('Location: index.php');
}

$matricule = $_SESSION['matricule'];
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];

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

<div class="txtNactionContainer">
    <div class="txtContainer">
        <h2>Bienvenue Cher Agent, Vous désirez?</h2>
    </div>

    <div class="actionContainer">
        <div class="actionAEffectuer">
            <p class="descAction">Annuler le retrait de points sur un permis</p>
            <a href="#" class="arrowLink"><img src="images/next.png" alt="arrow"></a>
        </div>

        <div class="actionAEffectuer">
            <p class="descAction">Valider le retrait de points sur un permis</p>
            <a href="#" class="arrowLink"><img src="images/next.png" alt="arrow"></a>
        </div>
    </div>

</div>