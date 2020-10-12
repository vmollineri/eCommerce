<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
        <img src="<?php echo $srcIcone; ?>" width="36" height="36" alt="Icône du site" loading="lazy">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link linkCustom" href="<?php echo $hrefIndex; ?>">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle linkNavCustom" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Catégories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Nos jeux</a>
                        <a class="dropdown-item" href="#">Nos consoles</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Nos accessoires</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link linkNavCustom" href="<?php echo $hrefPanier; ?>">Panier</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">

                <?php
                if (isset($_SESSION['idUser'])) {
                    echo '<li class="nav-item">';
                    echo '<span id="messageUser" class="navbar-text linkNavCustom px-2">Hello ' . $_SESSION['prenomUser'] . '</span>';
                    echo '</li>';

                    echo '<li class="nav-item">';
                    echo '<a class="nav-link linkNavCustom" href="' . $hrefProfileUser . '">My Profile</a>';
                    echo '</li>';

                    echo '<li class="nav-item">';
                    echo '<a class="nav-link linkNavCustom" href="' . $hrefDeconnexion . '">Deconnexion</a>';
                    echo '</li>';

                } else {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link linkNavCustom" href="' . $hrefConnexion . '">Connexion</a>';
                    echo '</li>';

                    echo '<li class="nav-item">';
                    echo '<a class="nav-link linkNavCustom" href="' . $hrefInscription . '">S\'inscrire</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
