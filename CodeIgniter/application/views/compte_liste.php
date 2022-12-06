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
    if($profil != null){
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
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom Prénom</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Identifiant</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rôle</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etat</th>
                            </tr>
                          </thead>
                          <tbody>';
                          foreach($profil as $rsp){
                              echo "<tr>";
                              echo "<td>" . $rsp["PRF_nom"] . " " . $rsp["PRF_prenom"] . "</td>";
                              echo "<td>" . $rsp["RSP_pseudo"] . "</td>";

                              if($rsp["PRF_role"] == "F"){
                                $role = 'success">Formateur';
                              }else{
                                $role = 'secondary">Administrateur';
                              }
                              echo '<td class="align-middle text-center text-sm">
                                      <span class="badge badge-sm bg-gradient-' . $role . '</span>
                                    </td>';
                              if($rsp["PRF_etat"] == "A"){
                                $etat = 'success">Activé';
                              }else{
                                $etat = 'secondary">Désactivé';
                              }
                              echo '<td class="align-middle text-center text-sm">
                                      <span class="badge badge-sm bg-gradient-' . $etat . '</span>
                                    </td>';
                            echo '</tr>';
                            }
                        echo'      </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>';
      }else{
        echo "<div class='row'>
                  <div class='col-lg-3'>
                  </div>
                  <div class='col-lg-6'>
                    <h2>Il n'y a pas de compte pour le moment!</h2>
                  </div>
                  <div class='col-lg-3'>
                  </div>
                </div>";
      }
      echo '</div>
        </main>';
?>

                    
                    

