<?php
	 include 'functions.php';
     include 'functionTable.php';
	$action = $_GET["action"];

	if ($action == "DELETE") {
		$id = $_GET["id"];
	} else {
		$id = $_GET["id"];
		$nom = $_GET["nom"];
		$prenom = $_GET["prenom"];
		$email = $_GET["email"];
		$password = $_GET["password"];
		
	}
	

	if ($action == "CREATE") {
		createUser($nom, $prenom, $email, $password);

		echo "user cree <br>";
		echo "<a href='index.php'>Liste des utilisateurs</a>";
		
	}
	
	if ($action == "UPDATE") {
		updateUser($id, $nom, $prenom, $email, $password);
		echo "user update <br>";
		echo "<a href='index.php'>Liste des utilisateurs</a>";
	}
	if ($action == "DELETE") {
		deleteUser($id);
		echo "user delete <br>";
		echo "<a href='index.php'>Liste des utilisateurs</a>";
	}
	

	
?>