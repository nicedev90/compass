  <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top mb-5" >
    <div class="container-fluid">
      <a class="navbar-brand fs-5 " href="<?php setIndexPage() ?>">Inicio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center fs-5">

          <?php if ( usuarioLoggedIn() ) : ?>
            <li class="nav-item">
              <a href="perfil.php" class="nav-link"  aria-current="page">Gestionar Mi Perfil</a>
            </li>
            <li class="nav-item">
              <a href="contacto.php" class="nav-link"  aria-current="page">Contacto</a>
            </li>
            <li class="nav-item">
              <a href="buzon.php" class="nav-link"  aria-current="page">Buzon</a>
            </li>

            <li class="nav-item">
              <form method="post" action="#" >
                <button type="submit" name="logout" class="btn btn-danger fs-5">  Salir </button>
              </form>
            </li>

          <?php elseif ( organizadorLoggedIn() ) : ?>
            <li class="nav-item">
              <a href="PerfilPersonal.php" class="nav-link"  aria-current="page">Gestionar Mi Perfil</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="PanelAdmin.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Crear
              </a>
              <ul class="dropdown-menu">
                <li><a class= "dropdown-item" href="crearEvento.php">Eventos</a></li>
                <li><a class= "dropdown-item" href="CrearUbicacion.php">Ubicaciones</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="Contacto.php" class="nav-link"  aria-current="page">Contacto</a>
            </li>
            <li class="nav-item">
              <a href="BuzonMensajes.php" class="nav-link"  aria-current="page">Buzon</a>
            </li>

            <li class="nav-item">
              <form method="post" action="#" >
                <button type="submit" name="logout" class="btn btn-danger fs-5">  Salir </button>
              </form>
            </li>


          <?php elseif ( adminLoggedIn() ) : ?>
            <li class="nav-item">
              <a href="perfil.php" class="nav-link"  aria-current="page">Gestionar Mi Perfil</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="PanelAdmin.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Crear
              </a>
              <ul class="dropdown-menu">
                <li><a class= "dropdown-item" href="crearEvento.php">Eventos</a></li>
                <li><a class= "dropdown-item" href="crearUbicacion.php">Ubicaciones</a></li>
                <li><a class= "dropdown-item" href="categorias.php">Categorias</a></li> 
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Administrar
              </a>
              <ul class="dropdown-menu">
                
                <li><a class="dropdown-item" href="admin_organizadores.php">Organizadores</a></li>
                <li><a class="dropdown-item" href="admin_usuarios.php"> Usuarios</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="contacto.php" class="nav-link"  aria-current="page">Contacto</a>
            </li>
            <li class="nav-item">
              <a href="buzon.php" class="nav-link"  aria-current="page">Buzon</a>
            </li>

            <li class="nav-item">
              <form method="post" action="#" >
                <button type="submit" name="logout" class="btn btn-danger fs-5">  Salir </button>
              </form>
            </li>

          <?php endif; ?>

          <?php if ( notLoggedIn() ) : ?>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="registro.php">Registro Usuario</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Buscar por Ubicacion
              </a>
              <ul id="lista_ubicaciones" class="dropdown-menu">

              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Buscar por Categoria
              </a>
              <ul id="lista_categorias" class="dropdown-menu">

              </ul>
            </li>  

          <?php endif; ?>

        </ul>
        
        <div class="d-flex" role="search">
          <input class="form-control me-2 text-value" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success " onclick="searchFunction()" >Busqueda por palabra clave</button>
        </div>

      </div>
    </div>
  </nav> 
