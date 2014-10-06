<?php

$id_category = $_GET['id'];
$category_name = $db->query("SELECT name FROM gallery_categories WHERE id='$id_category'")->fetch();
$photos = $db->query("SELECT id, file FROM gallery_images WHERE id_category='$id_category';")->fetchAll();
$gallery = NULL;
$listGallery = NULL;
$listeCategories = $db->query("SELECT id, name FROM gallery_categories")->fetchAll();

foreach($listeCategories as $row){
  $categoryID = $row['id'];
  $categoryName = $row['name'];
  $listGallery .= "<li><a href='gallery.php?id=$categoryID'><img src='img/admin/arrow.png' alt='arrow'>$categoryName</a></li>";

}

foreach($photos as $row){
	$file = $row['file'];
	$gallery .= "<li><a href='img/gallery/$file'><img src='img/gallery/$file' alt='photo' class='th'></a></li>";
}

?>


<div class="row">
	<h3 class="center"><?php echo $category_name['name'];?></h4><br/><br/>

	<ul class="large-3 columns side-nav show-for-large-up texts-nav">
	  <p class="pdf">Accès rapide</p>
	  <?php echo $listGallery; ?>
	</ul>

	<div class="large-8 columns">
		<ul class='clearing-thumbs small-block-grid-3 medium-block-grid-5 large-block-grid-8' data-clearing>
			<?php echo $gallery; ?>
		</ul>
	</div>	

</div>