<?php
if(!isset($_SESSION['username'])){
	$url = base_url();
	header("Location:$url" . 'index.php/compte/connecter');
}
if(isset($result)){
  $result = '<div class="alert alert-' . $resultType . ' alert-dismissible text-white" role="alert">
                <span class="text-sm">' . $result . '</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>';
}else{
  $result = "";
}
if($choix == "afficher"){
  echo'<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  			<div class="container-fluid py-4">
              <div class="row">
                <div class="col-12">';
                echo $result . '
              	   <div class="card my-4" style="padding-bottom:5%">
                     <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Informations personnelles</h6>
                      </div>
                     </div>
                     <div class="row" style="margin-top:5%">
                     	<div class="col-4"></div> 
                     	<div class="col-4">
                     		<div class="card">
							<div class="card-header p-3 pt-2">
								<div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
									<i class="material-icons opacity-10">person</i>
								</div>
								<div class="text-end pt-1">
									<h4 class="mb-0 text-capitalize">' . $infoPerso->PRF_nom . '</h4>
									<h5 class="mb-0 text-capitalize">' . $infoPerso->PRF_prenom . '</h5>
								</div>
							</div>
							<hr class="dark horizontal my-0">
							<div class="card-footer p-3">
								<p class="mb-0">' . $_SESSION['username'] . '</p>
							</div>
							<div class="text-center">
								<a href="' . base_url() . 'index.php/profil/afficher/modifier" class="btn bg-gradient-primary w-100 my-4 mb-2">Modifier mot de passe</a>
							</div>
                     	</div> 
                     	<div class="col-4"></div> 
						</div>
					 </div
                   </div>
                </div>
              </div>
            </div>
        </main>';
}else{
  echo'<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  			<div class="container-fluid py-4">
              <div class="row">
                <div class="col-12">';
                echo $result . '
              	   <div class="card my-4" style="padding-bottom:5%">
                     <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Informations personnelles</h6>
                      </div>
                     </div>
                     <div class="row" style="margin-top:5%">
                     	<div class="col-4"></div> 
                     	<div class="col-4">
                     		<div class="card">
							<div class="card-header p-3 pt-2">
								<div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
									<i class="material-icons opacity-10">person</i>
								</div>
								<div class="text-end pt-1">
									<h4 class="mb-0 text-capitalize">' . $infoPerso->PRF_nom . '</h4>
									<h5 class="mb-0 text-capitalize">' . $infoPerso->PRF_prenom . '</h5>
								</div>
							</div>
							<hr class="dark horizontal my-0">
							<div class="card-footer p-3">
								<p class="mb-0">' . $_SESSION['username'] . '</p>
							</div>
							<div class="text-center">
								<a href="' . base_url() . 'index.php/profil/afficher/modifier" class="btn bg-gradient-primary w-100 my-4 mb-2">Modifier mot de passe</a>
							</div>
							<hr class="dark horizontal my-0">';		
      				   echo validation_errors();
      				   echo form_open('modificationMdp'); 
      				   echo'<div class="input-group input-group-outline my-3">
								<label for="newPass">Mot de passe</label>
								<input type="password" class="form-control" name="newPass">
							</div><div class="input-group input-group-outline my-3">
								<label for="confirmPass">Confirmation</label>
								<input type="password" class="form-control" name="confirmPass">
							</div>
							<div class="text-center">
								<button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Valider</button>
							</div>
							</form>
							<div class="text-center">
								<a href="' . base_url() . 'index.php/profil/afficher" class="btn bg-gradient-primary w-100 my-4 mb-2">Annuler</a>
							</div>
                     	</div> 
                     	<div class="col-4"></div> 
						</div>
					 </div
                   </div>
                </div>
              </div>
            </div>
        </main>';

}
?>       