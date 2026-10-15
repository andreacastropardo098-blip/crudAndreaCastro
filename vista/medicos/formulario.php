<?php
$editar = $medico->getId_medico() !== null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $editar ? "Editar médico" : "Nuevo médico" ?></title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>

<div class="contenedor formulario">

    <div class="titulo titulo-form">
        <span class="cruz">✚</span>
        <h1><?= $editar ? "Editar médico" : "Nuevo médico" ?></h1>
    </div>

    <form method="POST"
          enctype="multipart/form-data"
          action="index.php?accion=<?= $editar ? "actualizar" : "guardar" ?>">

        <?php if ($editar): ?>
            <input type="hidden" name="id_medico" value="<?= $medico->getId_medico() ?>">
        <?php endif; ?>

        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" maxlength="50" required
               value="<?= htmlspecialchars($medico->getNombres()) ?>">

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" maxlength="50" required
               value="<?= htmlspecialchars($medico->getApellidos()) ?>">

        <label for="especialidad">Especialidad:</label>
        <input type="text" id="especialidad" name="especialidad" maxlength="50" required
               value="<?= htmlspecialchars($medico->getEspecialidad()) ?>">

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" maxlength="15" required
               pattern="[0-9+\- ]{5,15}" title="Solo números (5 a 15 dígitos)"
               value="<?= htmlspecialchars($medico->getTelefono()) ?>">

        <label for="foto">Foto:</label>
        <?php if ($editar && $medico->getFoto() !== ""): ?>
            <p class="ayuda">Foto actual (si no eliges otra, se conserva):</p>
            <img src="<?= htmlspecialchars($medico->getFoto()) ?>" class="foto-medico foto-grande" alt="Foto actual">
        <?php endif; ?>
        <input type="file" id="foto" name="foto" accept="image/*"
               onchange="vistaPrevia(this)">
        <img id="previa" class="vista-previa" alt="Vista previa">

        <div class="acciones-formulario">
            <a href="index.php" class="btn btn-cancelar">Cancelar</a>

            <button type="submit" class="btn btn-guardar">
                <?= $editar ? "Actualizar" : "Guardar" ?>
            </button>
        </div>

    </form>
</div>

<script>
    // Vista previa de la foto seleccionada
    function vistaPrevia(input) {
        const img = document.getElementById("previa");
        if (input.files && input.files[0]) {
            img.src = URL.createObjectURL(input.files[0]);
            img.style.display = "block";
        } else {
            img.style.display = "none";
        }
    }
</script>

</body>
</html>
