<?php
$id = $_GET['id'];
$select = $db->query("SELECT title FROM sorties WHERE id='$id';")->fetchAll();
$inscrits = $db->query("SELECT id, nom, prenom, baudrier, casque FROM inscriptionsorties WHERE id_sortie='$id';")->fetchAll();
$listeinscrits = '';
$nb_casques = 0;
$nb_baudriers = 0;

foreach($inscrits as $row){
  $nom = $row['nom'];
  $prenom = $row['prenom'];
  $casque = $row['casque'];
  $baudrier = $row['baudrier'];
  $id_inscrit = $row['id'];
  $listeinscrits .= "<li>$nom, $prenom <a href='#uncheck'><img src='img/admin/uncheck.png' alt='delete' class='uncheck' id='$id_inscrit'></a>
                        <form method='POST' action='#' class='hidden $id_inscrit' id='$id_inscrit'>
                          <label>Entrez votre mot de passe de désinscription</label>
                          <input type='password' name='password_uncheck' id='password_uncheck'>
                          <input type='hidden' name='id_inscrit' id='id_inscrit' value='$id_inscrit'>
                          <button type='submit' class='button tiny [radius round]' name='submit_uncheck' placeholder='Votre mot de passe'>Ok !</button>
                        </form>
                      </li>";
  if($casque == 1)
    $nb_casques++;
  if($baudrier == 1)
    $nb_baudriers++;
}


if(empty($select)){
  die("<h1 class='center'>Il n'y a pas de sortie comportant cette ID.</h1>");
}else{
  $title = $select[0]['title'];
  echo "<h1 class='center'>S'inscrire à la sortie $title</h1>";
}

if(isset($_POST['submit_uncheck'])){
  $password_uncheck = sha1($_POST['password_uncheck']);
  $id_inscrit = $_POST['id_inscrit'];
  $goodPassword = $db->query("SELECT password FROM inscriptionsorties WHERE id='$id_inscrit'")->fetch();
  $goodPassword = $goodPassword['password'];

  if($password_uncheck == $goodPassword){
    setFlash("Vous vous êtes bien supprimé(e) de cette sortie.");
    $db->query("DELETE FROM inscriptionsorties WHERE id='$id_inscrit'");
    header("Location:inscriptionsortie.php?id=$id");
    die();
  }else{
    setFlash("Mauvais mot de passe de désinscription", "warning");
    header("Location:inscriptionsortie.php?id=$id");
    die();
  }
}

if(isset($_POST['submit']) && $_POST['password'] != $_POST['passwordconf']){
  setFlash('Les mots de passe ne correspondent pas', 'warning');
  header("Location:inscriptionsortie.php?id=$id");
  die();
}

if(isset($_POST['submit']) && $_POST['password'] == $_POST['passwordconf']){
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $casque = $_POST['casque'];
  $baudrier = $_POST['baudrier'];
  $password = $_POST['password'];
  $db->query("INSERT INTO inscriptionsorties VALUES (NULL, '$nom', '$prenom', '$baudrier', '$casque', SHA1('$password'), '$id');");
  setFlash("Vous vous êtes bien inscrit à cette sortie.");
  header("Location:inscriptionsortie.php?id=$id");
  die();

}



?>
<div class="row">

  <div class="large-3 columns">
    <div class="panel callout radius">
      <p>Utilisez ce formulaire pour vous inscrire à la sortie.</p>
      <p><strong>Entrez un mot de passe</strong>, vous en aurez besoin si vous voulez vous désinscrire de la liste à droite (cliquez sur la croix).</p>
      <p>Les besoins en matériels sont comptabilisés.</p>
    </div>
  </div>

	<div class="large-4 columns">

		<form method="POST" action="">
			<input type="text" placeholder="Nom" name="nom" required />
			<input type="text" placeholder="Prénom" name="prenom" required />

      <p>Besoin d'un casque ?
			<input type="radio" name="casque" value="1" id="casque" checked><label for="casque">Oui</label>
      <input type="radio" name="casque" value="0" id="casque"><label for="casque">Non</label></p>

      <p>Besoin d'un baudrier ?
      <input type="radio" name="baudrier" value="1" id="baudrier" checked><label for="baudrier">Oui</label>
      <input type="radio" name="baudrier" value="0" id="baudrier"><label for="baudrier">Non</label></p>

      <label for="password">Mot de passe pour pouvoir vous désinscrire par la suite.</label>
      <input type="password" name="password" id="password" required>
      <label for="passwordconf">Confirmez :</label>
      <input type="password" name="passwordconf" id="passwordconf" required>

      <button type="submit" class="button [radius round]" name="submit" placeholder="Votre mot de passe">Envoyer</button>
      	</form>

        <div class="panel center">
          <h3>Besoins en matériel :</h3>
          <p>Casques : <?php echo $nb_casques; ?></p>
          <p>Baudriers : <?php echo $nb_baudriers; ?></p>
        </div>

	</div>

<ul class="large-3 columns side-nav">
  <?php if(empty($inscrits))
          echo "<p class='pdf'>Pas d'inscrits.</p>";
        else
          echo "<p class='pdf'>Liste des inscrits : </p>" . $listeinscrits;
 ?>
</ul>

</div>