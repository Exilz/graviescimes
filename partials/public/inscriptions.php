<?php

            $rand1 = rand(1, 10);
            $rand2 = rand(1, 10);
            $result = $rand1 + $rand2;
            $result = "$result";

if(isset($_POST['submit'])){

  if($_POST['verif'] == $_POST['result']){

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $mail = $_POST['mail'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $date = date("d-m-Y");

    $db->query("INSERT INTO inscriptions VALUES(NULL, '$nom', '$prenom', '$age', '$mail', '$tel', '$adresse', '$date', 0);");

    setFlash('Vous êtes bien pré-inscrit');
    header('Location:inscriptions.php');
    die();
  }

  else{
    setFlash('Le code de vérification est faux', 'alert');
    header('Location:inscriptions.php');
    die();
   }



}

?>
<h1 class="center">Inscriptions</h1>

<h3>Pré-inscription à l'association</h3>

<div class="row">

	<div class="large-6 columns">

		<form method="POST" action="#">
			<input type="text" placeholder="Nom" name="nom" required />
			<input type="text" placeholder="Prénom" name="prenom" required />
			<select name="age">
		        <option value="79">7-9 ans</option>
		        <option value="1012">10-12 ans</option>
		        <option value="1317">13-17 ans</option>
		        <option value="18 ">Adulte</option>
      		</select>
      		<input type="email" placeholder="Votre email" name="mail" required />
      		<input type="number" placeholder="Téléphone" name="tel" required />
      		<input type="text" placeholder="Adresse" name="adresse" required />
      		<div class="large-4 columns">
      			<?php
            echo 'Combien font ' . $rand1 . ' + ' . $rand2 . ' ? ';
            ?>
      		</div>
      		<div class="large-2 columns">
      			<input type="text" name="verif" required/>
            <input type="hidden" name="result" value=<?php echo $result; ?>>
      		</div>
      		<button type="submit" class="button [radius round]" name="submit">Envoyer</button>
      	</form>

	</div>

<ul class="large-3 columns side-nav show-for-large-up">
	<p class="pdf">PDFs télécharger</p>
  <li><a href="files/inscrenfants.pdf"><img src="img/pdf.gif" alt="pdf">Fiche inscription enfants/ados</a></li>
  <li><a href="files/inscradultes.pdf"><img src="img/pdf.gif" alt="pdf">Fiche inscription adultes</a></li>
</ul>

</div>