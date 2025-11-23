<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quesadillas</title>

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background: #fffaf4;
      margin: 0;
      padding: 30px;
      text-align: center;
    }

    .container {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    img {
      width: 100%;
      border-radius: 16px;
      height: 260px;
      object-fit: cover;
    }

    h1 {
      color: #00954c;
      margin-top: 20px;
      font-size: 32px;
    }

    .precio {
      color: #d90000;
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    ul {
      text-align: left;
      margin-top: 10px;
    }

    .btn {
      display: inline-block;
      background: #00954c;
      padding: 12px 25px;
      margin-top: 20px;
      border-radius: 12px;
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 18px;
    }
  </style>
</head>
<body>

<div class="container">
  <img src="../../imagenes/descarga.jpg" alt="Quesadillas">

  <h1>Quesadillas</h1>
  <p class="precio">$32</p>

  <h3>Ingredientes:</h3>
  <ul>
    <li>Tortilla de maíz o harina</li>
    <li>Queso Oaxaca o manchego</li>
    <li>Crema</li>
    <li>Salsa verde o roja</li>
    <li>Opcional: flor de calabaza, champiñones o tinga</li>
  </ul>

  <!-- BOTÓN REGRESAR -->
  <a href="../menu.php" class="btn">← Regresar al menú</a>

  <!-- BOTÓN AGREGAR A COMANDA -->
  <a href="../ver_comanda.php?producto=Quesadillas&precio=32"
     class="btn" style="background:#00693e;margin-top:15px;">
     🛒 Agregar a comanda
  </a>
</div>

</body>
</html>