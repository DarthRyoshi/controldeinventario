<form action="index.php?action=crearPrestamo" method="POST">
    <div class="mb-3">
        <label class="form-label">Usuario</label>
        <select name="usuario_id" class="form-control" required>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Productos</label>
        <?php foreach ($productos as $prod): ?>
            <?php if ($prod['stock'] > 0): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="productos[<?= $prod['id'] ?>][id]" value="<?= $prod['id'] ?>" id="prod<?= $prod['id'] ?>">
                    <label class="form-check-label" for="prod<?= $prod['id'] ?>">
                        <?= htmlspecialchars($prod['nombre']) ?> - Stock: <?= $prod['stock'] ?>
                    </label>
                    <input type="number" name="productos[<?= $prod['id'] ?>][cantidad]" value="1" min="1" max="<?= $prod['stock'] ?>" class="form-control mt-1" style="width:100px; display:inline-block;">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-success mt-3">Crear Préstamo</button>
    <a href="index.php?action=prestamos" class="btn btn-secondary mt-3">Cancelar</a>
</form>
