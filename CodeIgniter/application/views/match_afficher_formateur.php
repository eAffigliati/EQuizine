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
  echo'<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">';
      echo '<div class="container-fluid py-4">
              <div class="row">
                <div class="col-12">';
              echo $result;
              echo '<div class="card my-4">
                     <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Gestionnaire des matchs</h6>
                      </div>
                    </div>';
                if(isset($scoreFinal)){
                	echo'
                    <div class="row" style="padding-top:5%;">
                      <div class="col-4"></div>
                      <div class="col-4">
                        <div class="card">
                          <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                              <i class="material-icons opacity-10">sports_score</i>
                            </div>
                            <div class="text-end pt-1">
                              <p class="text-sm mb-0 text-capitalize">Pourcentage de réussite</p>
                              <h4 class="mb-0">' . $scoreFinal->scoreFinal . '%</h4>
                            </div>
                          </div>
                          <hr class="dark horizontal my-0">
                          <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">' . $nombreJoueur->nbJou . '</span> participants</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-4"></div>
                    </div>';
                  }
              echo '<div class="card-body px-0 pb-2">';
                    if($match != NULL){
											$mtcCode = $match[0]['MTC_code'];
											echo "<h1>" . $match[0]['QUI_intitule'] . " - " . $match[0]['MTC_code'] . "</h1>";
											echo "<ul>";
											foreach($match as $duple){
												if(!isset($traite[$duple["QUE_text"]])){
													echo "<li>";
													echo $duple["QUE_text"];
													echo "<ul>";
										
													$repText = $duple["QUE_text"];
										
													foreach($match as $duple2){
														if(strcmp($repText, $duple2["QUE_text"]) == 0){
															echo "<li>";
															echo $duple2["RES_text"];
															echo "</li>";
														}
													}
													echo "</ul></li>";
													$traite[$duple["QUE_text"]] = 1;
												}
											}
											echo "</ul>";
										}else{
											echo "<br />";
											echo "Aucun résultat";
										}
              echo '</div>';
              if(!isset($scoreFinal)){
                echo '<a class="btn bg-gradient-dark mb-0" href="' . base_url() . 'index.php/match/afficherScore/' . $mtcCode . '"><i class="material-icons text-sm">lock</i>&nbsp;&nbsp;Terminer le match</a>';
              } 
              echo '</div>
                </div>
              </div>
            </div>
        </main>';
?>

                    
                    

