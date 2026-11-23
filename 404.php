<?php
// 404.php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - ITQ</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div style="text-align:center; padding:5rem 1rem;">
        <h1 style="font-size:4rem; color:#003366;">404</h1>
        <h2 style="color:#333; margin-bottom:1rem;">Página no encontrada</h2>
        <p style="color:#666; margin-bottom:2rem;">Lo sentimos, la página que buscas no existe o fue movida.</p>
        <a href="index.php" class="btn" style="display:inline-block; padding:0.8rem 1.5rem; background:#003366; color:white; text-decoration:none; border-radius:6px; font-weight:600;">Volver al inicio</a>
    </div>
</body>
</html>