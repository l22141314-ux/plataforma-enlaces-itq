<?php
// admin/agregar.php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/db.php';

$categorias = $pdo->query("SELECT * FROM categorias ORDER BY nombre")->fetchAll();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $url = trim($_POST['url'] ?? '');
    $categoria_id = (int)($_POST['categoria_id'] ?? 0);
    $destacado = isset($_POST['destacado']) ? 1 : 0;

    if ($titulo === '' || $url === '' || $categoria_id === 0) {
        $error = 'Todos los campos obligatorios deben estar llenos.';
    } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
        $error = 'La URL no es válida.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO enlaces (titulo, descripcion, url, categoria_id, destacado) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $descripcion, $url, $categoria_id, $destacado]);
        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Agregar enlace</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .form-box { max-width: 600px; margin: 3rem auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .form-box h2 { color: #003366; margin-bottom: 1.5rem; }
        .form-box label { display: block; margin-bottom: 0.3rem; font-weight: 600; }
        .form-box input, .form-box textarea, .form-box select { width: 100%; padding: 0.7rem; margin-bottom: 1rem; border: 1px solid #ccc; border-radius: 6px; font-family: inherit; }
        .form-box textarea { resize: vertical; min-height: 80px; }
        .form-box button { width: 100%; padding: 0.8rem; background: #003366; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; }
        .form-box button:hover { background: #002244; }
        .error { color: #c0392b; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Agregar nuevo enlace</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>Título *</label>
            <input type="text" name="titulo" required>

            <label>Descripción</label>
            <textarea name="descripcion"></textarea>

            <label>URL *</label>
            <input type="url" name="url" placeholder="https://..." required>

            <label>Categoría *</label>
            <select name="categoria_id" required>
                <option value="">Selecciona una categoría</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <label style="display:flex; align-items:center; gap:0.5rem;">
                <input type="checkbox" name="destacado" style="width:auto; margin:0;"> Destacar como aviso/convocatoria
            </label>

            <button type="submit">Guardar enlace</button>
        </form>
        <p style="text-align:center; margin-top:1rem;"><a href="dashboard.php" style="color:#0066cc;">← Volver al dashboard</a></p>
    </div>
</body>
</html>