<h1 class="center">Administration des membres</h1>

<?php
$query = $db->query("SELECT id, username FROM users");
$result = $query->fetchAll();

if(isset($_POST['submit']) && $_POST['password'] != $_POST['passwordconf']){
	setFlash('Les mots de passe ne correspondent pas', 'warning');
	header('Location:members.php');
	die();
}

if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']) && $_POST['password'] == $_POST['passwordconf']){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$db->query("INSERT INTO users VALUES (NULL, '$username', SHA1('$password'));");
	setFlash("L'utilsateur $username a été ajouté.");
	header('Location:members.php');
	die();
}


if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	$select = $db->query("DELETE FROM users WHERE id=$id;");
	setFlash("L'utilisateur $id a été supprimé");
	header('Location:members.php');
	die();
}


?>

<div class="row">

	<div class="large-6 columns center">
		<table>
		  <thead>
		    <tr>
		      <th width="50">Ref.</th>
		      <th width="150">Utilisateur</th>
		      <th width="75">Supprimer</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php
		  	foreach($result as $row){
		  		echo "    	<tr>
						      <td>" . $row['id'] . "</td>
						      <td>" .$row['username'] . "</td>
						      <td><a href='?delete=".$row['id']."'><img src='../img/admin/memberdelete.png' class='memberdelte' alt='memberdelete' onclick='return alert('lol')'/></a></td>
						    </tr>";
		  	} ?>
		  </tbody>
		</table>
	</div>

	<div class="large-3 columns">
		<p>Ajouter un nouvel administrateur : </p>
		<form action="#" method="POST">
			<input type="text" name="username" placeholder="Nom d'utilisateur" value="" required/>
			<input type="password" id="password" name="password" placeholder="Mot de passe" value="" required/>
			<input type="password" name="passwordconf" placeholder="Confirmez le mot de passe" value="" required/>
			<button type="submit" name="submit" class="button [radius round]">Envoyer</button>
		</form>	
	</div>
</div>