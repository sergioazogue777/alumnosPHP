<?php
require_once __DIR__ . '/db.php';
requireLogin();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: null;
$student = ['dni_alumno' => '', 'nombre_alumno' => '', 'direccion_alumno' => '', 'poblacion_alumno' => ''];
$error = '';
try {
    $pdo = db();
    if ($id) {
        $stmt = $pdo->prepare('SELECT * FROM alumnos WHERE id_alumno = ?');
        $stmt->execute([$id]);
        $student = $stmt->fetch() ?: $student;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        verifyCsrf();
        $action = (string)($_POST['accion'] ?? '');
        $dni = trim((string)($_POST['dni'] ?? ''));
        $name = trim((string)($_POST['nombre'] ?? ''));
        $address = trim((string)($_POST['direccion'] ?? ''));
        $town = trim((string)($_POST['poblacion'] ?? ''));
        if ($action === 'Borrar' && $id) {
            $stmt = $pdo->prepare('DELETE FROM alumnos WHERE id_alumno = ?');
            $stmt->execute([$id]);
        } elseif (in_array($action, ['Crear', 'Grabar'], true)) {
            if ($dni === '' || $name === '') throw new InvalidArgumentException('El DNI y el nombre son obligatorios.');
            if ($action === 'Grabar' && $id) {
                $stmt = $pdo->prepare('UPDATE alumnos SET dni_alumno=?, nombre_alumno=?, direccion_alumno=?, poblacion_alumno=? WHERE id_alumno=?');
                $stmt->execute([$dni, $name, $address, $town, $id]);
            } elseif ($action === 'Crear' && !$id) {
                $stmt = $pdo->prepare('INSERT INTO alumnos (dni_alumno,nombre_alumno,direccion_alumno,poblacion_alumno,created_by,created_date) VALUES (?,?,?,?,?,CURDATE())');
                $stmt->execute([$dni, $name, $address, $town, $_SESSION['usuario']]);
            } else {
                throw new InvalidArgumentException('Acción no válida.');
            }
        } else {
            throw new InvalidArgumentException('Acción no válida.');
        }
        header('Location: listado.php');
        exit;
    }
} catch (PDOException $e) {
    $error = 'No se ha podido guardar o recuperar el alumno.';
} catch (InvalidArgumentException $e) {
    $error = $e->getMessage();
}
?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Ficha de alumno</title></head>
<body>
<h1><?= $id ? 'Editar alumno' : 'Nuevo alumno' ?></h1>
<p><a href="listado.php">Volver al listado</a></p>
<?php if ($error): ?><p><?= escapeHtml($error) ?></p><?php endif; ?>
<form method="post">
<input type="hidden" name="csrf" value="<?= csrfToken() ?>">
<label>DNI <input name="dni" required value="<?= escapeHtml($student['dni_alumno']) ?>"></label>
<label>Nombre <input name="nombre" required value="<?= escapeHtml($student['nombre_alumno']) ?>"></label>
<label>Dirección <input name="direccion" value="<?= escapeHtml($student['direccion_alumno']) ?>"></label>
<label>Población <input name="poblacion" value="<?= escapeHtml($student['poblacion_alumno']) ?>"></label>
<button name="accion" value="<?= $id ? 'Grabar' : 'Crear' ?>"><?= $id ? 'Guardar' : 'Crear' ?></button>
<?php if ($id): ?><button name="accion" value="Borrar" onclick="return confirm('¿Borrar este alumno?')">Borrar</button><?php endif; ?>
</form>
</body></html>
