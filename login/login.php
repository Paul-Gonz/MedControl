<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Iniciar Sesión</title>
    <link href="../Assets/css/styles.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <style>
        .logo-placeholder {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background-color: transparent;
            border: 2px dashed #ccc; 
            border-radius: 8px; 
            display: block;
        }
        .logo-placeholder {
    background: url(../images/logo.png) center/contain no-repeat;
    border: none; 
}
    </style>
</head>

<body class="bg-primary d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">
    <div id="layoutAuthentication" class="d-flex align-items-center justify-content-center" style="height: 100%; width: 100%;">
        <div id="layoutAuthentication_content" class="w-100">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-12">
                                <div class="card-header text-center">
                                    <div class="logo-placeholder mb-4"></div>
                                    <h3 class="text-center font-weight-light">Iniciar Sesión</h3>
                                </div>
                                <div class="card-body">
                                    <form id="">
                                        <div class="form-group mb-4">
                                            <label class="font-weight d-block mb-2 text-center" for="usuario">Usuario</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input class="form-control form-control-lg" id="usuario" name="usuario" type="text" placeholder="Ingrese Usuario" />
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="font-weight d-block mb-2 text-center" for="contraseña">Contraseña</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                </div>
                                                <input class="form-control form-control-lg" id="contraseña" name="contraseña" type="password" placeholder="Ingrese Contraseña" />
                                            </div>
                                        </div>

                                        <div class="form-group text-center mt-4 mb-0">
                                            <button class="btn btn-primary btn-lg" type="button" onclick="">Ingresar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>