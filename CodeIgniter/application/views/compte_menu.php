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
?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="container-fluid py-4">
              <div class="row">
                <div class="col-12">
                <?php echo $result ?>
                  <div class="card my-4" style="padding-bottom:5%">
                   <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Espace personnel</h6>
                      </div>
                   </div>
                   <div class="row" style="margin-top:5%">
                      <div class="col-4"></div>
                      <h3 class="col-4">Bienvenue <?php echo $this->session->userdata('username');?></h3>
                      <div class="col-4"></div>
                   </div>
                  </div>
                </div>
              </div>
            </div>
        </main>';