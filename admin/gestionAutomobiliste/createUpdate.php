<?php
	include 'mesFunctionsSQL.php';
	include 'mesFunctionsTable.php';
	$action = $_GET["action"];

	if ($action == "DELETE") {
		$id = $_GET["id"];
	} else {
		$id = $_GET["id"];
		$nom = $_GET["nom"];
		$prenom = $_GET["prenom"];
		$age = $_GET["age"];
		$NPermi = $_GET["NPermi"];
		
	}
	

	if ($action == "CREATE") {
		createUser($nom, $prenom, $age, $NPermi);

		echo "ajout reussi! <br>";
		echo "<a href='index.php'>Liste des utilisateurs</a>";
		
	}
	
	if ($action == "UPDATE") {
		updateUser($id, $nom, $prenom, $age, $NPermi);
		echo "mis a jour reussi! <br>";
		echo "<a href='index.php'>Liste des utilisateurs</a>";
	}
	if ($action == "DELETE") {
		deleteUser($id);
		echo "user delete <br>";
		echo "<a href='index.php'>Liste des utilisateurs</a>";
	}
	

	
?>