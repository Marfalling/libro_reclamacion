<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Reclamaciones</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <?php
        require("vista/titulo.php");
    ?>

        <div class="card">
            <div class="card-header">
            <img src="icon\numero-1.png" alt="Numero 1" class="img-fluid mb-1" style="width: 20px; height: 20px;">
                Datos del Consumidor Reclamante
            </div>
            <div class="card-body">
                <h5 class="card-title">Ingrese sus datos</h5>

                <form action="controlador/usuario_registrar.php" method="post">
                    <div class="form-row mb-3">
                        <div class="col mb-3">
                            <label class="form-label">Tipo de Documento</label>
                            <select name="tipo_documento" class="form-control" aria-label="Tipo de Documento" required>
                                <option selected>Seleccione un tipo de documento</option>
                                <option value="dni">DNI</option>
                                <option value="c.e">Carnet de Extranjeria</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label">Número de Documento</label>
                            <input type="text" name="num_documento" class="form-control" placeholder="Ingrese Número de documento" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nom" class="form-control" placeholder="Nombre" aria-label="Nombre" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Apellido Paterno</label>
                        <input type="text" name="ape_paterno" class="form-control" placeholder="Apellido Paterno" aria-label="Apellido Paterno" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Apellido Materno</label>
                        <input type="text" name="ape_materno" class="form-control" placeholder="Apellido Materno" aria-label="Apellido Materno" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Tipo de Respuesta</label>
                        <select name="tipo_resp" class="form-control" required>
                            <option value="" selected>Tipo de Respuesta</option>
                            <option value="Correo">Correo</option>
                            <option value="Dirección">Dirección de Domicilio</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Dirección de Domicilio</label>
                        <input type="text" name="dir" class="form-control" placeholder="Direccióon Domicilio" aria-label="Dirección Domicilio" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="cel" class="form-control" placeholder="Teléfono" aria-label="Teléfono" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" placeholder="E-mail" aria-label="Email" required>
                    </div>

                    <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="registrar">Siguiente</button>

                    </div>

                  </form>


            </div>
        </div>

    <?php
        require("vista/footer.php");
    ?>
</div>

</body>
</html>
