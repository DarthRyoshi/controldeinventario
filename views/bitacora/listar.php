<h1>Bitacora</h1>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Acción</th>
            <th>Descripción</th>
            <th>Usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($bitacoras)): ?>
            <?php foreach($bitacoras as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['fecha']) ?></td>
                    <td><?= htmlspecialchars($row['accion']) ?></td>
                    <td><?= htmlspecialchars($row['descripcion']) ?></td>
                    <td><?= htmlspecialchars($row['usuario']) ?></td>
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
