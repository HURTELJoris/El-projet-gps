<?php
  session_start();
  include("session.php");

  // Si l'utilisateur est connecté
  if (isset($_SESSION["IsConnecting"]) && $_SESSION["IsConnecting"] == true)
  {
	header("Location: accueil.php");
  }
?>

<!doctype html>
<html lang="fr">
  	<head>
		<title>Inscription</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/login.css">
		<link rel="shortcut icon" href="images/favicon.png">
	</head>

	<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">

    <!-- header section strats -->
    <header class="header_section">
		<div class="container-fluid">
		  <nav class="navbar navbar-expand-lg custom_nav-container ">
			<a class="navbar-brand" href="index.php">
			  <span>
				PROJET GPS
			  </span>
			</a>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			  <ul class="navbar-nav ml-auto lead">
				<li class="nav-item active">
				  <a class="nav-link" href="index.php">Accueil</a>
				</li>
			  </ul>
			</div>
		  </nav>
		</div>
	</header>

	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class='heading-section'>Inscription</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Non inscrit ?</h3>
		      	<form action="inscription.php" method="post">
				  <div class="form-group">
		      			<input type="text" name="inputNom" class="form-control" placeholder="Nom" maxlength="29" required>
		      		</div>
		      		<div class="form-group">
		      			<input type="text" name="inputEmail" class="form-control" placeholder="Exemple@gmail.com" maxlength="199" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Entrez une adresse e-mail valide" autocomplete="email" required>
		      		</div>
					<div class="form-group">
						<input id="password-field" name="inputPassword" type="password" class="form-control" placeholder="Mot de passe" maxlength="29" required>
						<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					</div>
					<div class="form-group">
						<?php
						    if ($isSignUp == 2)
							{
								echo "<p style='color:red; margin-left: 20px;'>Le compte existe déjà !!!</p>"; // On affiche le compte existe déjà
							}
						?>
						<button type="submit" name="btnSubmit" class="form-control btn btn-primary px-3">S'inscrire</button>
					</div>
	          </form>
	          <p class="w-100 text-center">&mdash; Si vous n'avez pas de compte vous ne pourez pas accéder à la station Lawrence &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="index.php" class="px-2 py-2 ml-md-1 rounded">Connexion</a>
	          </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
  	<script src="js/main.js"></script>
	</body>
</html>