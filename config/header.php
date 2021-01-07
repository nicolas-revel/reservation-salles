<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand mx-3" href="<?= $path_index ?>index.php">Salle 0101</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item mx-3">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] === '/reservation-salles/index.php') : ?>active<?php endif; ?>" aria-current="page" href="<?= $path_index ?>index.php">Accueil</a>
        </li>
        <?php if (isConnected() === false) : ?>
          <li class="nav-item mx-3">
            <a class="nav-link <?php if ($_SERVER['PHP_SELF'] === '/reservation-salles/pages/connexion.php') : ?>active<?php endif; ?>" href="<?= $path_pages ?>connexion.php">Connexion</a>
          </li>
        <?php else : ?>
          <li class="nav-item mx-3">
            <a class="nav-link <?php if ($_SERVER['PHP_SELF'] === '/reservation-salles/pages/profil.php') : ?>active<?php endif; ?>" href="<?= $path_pages ?>profil.php">Profil</a>
          </li>
        <?php endif; ?>
        <li class="nav-item mx-3">
          <a class="nav-link <?php if ($_SERVER['PHP_SELF'] === '/reservation-salles/pages/planning.php') : ?>active<?php endif; ?>" href="<?= $path_pages ?>planning.php">Planning</a>
        </li>
      </ul>
        <?php if (isConnected() === true) : ?>
          <a href="<?= $_SERVER['PHP_SELF'] . '?d' ?>"><button class="btn btn-outline-secondary my-2 my-sm-0 mr-5">Se déconnecter</button></a>
        <?php endif; ?>
    </div>
  </div>
</nav>