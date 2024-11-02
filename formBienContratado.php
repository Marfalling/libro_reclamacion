<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Reclamaciones</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script>
        // Función para mostrar/ocultar el formulario del apoderado
        function siEsMenor() {
            const checkbox = document.getElementById('gridCheck');
            const apoderadoForm = document.getElementById('apoderadoForm');
            
            // Muestra el formulario si el checkbox está marcado
            apoderadoForm.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <?php
        require("vista/titulo.php");
    ?>

    <form action="controlador/reclamo_registrar.php" method="post">
        <div class="card">

        
            <div class="card-header">
            <img src="icon\numero-2.png" alt="Numero 2" class="img-fluid mb-1" style="width: 20px; height: 20px;">
                Información del Bien Contratado
                
            </div>
            <div class="card-body">

                
                
                    <div class="row justify-content-center">
                        <div class="col text-center">
                        <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_bien" id="gridRadios1" value="producto">
                                <label class="form-check-label" for="gridRadios1">
                                    Producto
                                </label>
                            </div>
                        </div>

                        <div class="col text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_bien" id="gridRadios2" value="servicio">
                                <label class="form-check-label" for="gridRadios2">
                                    Servicio
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group mb-3">
                        <label>Monto Reclamado</label>
                        <input type="text" name="monto_reclamado" class="form-control" placeholder="Monto Reclamado" aria-label="Monto Reclamado" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" class="form-control" placeholder="Descripición" aria-label="Descripción" required>
                    </div>

            </div>

        </div>

        <div class="card mt-5">
                    <div class="card-header">
                    <img src="icon\numero-3.png" alt="Numero 3" class="img-fluid mb-1" style="width: 20px; height: 20px;">
                        Detalle de Reclamación
                    </div>
                    <div class="card-body">
                                                   
                            <h5 class="text-center mb-4">Tipo de Reclamo</h5>
                            
                            <div class="row justify-content-center">
                                <div class="col text-center">
                                <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo_reclamo" id="gridRadios3" value="reclamo">
                                        <label class="form-check-label" for="gridRadios3">
                                            Reclamo
                                        </label>
                                    </div>
                                </div>

                                <div class="col text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipo_reclamo" id="gridRadios4" value="queja">
                                        <label class="form-check-label" for="gridRadios4">
                                            Queja
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label>Detalle del reclamo</label>
                                <input type="text" name="detalle_reclamo" class="form-control" placeholder="Detalle del Reclamo" aria-label="Detalle Reclamo" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Pedido</label>
                            <input type="text" name="pedido" class="form-control" placeholder="¿Cómo podemos ayudarte?" aria-label="Pedido" required>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="menor_edad" id="gridCheck" onclick="siEsMenor()">
                                    <label class="form-check-label" for="gridCheck">
                                        Menor de edad
                                    </label>
                                </div>
                            </div>

                            <div id="apoderadoForm" style="display: none;">
                                <h5 class="mt-4"> Información del Apoderado</h5>
                                
                                <div class="form-row mb-3">
                                    <div class="col mb-3">
                                        <label class="form-label">Tipo de Documento</label>
                                        <select name="tipo_documento" class="form-control" aria-label="Tipo de Documento">
                                            <option selected>Seleccione un tipo de documento</option>
                                            <option value="dni">DNI</option>
                                            <option value="c.e">Carnet de Extranjería</option>
                                        </select>
                                    </div>
                                    <div class="col mb-3">
                                        <label class="form-label">Número de Documento</label>
                                        <input type="text" name="num_documento" class="form-control" placeholder="Ingrese Número de documento">
                                    </div>
                                </div>

                                
                                <div class="form-group mb-3">
                                    <label>Nombre</label>
                                    <input type="text" name="nom" class="form-control" placeholder="Nombre" aria-label="Nombre">
                                </div>

                                
                                <div class="form-group mb-3">
                                    <label>Apellido Paterno</label>
                                    <input type="text" name="ape_paterno" class="form-control" placeholder="Apellido Paterno" aria-label="Apellido Paterno">
                                </div>

                                
                                <div class="form-group mb-3">
                                    <label>Apellido Materno</label>
                                    <input type="text" name="ape_materno" class="form-control" placeholder="Apellido Materno" aria-label="Apellido Materno">
                                </div>

                                                                
                                <div class="form-group mb-3">
                                    <label>Teléfono</label>
                                    <input type="text" name="cel" class="form-control" aria-label="Teléfono" placeholder="Teléfono">
                                </div>

                                
                                <div class="form-group mb-3">
                                    <label>E-mail</label>
                                    <input type="email" name="email" class="form-control" aria-label="Email" placeholder="E-mail">
                                </div>
                            </div>

                    </div>

                    <div class="text-center m-2 ">
                        <button type="submit" name="registrar" class="btn btn-primary">Enviar</button>
                    </div>
    </form>   
        
    </div>



    <section class="d-flex justify-content-around border border-light p-4">
        <div class="bg-light p-3 text-justify" style="flex: 1; margin: 0 10px; background-color: rgba(255, 255, 255, 0.8);">
            <p class="fs-5">Reclamo: Disconformidad relacionada a los productos o servicios.</p>
        </div>
        <div class="bg-light p-3 text-justify" style="flex: 1; margin: 0 10px; background-color: rgba(255, 255, 255, 0.8);">
            <p class="fs-5">Queja: Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público.</p>
        </div>
    </section>

    <div class="mt-4 p-3" style="background-color: rgba(255, 255, 255, 0.8);">
        <p class="fs-6">
            *La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.<br>
            *El proveedor debe dar respuesta al reclamo o queja en un plazo no mayor a quince (15) días hábiles, el cual es improrrogable.
        </p>
    </div>







    <?php
        require("vista/footer.php");
    ?>
</div>

</body>
</html>
