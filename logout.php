<?php
session_start();

if (isset($_GET['logout'])) {
  
session_destroy(); // détruit toutes les données de la session
header("Location: index.php"); // redirection vers la page de connexion
exit; // arrête l'exécution du script

}
