<?php 
  function getDatabaseConnexion () {
    try {
        $user = "root";
        $pass = "";
        $pdo = new PDO('mysql: host=localhost;dbname=gestion_utilisateurs',$user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    }catch (PDOException $e){
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }

  }

  function getAllUSers () {
    $con = getDatabaseConnexion();
    $requete = 'SELECT * FROM utilisateurs';
    $rows = $con->query($requete);
    return $rows;
  }

  
  function readUSer ($id) {
    $con = getDatabaseConnexion();
    $requete = "SELECT * FROM utilisateurs where id = '$id'";
    $stmt = $con->query($requete);
    $row = $stmt->fetchAll();
    if(!empty($row)) {
        return $row[0];
    }
    
    
  }

  function createUser ( $nom, $prenom, $email, $password) {
    try{
      $con = getDatabaseConnexion();
      $sql = "INSERT INTO utilisateurs(nom, prenom, email, password)
      VALUES ('$nom', '$prenom', '$email', '$password')";
      $con->exec($sql);
      
    }
    catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
    
  }
  function updateUser ($id, $nom, $prenom, $email, $password) {
    try {
      $con = getDatabaseConnexion();
      $requete = "UPDATE utilisateurs set
                  nom = '$nom',
                  prenom = '$prenom',
                  email = '$email',
                  password = '$password' 
                  where id = '$id' ";
    $stmt = $con->query($requete);
    }
    catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
    
  }
  function deleteUser ($id) {
    try {
      $con = getDatabaseConnexion();
      $requete = "DELETE FROM utilisateurs where id = '$id' ";
      
      $stmt = $con->query($requete);
    }
    catch(PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
    }
  }
    function getNewUser() {
      $user['id'] = "";
      $user['nom'] = "";
      $user['prenom'] = "";
      $user['email'] = "";
      $user['password'] = "";
      
    }
  
?>