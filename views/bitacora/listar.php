<h1>Bitácora</h1>

<form method="GET" class="form-filtro">
    <label>Fecha inicio:</label>
    <input type="date" name="fecha_inicio" value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? '') ?>">

    <label>Fecha fin:</label>
    <input type="date" name="fecha_fin" value="<?= htmlspecialchars($_GET['fecha_fin'] ?? '') ?>">

    <button type="submit">Filtrar</button>
</form>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Acción</th>
            <th>Descripción</th>
            <th>Usuario</th>
            <th>Producto (Serial)</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($bitacoras)): ?>
            <?php foreach($bitacoras as $row): ?>
                <tr>
                    <td><?= $row['fecha'] ?></td>
                    <td><?= $row['accion'] ?></td>
                    <td><?= $row['descripcion'] ?></td>
                    <td><?= $row['usuario'] ?></td>
                    <td><?= $row['producto_serial'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No hay registros en la bitácora</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="index.php?action=dashboard" class="btn btn-secondary btn-back">Volver a Inicio</a>
