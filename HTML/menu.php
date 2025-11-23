<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Casa de Toño | Menú QR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #fffaf4;
    }

    .categoria {
      font-size: 24px;
      font-weight: 600;
      margin-top: 40px;
      color: #00954c;
      border-left: 5px solid #00954c;
      padding-left: 10px;
    }

    .card img {
      height: 180px;
      object-fit: cover;
      cursor: pointer;
    }

    .card {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .precio {
      color: #21d900;
      font-weight: 700;
      font-size: 18px;
    }
    .card {
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}
.card img {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
.row {
  justify-content: center !important;
}
  /* NAV FIJO */
  .navbar-fija {
      position: sticky;
      top: 0;
      z-index: 9999;
      background: white;
      padding: 10px 25px;
      border-bottom: 1px solid #cccccc7a; /* LÍNEA DELGADA */
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  /* LOGO */
  .logo-nav {
      height: 55px;
      border-radius: 10px;
      background: white;
      padding: 5px;
      transition: 0.2s;
      box-shadow: 0px 0px 4px rgba(0,0,0,0.15);
  }
  .logo-nav:hover {
      transform: scale(1.05);
  }

  /* LINKS */
  .nav-link {
      font-size: 17px;
      font-weight: bold;
      color: #009944 !important;
      transition: 0.2s;
  }
  .nav-link:hover {
      color: #c8102e !important;
      transform: scale(1.05);
  }

  /* BOTÓN DE CERRAR SESIÓN */
  .btn-cerrar {
      background: #c8102e;
      color: white !important;
      font-weight: bold;
      border-radius: 6px;
  }
  .btn-cerrar:hover {
      background: #a10b28;
  }
</style>
  
</head>
<body>

<!-- MENÚ SUPERIOR COMO EL PASADO -->
<nav class="navbar navbar-expand-lg navbar-fija">
  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="../index.php">
        <img src="../imagenes/logo.png" alt="Logo" class="logo-nav">
    </a>

    <!-- BOTÓN HAMBURGUESA -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#MenuTop">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENÚ CENTRADO -->
    <div class="collapse navbar-collapse justify-content-center" id="MenuTop">
      <ul class="navbar-nav mb-2 mb-lg-0" style="gap:35px;">
        <li class="nav-item"><a class="nav-link nav-op" href="#antojitos">Antojitos</a></li>
        <li class="nav-item"><a class="nav-link nav-op" href="#sopas">Sopas</a></li>
        <li class="nav-item"><a class="nav-link" href="#platillos">Platillos</a></li>
        <li class="nav-item"><a class="nav-link" href="#postres">Postres</a></li>
        <li class="nav-item"><a class="nav-link" href="#bebidas">Bebidas</a></li>
        <a href="ver_comanda.php" class="btn btn-warning">🛒 Ver comanda</a>
      </ul>
    </div>

    <!-- BOTÓN CERRAR SESIÓN A LA DERECHA -->
    <div class="ms-auto">
      <a href="../logout.php" class="btn btn-cerrar px-3">
        Cerrar sesión
      </a>
    </div>

  </div>
</nav>

<div class="container py-4">

  <!-- ANTOJITOS -->
  <h2 class="categoria" id="antojitos">Antojitos</h2>
  <div class="row g-3 mt-1">

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="./alimentos/tacos.php">
          <img src="../imagenes/tacos-dorados-queso.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Tacos Dorados</h5>
          <p class="precio">$45</p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/quesadillas.php">
          <img src="../imagenes//descarga.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Quesadillas</h5>
          <p class="precio">$32</p>
        </div>
      </div>
    </div>

  </div>

  <!-- SOPAS -->
  <h2 class="categoria" id="sopas">Sopas</h2>
  <div class="row g-3 mt-1">

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/pozole.php">
          <img src="../imagenes/Pozole_06-1-principal.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Pozole</h5>
          <p class="precio">$90</p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/caldopollo.php">
          <img src="../imagenes/caldo-de-gallina.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Caldo de Pollo</h5>
          <p class="precio">$75</p>
        </div>
      </div>
    </div>

  </div>

  <!-- PLATILLOS -->
  <h2 class="categoria" id="platillos">Platillos</h2>
  <div class="row g-3 mt-1">

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/enchiladas.php">
          <img src="../imagenes/QUESO-FRESCO-ENCHILADAS-VERDES-LOW_WEB-scaled.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Enchiladas Verdes</h5>
          <p class="precio">$95</p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/milanesas.php">
          <img src="../imagenes/milanesa-de-pollo-con-papa-fritas.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Milanesa de Pollo</h5>
          <p class="precio">$110</p>
        </div>
      </div>
    </div>

  </div>

  <!-- POSTRES -->
  <h2 class="categoria" id="postres">Postres</h2>
  <div class="row g-3 mt-1">

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/flan.php">
          <img src="../imagenes/flan-napolitano-estilo-yoli-2000-22de04763e6148fa979f6af0a9f42a8f.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Flan Napolitano</h5>
          <p class="precio">$40</p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/arrozleche.php">
          <img src="../imagenes/arroz-leche-1-scaled.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Arroz con Leche</h5>
          <p class="precio">$35</p>
        </div>
      </div>
    </div>

  </div>

  <!-- BEBIDAS -->
  <h2 class="categoria" id="bebidas">Bebidas</h2>
  <div class="row g-3 mt-1 pb-4">

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/aguahorchata.php">
          <img src="../imagenes/GettyImages-493110032.jpg" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Agua de Horchata</h5>
          <p class="precio">$28</p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <div class="card">
        <a href="../html/alimentos/refresco.php">
          <img src="../imagenes/0516292-2.webp" class="card-img-top">
        </a>
        <div class="card-body">
          <h5>Refresco</h5>
          <p class="precio">$30</p>
        </div>
      </div>
    </div>

  </div>

</div>

</body>
</html>