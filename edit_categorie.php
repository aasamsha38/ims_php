<?php
  $page_title = 'Edit categorie';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $categorie = find_by_id('categories',(int)$_GET['id']);
  if(!$categorie){
    $session->msg("d","Missing categorie id.");
    redirect('categorie.php');
  }
?>

<?php
if(isset($_POST['edit_cat'])){
  $req_field = array('categorie-name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['categorie-name']));
  if(empty($errors)){
        $sql = "UPDATE categories SET name='{$cat_name}'";
       $sql .= " WHERE id='{$categorie['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Successfully updated Categorie");
       redirect('categorie.php',false);
     } else {
       $session->msg("d", "Sorry! Failed to Update");
       redirect('categorie.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('categorie.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
					<div class="workboard__heading">
						<h1 class="workboard__title">Edit Category</h1>
					</div>
					<div class="workpanel">
						<form class="general--form access__form" method="post" action="edit_categorie.php?id=<?php echo (int)$categorie['id'];?>">
							<div class="overall-info">
								<div class="row">
									<div class="col xs-12">
										<div class="info">
											<div class="row">
												<div class="col xs-12 sx-6">
                        <span>Editing <?php echo remove_junk(ucfirst($categorie['name']));?></span>
												</div>
												<div class="col xs-12 sx-6">
													<!-- <form action="get"> -->
														<div class="site-panel">
															<div class="form__action">
																<input type="submit" name="edit_cat" class="button primary-tint" value="Save">
															</div>
														</div>
													<!-- </form> -->
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col xs-12 sm-3">
												<div class="form__module">
													<label for="name" class="form__label">Name</label>
													<div class="form__set">
														<input type="text" id="name" name="categorie-name" value="<?php echo remove_junk(ucfirst($categorie['name']));?>" placeholder="Category Name" required>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
			</div>
      <?php include_once('layouts/footer.php'); ?>