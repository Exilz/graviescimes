<?php  


$auth = 0;
include('lib/includes.php');
	
if(isset($_POST['username']) && isset($_POST['password'])){
	$username = $db->quote($_POST['username']);
	$password = sha1($_POST['password']);
	$select = $db->query("SELECT * FROM users WHERE username=$username AND password='$password'");

	if($select->rowCount() > 0){ // On compte le nombre de résultats, si il y en a un on peut enregistrer les infos
		setFlash('Vous êtes maintenant connecté');
		$_SESSION['Auth'] = $select->fetch();
		header('Location:' . WEBROOT . 'admin/index.php');
		die();
	}
	else{
		setFlash('Erreur de login et/ou mot de passe', 'warning');
	}

}

include('partials/public/header.php'); ?>
<br/><br/>
<?php 

echo flash(); ?>

<div class="row">

<h3>Connexion à l'interface d'administration</h3><br/>

	<div class="large-3 columns">
<form action="#" method="post">
	<div class="row half">
		<label for="username">Nom d'utilisateur</label>
		<?php echo login_input('username'); ?>
	</div>
	<div class="row half">
		<label for="password">Mot de passe</label>
		<input type="password" class="form-group" id="password" name="password">
	</div>
	<button type="submit" class="button submit">Envoyer</button>
</form>
</div>	
</div>

<?php
include('partials/public/footer.php'); ?>