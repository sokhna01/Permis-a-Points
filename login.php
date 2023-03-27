<?php
include 'includes/header.php';
include 'includes/footer.php';
?>
<?php
//Connect to the MySQL database
$conn = mysqli_connect('localhost', 'root', '', 'Permisapoints');
?>
<button onclick="window.history.back();" class="back-button">Retour</button>

<form method="post" class="form-width">
  <div class="imgcontainer">
    <img src="images/avatar-homme.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <div class="form-group">
      <label for="identifiant"><b>Matricule/N° de permis</b></label>
      <input type="text" class="form-control" id="identifiant" placeholder="Matricule/N° de permis" name="identifiant" required>
    </div>

    <div class="form-group">
      <label for="mdp"><b>Mot de passe</b></label>
      <input type="password" class="form-control" id="mdp" placeholder="Mot de passe" name="mdp" required>
    </div>

    <button type="submit" class="btn btn-primary" name="submit">Login</button>
  </div>
</form>

<?php
if (isset($_POST['submit'])) {
  // Get the values from the form
  $identifiant = mysqli_real_escape_string($conn, $_POST['identifiant']);
  $password = mysqli_real_escape_string($conn, $_POST['mdp']);

  // Check if the user's login credentials are valid
  $query1 = "SELECT * FROM automobilistes WHERE numeroPermis=? AND motdepasse=?";
  $query2 = "SELECT * FROM agentCirculation WHERE matricule=? AND motdepasse=?";
  $query3 = "SELECT * FROM agentGouvernemental WHERE matricule=? AND motdepasse=?";
  $query4 = "SELECT description FROM savoirdujour ORDER BY RAND() LIMIT 1";

  // Prepare the statements
  $stmt1 = mysqli_prepare($conn, $query1);
  $stmt2 = mysqli_prepare($conn, $query2);
  $stmt3 = mysqli_prepare($conn, $query3);
  $stmt4 = mysqli_prepare($conn, $query4);

  // Bind parameters and execute the statements
  mysqli_stmt_bind_param($stmt1, "ss", $identifiant, $password);
  mysqli_stmt_execute($stmt1);
  $result1 = mysqli_stmt_get_result($stmt1);

  mysqli_stmt_bind_param($stmt2, "ss", $identifiant, $password);
  mysqli_stmt_execute($stmt2);
  $result2 = mysqli_stmt_get_result($stmt2);

  mysqli_stmt_bind_param($stmt3, "ss", $identifiant, $password);
  mysqli_stmt_execute($stmt3);
  $result3 = mysqli_stmt_get_result($stmt3);

  mysqli_stmt_execute($stmt4);
  $result4 = mysqli_stmt_get_result($stmt4);


  if (mysqli_num_rows($result1) == 1) {
    // Start a session and set the session variable
    session_start();
    $_SESSION['logged_in'] = true;
    $row1 = mysqli_fetch_assoc($result1);
    $_SESSION['nbPoints'] = $row1['nbPoints'];
    $_SESSION['numeroPermis'] = $row1['numeroPermis'];
    $_SESSION['derniereModification'] = $row1['derniereModification'];
    // Récupération du rôle de l'utilisateur à partir de l'URL
    $role = $_GET['role'];

    // Enregistrement du rôle de l'utilisateur dans la session
    $_SESSION['role'] = $role;
    if ($_SESSION['role'] == 'Automobiliste') {
      header('Location: automobiliste.php');
    } else {
      header('Location:error.php');
    }

    if (mysqli_num_rows($result4) == 1) {
      $row4 = mysqli_fetch_assoc($result4);
      $_SESSION['savoirdujour'] = $row4['description'];
    }
  } else if (mysqli_num_rows($result2) == 1) {
    // Start a session and set the session variable
    session_start();
    $_SESSION['logged_in'] = true;
    $row2 = mysqli_fetch_assoc($result2);
    $_SESSION['matricule'] = $row2['matricule'];
    $_SESSION['nom'] = $row2['nom'];
    $_SESSION['prenom'] = $row2['prenom'];
    // Récupération du rôle de l'utilisateur à partir de l'URL
    $role = $_GET['role'];

    // Enregistrement du rôle de l'utilisateur dans la session
    $_SESSION['role'] = $role;

    if ($_SESSION['role'] == 'Agentcirculation') {


      header('Location: agentCirculation.php');
    } else {
      header('Location:error.php');
    }
  } else if (mysqli_num_rows($result3) == 1) {

    // Start a session and set the session variable

    session_start();
    $_SESSION['logged_in'] = true; // Récupération du rôle de l'utilisateur à partir de l'URL
    $role = $_GET['role'];

    // Enregistrement du rôle de l'utilisateur dans la session
    $_SESSION['role'] = $role;
    if ($_SESSION['role'] == 'Agentgouvernemental') {
      header('Location: agentGouvernemental.php');
    } else {
      header('Location:error.php');
    }
  } else {
    // Display an error message
    echo "<p class='error-message'>Invalid login credentials. Please try again.</p>";
  }


  //Handle errors
  if (!$result1 || !$result2 || !$result3 || !$result4) {
    error_log(mysqli_error($conn));
    // Display a generic error message to the user
    die("An error occurred. Please try again later.");
  }
}
?>
</body>

</html>