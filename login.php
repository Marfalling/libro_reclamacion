<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Iniciar Sesión</title>
    <link rel="icon" type="image/png" href="icon\Rysoft.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/estilos.css">

    <style>
        body {
            background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(to right, #4a5568, #2d3748);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .login-logo {
            max-width: 200px;
            margin-bottom: 15px;
        }
        .login-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 25px;
            padding: 10px 15px;
        }
        .btn-login {
            border-radius: 25px;
            padding: 10px 20px;
            background: linear-gradient(to right, #4a5568, #2d3748);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(50,50,93,.1), 0 3px 6px rgba(0,0,0,.08);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            margin-bottom: 10px;
            color: #6c757d;
        }
        .input-group-text {
            background: transparent;
            border: none;
            color: #6c757d;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="icon\Rysoft.png" alt="Rysoft Logo" class="login-logo">
            <h3 class="mb-0">Sistema de Administración</h3>
        </div>
        <div class="login-body">
            <form action="controlador/autentificacion.php" method="post">
                <div class="form-group">
                    <label for="user_admin">
                        <i class="fas fa-user mr-2"></i>Usuario
                    </label>
                    <div class="input-group">
                        <input class="form-control" name="user_admin" type="text" id="user_admin" 
                               placeholder="Ingrese su usuario" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock mr-2"></i>Contraseña
                    </label>
                    <div class="input-group">
                        <input class="form-control" name="password" type="password" id="password" 
                               placeholder="Ingrese su contraseña" required />
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-login text-white w-100">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>