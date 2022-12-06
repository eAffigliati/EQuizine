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
    //Test si il y a au moins une actualités dans la base
    //Si vrai -> Affichage un tableau contenant les actualités
    //Si faux -> Affichage d'un message d'erreur
    if($listMatchQuiz != null){
      echo '<div class="container-fluid py-4">
              <div class="row">
                <div class="col-12">';
              echo $result;
              echo '<div class="card my-4">
                     <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Gestionnaire des matchs</h6>
                      </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                      <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                          <thead>
                            <tr>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Intitule</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Auteur du quiz</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etat du quiz</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Code du match</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Auteur du match</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date de début</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date de fin</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etat du match</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correction</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                          </thead>
                          <tbody>';
                          foreach($listMatchQuiz as $duple){
                            if(!isset($traite[$duple["QUI_id"]])){
                              echo "<tr>";
                              echo "<td>" . $duple["QUI_intitule"] . "</td>";
                              echo "<td>" . $duple["auteurQuiz"] . "</td>";

                              if($duple["QUI_etat"] == "A"){
                                $etat = 'success">Activé';
                              }else{
                                $etat = 'secondary">Désactivé';
                              }
                              echo '<td class="align-middle text-center text-sm">
                                      <span class="badge badge-sm bg-gradient-' . $etat . '</span>
                                    </td>';
                        
                              $idQuiz = $duple["QUI_id"];
                        
                              //Code du match
                              echo "<td>";
                              foreach($listMatchQuiz as $duple2){
                                if($idQuiz == $duple2["QUI_id"]){
                                  if($duple2["MTC_dateDebut"] < date("Y-m-d H:i:s") && $duple2["MTC_etat"] == "A" && $duple2["auteurMatch"] == $_SESSION['username']){
                                    echo "<a href='" . base_url() . "index.php/match/afficherFormateur/" . $duple2["MTC_code"] . "'>" . $duple2['MTC_code'] . "</a><br>";
                                  }else{
                                    echo $duple2["MTC_code"] . "<br>";
                                  }
                                }
                              }
                              echo "</td>";
                              //Auteur du match
                              echo "<td>";
                              foreach($listMatchQuiz as $duple2){
                                if($idQuiz == $duple2["QUI_id"] && $duple2["MTC_code"] != null){
                                  echo $duple2["auteurMatch"] . "<br>";
                                }
                              }
                              echo "</td>";
                              //Date de début du match
                              echo "<td class='align-middle text-center' style='white-space: nowrap;'>";
                              foreach($listMatchQuiz as $duple2){
                                if($idQuiz == $duple2["QUI_id"] && $duple2["MTC_code"] != null){
                                  echo '<span class="text-secondary text-xs font-weight-bold">' . $duple2["MTC_dateDebut"] . '</span><br>';
                                }
                              }
                              echo "</td>";
                              //Date de fin du match
                              echo "<td class='align-middle text-center' style='white-space: nowrap;'>";
                              foreach($listMatchQuiz as $duple2){
                                if($idQuiz == $duple2["QUI_id"] && $duple2["MTC_code"] != null){
                                  if($duple2["MTC_dateFin"] == NULL){
                                  echo '<span class="text-secondary text-xs font-weight-bold">En cours</span><br>';
                                  }else{
                                  echo '<span class="text-secondary text-xs font-weight-bold">' . $duple2["MTC_dateFin"] . '</span><br>';
                                  }
                                }
                              }
                              echo "</td>";
                              //Etat du match
                              echo "<td class='text-sm'>";
                              foreach($listMatchQuiz as $duple2){
                                if($idQuiz == $duple2["QUI_id"] && $duple2["MTC_code"] != null){
                                  if($duple2["MTC_etat"] == "A"){
                                    $etat = 'success">Activé';
                                  }else{
                                    $etat = 'secondary">Désactivé';
                                  }
                                  if($duple2["auteurMatch"] == $_SESSION["username"]){
                                    $action = '<a href="' . base_url() . 'index.php/match/resetEtat/' . $duple2["MTC_code"] . '">
                                                <i class="material-icons opacity-10">restart_alt</i>
                                              </a>';
                                  }else{
                                    $action = "";
                                  }
                                  echo '<span class="badge badge-sm bg-gradient-' . $etat . '</span>' . $action . '<br>';
                                }
                              }
                              echo "</td>";
                              //Correction du match
                              echo "<td class='align-middle text-center text-sm'>";
                              foreach($listMatchQuiz as $duple2){
                                if($idQuiz == $duple2["QUI_id"] && $duple2["MTC_code"] != null){
                                  if($duple2["MTC_correction"] == "D"){
                                    $correction = 'success">Disponible';
                                  }else{
                                    $correction = 'secondary">Indisponible';
                                  }
                                  echo '<span class="badge badge-sm bg-gradient-' . $correction . '</span><br>';
                                }
                                }
                              echo "</td>";
                              //Action
                              echo "<td style='align-middle text-center text-sm'>";
                              foreach($listMatchQuiz as $duple2){
                                if($idQuiz == $duple2["QUI_id"] && $duple2["MTC_code"] != null){
                                  if($duple2["auteurMatch"] == $_SESSION["username"]){
                                    echo '<a href="' . base_url() . 'index.php/match/reset/' . $duple2["MTC_code"] . '">
                                            <i class="material-icons opacity-10">restart_alt</i>
                                          </a>
                                          <a href="' . base_url() . 'index.php/match/supprimer/' . $duple2["MTC_code"] . '">
                                            <i class="material-icons opacity-10">delete</i>
                                          </a><br>';
                                  }else{
                                    echo '<br>';
                                  }
                                }
                              }
                              echo "</td>
                              </tr>";
                            }

                            $traite[$duple["QUI_id"]] = 1;
                          }
                        echo'      </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <a class="btn bg-gradient-dark mb-0" href="' . base_url() . 'index.php/match/creer"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Ajouter un nouveau match</a>';
      }else{
        echo "<div class='row'>
                  <div class='col-lg-3'>
                  </div>
                  <div class='col-lg-6'>
                    <h2>Il n'y a pas de match pour le moment!</h2>
                  </div>
                  <div class='col-lg-3'>
                  </div>
                </div>";
      }
      echo '</div>
        </main>';
?>

                    
                    

            