<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gestion des utilisateurs</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>
</head>
<body>
  
  <?php 
  include 'functions.php';
  include 'functionTable.php';
  $headers = getHeaderTable();
  $users = getAllUsers();
  afficherTableau($users, $headers);
?>
  <a href=formulaireUtilisateur.php?id=0 >Creer un utilisateur</a> 
  

  
  
</body>
</html>