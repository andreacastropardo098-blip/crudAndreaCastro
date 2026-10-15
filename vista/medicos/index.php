<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Médico</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>

<?php
// Mensajes que se muestran después de cada acción
$textos = [
    "guardado"      => ["ok",    "Médico registrado correctamente."],
    "actualizado"   => ["ok",    "Médico actualizado correctamente."],
    "eliminado"     => ["ok",    "Médico eliminado correctamente."],
    "foto_invalida" => ["error", "La foto no es válida. Usa JPG, PNG, GIF o WEBP de máximo 2 MB."],
    "no_existe"     => ["error", "El médico solicitado no existe."]
];
?>

<?php if (isset($textos[$mensaje])): ?>
    <div class="aviso aviso-<?= $textos[$mensaje][0] ?>" id="aviso">
        <?= $textos[$mensaje][1] ?>
    </div>
<?php endif; ?>

<div class="contenedor">

    <div class="encabezado">
        <div class="titulo">
            <span class="cruz">✚</span>
            <div>
                <h1>Hospital Médico</h1>
                <p class="subtitulo">Registro de médicos · <?= count($medicos) ?> en total</p>
            </div>
        </div>
        <button type="button" class="btn btn-nuevo" onclick="abrirModal()">
            + Agregar médico
        </button>
    </div>

    <div class="tabla-caja">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Especialidad</th>
                    <th>Teléfono</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($medicos)): ?>
                    <tr>
                        <td colspan="7" class="sin-registros">
                            No existen médicos registrados.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($medicos as $medico): ?>
                        <tr>
                            <td><span class="etiqueta-id"><?= $medico->getId_medico() ?></span></td>
                            <td><?= htmlspecialchars($medico->getNombres()) ?></td>
                            <td><?= htmlspecialchars($medico->getApellidos()) ?></td>
                            <td><span class="especialidad"><?= htmlspecialchars($medico->getEspecialidad()) ?></span></td>
                            <td><?= htmlspecialchars($medico->getTelefono()) ?></td>
                            <td>
                                <?php if ($medico->getFoto() !== ""): ?>
                                    <img src="<?= htmlspecialchars($medico->getFoto()) ?>"
                                         alt="Foto de <?= htmlspecialchars($medico->getNombres()) ?>"
                                         class="foto-medico">
                                <?php else: ?>
                                    <span class="sin-foto">Sin foto</span>
                                <?php endif; ?>
                            </td>
                            <td class="acciones">
                                <a href="index.php?accion=editar&id=<?= $medico->getId_medico() ?>"
                                   class="btn btn-editar">
                                    Editar
                                </a>
                                <a href="index.php?accion=eliminar&id=<?= $medico->getId_medico() ?>"
                                   class="btn btn-eliminar"
                                   onclick="return confirm('¿Está seguro de eliminar a este médico?');">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- =====================================================
     VENTANA MODAL: NUEVO MÉDICO
     ===================================================== -->
<div id="modalMedico" class="modal">

    <div class="modal-contenido">

        <div class="modal-encabezado">
            <h2>Nuevo médico</h2>
            <button type="button" class="cerrar" onclick="cerrarModal()">&times;</button>
        </div>

        <form method="POST" action="index.php?accion=guardar" enctype="multipart/form-data">

            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" maxlength="50" required
                   placeholder="Ingrese los nombres">

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" maxlength="50" required
                   placeholder="Ingrese los apellidos">

            <label for="especialidad">Especialidad:</label>
            <input type="text" id="especialidad" name="especialidad" maxlength="50" required
                   placeholder="Ej: Pediatría">

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" maxlength="15" required
                   pattern="[0-9+\- ]{5,15}" title="Solo números (5 a 15 dígitos)"
                   placeholder="Ej: 76464380">

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*"
                   onchange="vistaPrevia(this, 'previaNuevo')">
            <img id="previaNuevo" class="vista-previa" alt="Vista previa">

            <div class="acciones-formulario">
                <button type="button" class="btn btn-cancelar" onclick="cerrarModal()">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-guardar">
                    Guardar médico
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Abrir la ventana modal
    function abrirModal() {
        document.getElementById("modalMedico").style.display = "flex";
        document.getElementById("nombres").focus();
    }

    // Cerrar la ventana modal
    function cerrarModal() {
        document.getElementById("modalMedico").style.display = "none";
    }

    // Cerrar al hacer clic fuera del contenido
    window.onclick = function (event) {
        const modal = document.getElementById("modalMedico");
        if (event.target === modal) {
            cerrarModal();
        }
    };

    // Vista previa de la foto seleccionada
    function vistaPrevia(input, idImagen) {
        const img = document.getElementById(idImagen);
        if (input.files && input.files[0]) {
            img.src = URL.createObjectURL(input.files[0]);
            img.style.display = "block";
        } else {
            img.style.display = "none";
        }
    }

    // El aviso desaparece solo a los 4 segundos
    const aviso = document.getElementById("aviso");
    if (aviso) {
        setTimeout(function () { aviso.classList.add("oculto"); }, 4000);
        // Se limpia el parámetro ?msg= de la barra de direcciones
        history.replaceState(null, "", "index.php");
    }
</script>

</body>
</html>
