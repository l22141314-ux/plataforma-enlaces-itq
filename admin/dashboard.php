<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: index.php');
    exit;
}

require_once '../config/db.php';

// Obtener todos los enlaces con su categoría
$sql = "SELECT e.*, c.nombre AS categoria_nombre
        FROM enlaces e
        JOIN categorias c ON c.id = e.categoria_id
        ORDER BY c.nombre, e.titulo";
$enlaces = $pdo->query($sql)->fetchAll();

// Obtener categorías para el formulario de agregar
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .admin-container { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .btn { display: inline-block; padding: 0.6rem 1.2rem; background: #003366; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; }
        .btn:hover { background: #002244; }
        .btn-danger { background: #c0392b; }
        .btn-danger:hover { background: #a93226; }
        .btn-warning { background: #f39c12; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        th, td { padding: 0.8rem; text-align: left; border-bottom: 1px solid #eee; font-size: 0.9rem; }
        th { background: #003366; color: white; }
        tr:hover { background: #f9f9f9; }
        .acciones a { margin-right: 0.5rem; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Panel de Administración</h1>
            <h1>Panel de Administración</h1>
<p style="color:#555; margin-top:0.3rem;">Bienvenido, <?= htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador') ?></p>
            <div>
                <a href="agregar.php" class="btn">+ Agregar enlace</a>
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
                <a href="../index.php" class="btn">Ver sitio</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>URL</th>
                    <th>Destacado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($enlaces)): ?>
                    <tr><td colspan="6" style="text-align:center;">No hay enlaces registrados.</td></tr>
                <?php else: ?>
                    <?php foreach ($enlaces as $e): ?>
                        <tr>
                            <td><?= $e['id'] ?></td>
                            <td><?= htmlspecialchars($e['titulo']) ?></td>
                            <td><?= htmlspecialchars($e['categoria_nombre']) ?></td>
                            <td><a href="<?= htmlspecialchars($e['url']) ?>" target="_blank"><?= htmlspecialchars($e['url']) ?></a></td>
                            <td><?= $e['destacado'] ? '⭐ Sí' : 'No' ?></td>
                            <td class="acciones">
                                <a href="editar.php?id=<?= $e['id'] ?>" class="btn btn-warning">Editar</a>
                                <a href="eliminar.php?id=<?= $e['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este enlace?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>