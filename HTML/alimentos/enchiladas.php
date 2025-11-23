<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Enchiladas Verdes</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
  body {font-family:'Montserrat',sans-serif;background:#fffaf4;margin:0;padding:30px 15px;display:flex;justify-content:center;}
  .card {background:white;width:100%;max-width:430px;border-radius:18px;padding:25px;box-shadow:0 6px 18px rgba(0,0,0,0.15);text-align:center;}
  img {width:100%;border-radius:15px;max-height:280px;object-fit:cover;margin-bottom:15px;}
  h1 {font-size:28px;color:#00954c;margin-top:0;}
  .precio {font-size:26px;font-weight:800;color:#c90000;margin-bottom:10px;}
  ul {text-align:left;margin:0 auto;padding-left:20px;font-size:17px;line-height:1.5;}
  .btn {display:inline-block;margin-top:20px;padding:12px 25px;background:#00954c;color:white;border-radius:10px;text-decoration:none;font-size:18px;font-weight:600;}
</style>

</head>
<body>

<div class="card">
  <h1>Enchiladas Verdes</h1>

  <img src="../../imagenes/QUESO-FRESCO-ENCHILADAS-VERDES-LOW_WEB-scaled.jpg">

  <p class="precio">$95</p>

  <h3>Ingredientes:</h3>
  <ul>
    <li>Tortillas de maíz</li>
    <li>Salsa verde</li>
    <li>Pollo deshebrado</li>
    <li>Crema</li>
    <li>Queso fresco</li>
    <li>Cebolla</li>
    <li>Lechuga opcional</li>
  </ul>

  <!-- BOTÓN REGRESAR -->
  <a href="../menu.php" class="btn">← Regresar al menú</a>

  <!-- BOTÓN AGREGAR A COMANDA -->
  <a href="../ver_comanda.php?producto=Enchiladas%20Verdes&precio=95" 
     class="btn" style="margin-top:12px;background:#00693e;">
     🛒 Agregar a comanda
  </a>

</div>

</body>
</html>