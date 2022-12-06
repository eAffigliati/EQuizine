

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

 
  <div class="row">
    <a class="navbar-brand m-0" href="<?php echo base_url();?>index.php/compte/connecter" style="width:100%">
      <img src="<?php echo base_url();?>assetsBack/img/EQuizineLogo.png" class="navbar-brand-img" alt="main_logo">
      <hr class="horizontal light mt-0 mb-2">
    </a>
  </div>

  <div style="row">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white " href="<?php echo base_url();?>index.php/profil/afficher">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div> 
          <span class="nav-link-text ms-1">Mon profil</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="<?php echo base_url();?>index.php/compte/lister">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">group</i>
          </div> 
          <span class="nav-link-text ms-1">Compte</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="#">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment</i>
          </div> 
          <span class="nav-link-text ms-1">Quiz</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="#">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">event</i>
          </div> 
          <span class="nav-link-text ms-1">Actualité</span>
        </a>
      </li>
    </ul>
  </div>
  <div class="sidenav-footer position-absolute w-100 bottom-0 ">
    <div class="mx-3">
      <a class="btn bg-gradient-primary mt-4 w-100" href="<?php echo base_url() ?>index.php/compte/deconnecter" type="button"><i class="material-icons opacity-10">logout</i>Déconnexion</a>
    </div>
  </div>
</aside>