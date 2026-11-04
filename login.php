<?php
require_once __DIR__ . '/db.php';
if (!empty($_SESSION['user_id'])) { header('Location: listado.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['contra'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Introduce un correo válido.';
    } else {
        try {
            $stmt = db()->prepare('SELECT id_usuario, nombre_usuario, contrasenya_usuario FROM usuario WHERE correo_usuario = ? LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['contrasenya_usuario'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int)$user['id_usuario'];
                $_SESSION['usuario'] = $user['nombre_usuario'];
                header('Location: listado.php');
                exit;
            }
            $error = 'Correo o contraseña incorrectos.';
        } catch (PDOException $e) {
            $error = 'No se pudo conectar a la base de datos.';
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Acceso</title></head>
<body>
<h1>Acceso</h1>
<?php if ($error): ?><p><?= escapeHtml($error) ?></p><?php endif; ?>
<form method="post">
<input type="hidden" name="csrf" value="<?= csrfToken() ?>">
<label>Correo <input type="email" name="email" required></label>
<label>Contraseña <input type="password" name="contra" required></label>
<button type="submit">Entrar</button>
</form>
<p><a href="registrarse.php">Crear cuenta</a></p>
</body></html>
