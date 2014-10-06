<?php

$listeCategories = $db->query("SELECT id, name FROM gallery_categories")->fetchAll();
$gallery = NULL;

foreach($listeCategories as $row){
  $categoryID = $row['id'];
  $categoryName = $row['name'];
  $gallery .= "<li><a href='gallery.php?id=$categoryID'>$categoryName</a></li>";

}

?>
<div class="row">
<h1 class="center">Médias</h1>

<div class="large-20 columns gallery">
<h3>Galeries photo</h3>

<ul>
<?php echo $gallery; ?>
</ul>

  <h3>Vidéo de présentation</h3>

    <div class="flex-video">
      <iframe width="100" height="100" src="//www.youtube.com/embed/i0xinqZJfyE" frameborder="0" allowfullscreen></iframe>
    </div>
    </div>
</div>