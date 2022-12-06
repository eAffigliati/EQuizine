<?php
if(!isset($_SESSION['username'])){
	$url = base_url();
	header("Location:$url" . 'index.php/compte/connecter');
}
  echo'<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">';
    //Test si il y a au moins une actualités dans la base
    //Si vrai -> Affichage un tableau contenant les actualités
    //Si faux -> Affichage d'un message d'erreur
      echo '<div class="container-fluid py-4">
              <div class="row">
                <div class="col-12">
                  <form action="'. base_url() . 'index.php/match/creer/' . $quizData->QUI_id . '/' . $codeMtc . '">
                  <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Création de match</h6>
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
                            </tr>
                          </thead>
                          <tbody>
                          <td style="align-middle text-center text-sm">' . $quizData->QUI_intitule . '</td>
                          <td style="align-middle text-center text-sm">' . $quizData->auteurQuiz . '</td>';
                          if($quizData->QUI_etat == "A"){
                                $etat = 'success">Activé';
                              }else{
                                $etat = 'secondary">Désactivé';
                              }
                              echo '<td class="align-middle text-center text-sm">
                                      <span class="badge badge-sm bg-gradient-' . $etat . '</span>
                                    </td>';
                    echo '<td style="align-middle text-center text-sm">' . $codeMtc . '</td>
                          <td style="align-middle text-center text-sm">' . $_SESSION['username'] . '</td>
                          <td style="align-middle text-center text-sm">
                          <input type="datetime-local" name="dateDebut" value="' . date("Y-m-d") . 'T00:00" min="2020-00-00T00:00" max="2030-12-31T23:59">
                          </td>
                          <td style="align-middle text-center text-sm">
                            <span class="text-secondary text-xs font-weight-bold">En cours</span>
                          </td>
                          <td style="align-middle text-center text-sm">
                            <select name="etatMtc">
                                <option value="D">Désactivé</option>
                                <option value="A">Activé</option>
                            </select>
                          </td>
                          <td style="align-middle text-center text-sm">
                            <select name="correctionMtc">
                                <option value="I">Indisponible</option>
                                <option value="D">Disponible</option>
                            </select>
                          </td>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

              <button type="submit" class="btn bg-gradient-dark mb-0"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Ajouter le match</button>
            </form>
                </div>
              </div>';
        
      echo '</div>
        </main>';
?>

                    
                    

            