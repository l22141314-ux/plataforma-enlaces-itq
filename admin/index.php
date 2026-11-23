<?php
// admin/index.php
session_start();

// Usuario y contraseña (en producción, esto debería estar en la BD)
$usuario_valido = 'admin';
$password_hash = '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCS4bZJ18JuywdBz0jJ0yq4T5K1yK'; // contraseña: admin123

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($usuario === $usuario_valido && password_verify($password, $password_hash)) {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .login-box {
            max-width: 400px;
            margin: 5rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .login-box h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 1.5rem;
        }
        .login-box input {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .login-box button {
            width: 100%;
            padding: 0.8rem;
            background: #003366;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        .login-box button:hover {
            background: #002244;
        }
        .error {
            color: #c0392b;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Panel de Administración</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
        <p style="text-align:center; margin-top:1rem; font-size:0.85rem; color:#777;">
            Usuario: admin / Contraseña: admin123
        </p>
        <p style="text-align:center; margin-top:0.5rem;">
            <a href="../index.php" style="color:#0066cc;">← Volver al sitio</a>
        </p>
    </div>
</body>
</html>