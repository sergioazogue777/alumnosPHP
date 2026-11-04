<?php
require_once __DIR__ . '/db.php';
requireLogin();
$search = trim((string)($_GET['nombre'] ?? ''));
$page = max(1, filter_var($_GET['pagina'] ?? 1, FILTER_VALIDATE_INT) ?: 1);
$offset = ($page - 1) * 10;
try {
    $stmt = db()->prepare('SELECT id_alumno, dni_alumno, nombre_alumno FROM alumnos WHERE nombre_alumno LIKE ? ORDER BY id_alumno LIMIT 10 OFFSET ?');
    $stmt->bindValue(1, '%' . $search . '%', PDO::PARAM_STR);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $students = $stmt->fetchAll();
    $error = '';
} catch (PDOException $e) {
    $students = [];
    $error = 'No se ha podido recuperar el listado.';
}
?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Alumnos</title></head>
<body>
<h1>Listado de alumnos</h1>
<p><a href="ficha.php">Nuevo alumno</a></p>
<form method="get">
<label>Buscar por nombre <input name="nombre" value="<?= escapeHtml($search) ?>"></label>
<button type="submit">Buscar</button>
</form>
<?php if ($error): ?><p><?= escapeHtml($error) ?></p><?php endif; ?>
<table><thead><tr><th>DNI</th><th>Nombre</th><th>Ficha</th></tr></thead><tbody>
<?php foreach ($students as $student): ?>
<tr><td><?= escapeHtml($student['dni_alumno']) ?></td><td><?= escapeHtml($student['nombre_alumno']) ?></td>
<td><a href="ficha.php?id=<?= (int)$student['id_alumno'] ?>">Ver</a></td></tr>
<?php endforeach; ?>
</tbody></table>
<nav>
<?php if ($page > 1): ?><a href="?nombre=<?= urlencode($search) ?>&pagina=<?= $page-1 ?>">Anterior</a><?php endif; ?>
<?php if (count($students) === 10): ?><a href="?nombre=<?= urlencode($search) ?>&pagina=<?= $page+1 ?>">Siguiente</a><?php endif; ?>
</nav>
</body></html>
