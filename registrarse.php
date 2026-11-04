<?php
require_once __DIR__ . '/db.php';
$error = '';
$done = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $email = trim((string)($_POST['email'] ?? ''));
    $name = trim((string)($_POST['nombre'] ?? ''));
    $password = (string)($_POST['contra'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $name === '' || strlen($password) < 8) {
        $error = 'Introduce un nombre, correo válido y contraseña de al menos 8 caracteres.';
    } else {
        try {
            $stmt = db()->prepare('INSERT INTO usuario (correo_usuario, nombre_usuario, contrasenya_usuario) VALUES (?, ?, ?)');
            $stmt->execute([$email, $name, password_hash($password, PASSWORD_DEFAULT)]);
            $done = true;
        } catch (PDOException $e) {
            $error = 'No se pudo completar el registro. Comprueba que el correo no esté registrado.';
        }
    }
}
?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Registro</title></head>
<body>
<h1>Registro</h1>
<?php if ($error): ?><p><?= escapeHtml($error) ?></p><?php endif; ?>
<?php if ($done): ?><p>Cuenta creada. <a href="login.php">Inicia sesión</a>.</p><?php else: ?>
<form method="post">
<input type="hidden" name="csrf" value="<?= csrfToken() ?>">
<label>Correo <input type="email" name="email" required></label>
<label>Nombre <input type="text" name="nombre" required></label>
<label>Contraseña <input type="password" name="contra" minlength="8" required></label>
<button type="submit">Registrarse</button>
</form>
<?php endif; ?>
</body></html>
