<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registro de Usuarios</title>
    </head>
    <body class="sb-nav-fixed">

  
        <div id="layoutSidenav">
            

            <div id="layoutSidenav_content">
                <main>
                <?php
                require("../modelo/m_usuario.php");

                //de esta forma recojo los datos de mi formulario
                    //Si presiono en el botón registrar voy a recepecionar los datos que están
                if(isset($_REQUEST['registrar']))
                {
                    $tipo_documento = $_REQUEST['tipo_documento'];
                    $num_documento = $_REQUEST['num_documento'];
                    $nom = $_REQUEST['nom'];
                    $ape_paterno = $_REQUEST['ape_paterno'];
                    $ape_materno = $_REQUEST['ape_materno'];
                    $tipo_resp = $_REQUEST['tipo_resp'];
                    $dir = $_REQUEST['dir'];
                    $cel = $_REQUEST['cel'];
                    $email = $_REQUEST['email'];
                    
                    //Ahora puedo llamar la función RegistrarUsuario
                    $rpta = RegistrarUsuario($tipo_documento,$num_documento, $nom, $ape_paterno, $ape_materno,$tipo_resp,$dir, $cel,$email);

                     // Verificar si la respuesta es exitosa antes de redirigir
                    if ($rpta) 
                    {
                        // Redirigir a formBiencontratado.php
                        header("Location: ../formBienContratado.php?id=".$rpta);
                        exit(); // Asegurarse de detener el script
                    } else {
                        echo "<p>Error al registrar el usuario. Intente nuevamente.</p>";
                    }
                }

                require("../index.php");
                ?>          
                </main>
                <footer class="py-4 bg-light mt-auto">
                <?php
                require("vista/footer.php");
                ?>
                </footer>
            </div>
        </div>
        <?php
        require("vista/scripts.php");
        ?>
    </body>
</html>
