  <div class="container">
    <div class="row" style="margin-top: 10%; margin-bottom: 10%;">
      <div class="col-lg-5">
      </div>
      <?php echo validation_errors(); ?> 
      <?php
      //Test si un code Match n'a pas déja été saisi
      //Si vrai -> Affichage d'un formulaire pour saisir le code d'un match
      //Si faux -> Affichage d'un formulaire pour saisir un pseudo
      if(!isset($mtcCode)){
        //Test si il y a au moins un match dans la base
        //Si vrai -> Affichage du formulaire
        //Si faux -> Affichage d'un message d'erreur
        if($matchExist == TRUE){
          //Formulaire avec un champs de saisie pour le code d'un match et un bouton submit vers le controlleur Accueil
          $attributes = array('class' => 'form-group col-lg-2');
          echo form_open('page_accueil', $attributes); 
          echo '
            <label for="codeMtc">Code du match</label>
            <label for="codeMtc" style="color:red;">' . $erreur . '</label>
            <input class="form-control" name="codeMtc" type="text">
            <button type="submit" class="btn btn-success" style="margin-top: 5%;">Valider</button>
          </form>
          <div class="col-lg-5">
          </div>
        </div>';
        }
        else{
          echo "<div class='col-lg-2'>
              <p>Aucun match pour l'instant !</p>
            </div>
            <div class='col-lg-5'>
            </div>
          </div>";
        }
      }else{
         //Formulaire avec un champs de saisie pour le code d'un match prérempli et insaisissable, un champs de saisie pour le pseudo du joueur et un bouton submit vers le controller Match
         echo '
           <form action="'. base_url() . 'index.php/match/afficher/' . $mtcCode . '" class="form-group col-lg-2">
            <label for="codeMtc">Code du match</label>
            <input class="form-control" name="codeMtc" type="text" value="' . $mtcCode . '" readonly>
            <label for="pseudoJou">Pseudo</label>
            <label for="pseudoJou" style="color:red;">' . $erreur . '</label>
            <input class="form-control" name="pseudoJou" type="text">
            <button type="submit" class="btn btn-success" style="margin-top: 5%;">Valider</button>
          </form>
          <div class="col-lg-5">
          </div>
        </div>';
      }
      //Test si il y a au moins une actualités dans la base
      //Si vrai -> Affichage un tableau contenant les actualités
      //Si faux -> Affichage d'un message d'erreur
      if($actu != null){
        echo '
        <div class="row">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Intitule</th>
                <th>Texte</th>
                <th>Date de publication</th>
                <th>Auteur</th>
              </tr>
            </thead>
            <tbody>';
          foreach($actu as $news){
            echo "<tr>";
            echo "<td>" . $news["new_intitule"] . "</td>";
            echo "<td>" . $news["new_text"] . "</td>";
            echo "<td>" . $news["new_date"] . "</td>";
            echo "<td>" . $news["auteur"] . "</td>";
            echo "</tr>";
          }
          echo'  
            </tbody>
          </table>
        </div>';
        }else{
          echo "<div class='row'>
                  <div class='col-lg-3'>
                  </div>
                  <div class='col-lg-6'>
                    <h2>Aucune actualité pour l'instant !</h2>
                  </div>
                  <div class='col-lg-3'>
                  </div>
                </div>";
        }
        ?>
      </div>