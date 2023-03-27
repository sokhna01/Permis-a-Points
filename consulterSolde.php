<?php
session_start();
include 'includes/header.php';
include 'includes/footer.php';
if ($_SESSION['logged_in'] !== true) {
    header('Location: index.php');
}
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
<p>Veuillez renseigner le numéro de permis dont vous désirez Consulter le solde</p>

 <form method="post" class="form-widths" onsubmit="showPopupSolde(event)">
    <div class="container">
        <label for="numeroP"><b>N° de permis</b></label>
        <input type="text" class="form-control" id="numeroP" placeholder="N° de permis" name="numeroP" required>
        <input type="submit" name="valider" id="consulterSolde" value="Consulter">
    </div>
</form>
