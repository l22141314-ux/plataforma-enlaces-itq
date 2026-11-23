<?php
// index.php
require_once 'config/db.php';

// Capturar término de búsqueda
$busqueda = trim($_GET['q'] ?? '');

// Obtener categorías y enlaces (con o sin filtro)
if ($busqueda !== '') {
    $sql = "SELECT c.id AS categoria_id, c.nombre AS categoria_nombre, c.descripcion AS categoria_descripcion,
                   e.id AS enlace_id, e.titulo, e.descripcion, e.url, e.destacado
            FROM categorias c
            LEFT JOIN enlaces e ON e.categoria_id = c.id
            WHERE e.titulo LIKE :q OR e.descripcion LIKE :q
            ORDER BY c.id, e.destacado DESC, e.titulo ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':q' => "%$busqueda%"]);
} else {
    $sql = "SELECT c.id AS categoria_id, c.nombre AS categoria_nombre, c.descripcion AS categoria_descripcion,
                   e.id AS enlace_id, e.titulo, e.descripcion, e.url, e.destacado
            FROM categorias c
            LEFT JOIN enlaces e ON e.categoria_id = c.id
            ORDER BY c.id, e.destacado DESC, e.titulo ASC";
    $stmt = $pdo->query($sql);
}

$rows = $stmt->fetchAll();

$categorias = [];
foreach ($rows as $row) {
    $catId = $row['categoria_id'];
    if (!isset($categorias[$catId])) {
        $categorias[$catId] = [
            'nombre' => $row['categoria_nombre'],
            'descripcion' => $row['categoria_descripcion'],
            'enlaces' => []
        ];
    }
    if ($row['enlace_id']) {
        $categorias[$catId]['enlaces'][] = [
            'titulo' => $row['titulo'],
            'descripcion' => $row['descripcion'],
            'url' => $row['url'],
            'destacado' => $row['destacado']
        ];
    }
}

// Destacados
$stmtDestacados = $pdo->query("SELECT titulo, descripcion, url FROM enlaces WHERE destacado = 1 ORDER BY fecha_creacion DESC LIMIT 5");
$destacados = $stmtDestacados->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Enlaces - ITQ</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="header">
        <h1>Instituto Tecnológico de Querétaro</h1>
        <p>Plataforma de Enlaces Institucionales</p>
    </header>

    <nav class="nav">
        <a href="#categorias">Categorías</a>
        <a href="#destacados">Avisos y Convocatorias</a>
        <a href="admin/index.php">Admin</a>
    </nav>

    <main class="container">
        <!-- Buscador -->
        <section class="buscador">
            <form method="GET" action="index.php">
                <input type="text" name="q" placeholder="Buscar enlaces por título o descripción..." value="<?= htmlspecialchars($busqueda) ?>">
                <button type="submit">Buscar</button>
                <?php if ($busqueda !== ''): ?>
                    <a href="index.php" class="limpiar">Limpiar</a>
                <?php endif; ?>
            </form>
            <?php if ($busqueda !== ''): ?>
                <p class="resultado-info">
                    <?php
                    $total = 0;
                    foreach ($categorias as $c) { $total += count($c['enlaces']); }
                    ?>
                    <?= $total ?> resultado(s) para "<?= htmlspecialchars($busqueda) ?>"
                </p>
            <?php endif; ?>
        </section>

        <?php if ($busqueda !== '' && empty(array_filter(array_column($categorias, 'enlaces')))): ?>
            <p class="vacio" style="text-align:center; font-size:1.1rem;">No se encontraron resultados para "<?= htmlspecialchars($busqueda) ?>".</p>
        <?php endif; ?>

        <?php if (!empty($destacados) && $busqueda === ''): ?>
        <section id="destacados" class="destacados">
            <h2>🔔 Avisos y Convocatorias Vigentes</h2>
            <div class="destacados-grid">
                <?php foreach ($destacados as $d): ?>
                    <div class="card destacado">
                        <h3><?= htmlspecialchars($d['titulo']) ?></h3>
                        <p><?= htmlspecialchars($d['descripcion']) ?></p>
                        <a href="<?= htmlspecialchars($d['url']) ?>" target="_blank" rel="noopener">Ir al recurso →</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <section id="categorias">
            <h2>Categorías de Recursos</h2>

            <?php foreach ($categorias as $cat): ?>
                <?php if (empty($cat['enlaces']) && $busqueda !== '') continue; ?>
                <div class="categoria">
                    <h3><?= htmlspecialchars($cat['nombre']) ?></h3>
                    <p class="categoria-desc"><?= htmlspecialchars($cat['descripcion']) ?></p>

                    <?php if (empty($cat['enlaces'])): ?>
                        <p class="vacio">No hay enlaces en esta categoría.</p>
                    <?php else: ?>
                        <div class="enlaces-grid">
                            <?php foreach ($cat['enlaces'] as $enlace): ?>
                                <div class="card">
                                    <h4><?= htmlspecialchars($enlace['titulo']) ?></h4>
                                    <p><?= htmlspecialchars($enlace['descripcion']) ?></p>
                                    <a href="<?= htmlspecialchars($enlace['url']) ?>" target="_blank" rel="noopener">Abrir recurso →</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> ITQ - Plataforma de Enlaces. Proyecto académico.</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>