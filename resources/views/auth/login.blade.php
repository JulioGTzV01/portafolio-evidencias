<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Iniciar sesión</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Correo electrónico</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Contraseña</label>   
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" required>

                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                    <i id="icono" class="bi bi-eye text-primary"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input">
                            <label class="form-check-label">Recordar sesión</label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/register">Crear cuenta</a>

                            <button class="btn btn-primary">
                                Iniciar sesión
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
   <script>
        function togglePassword() {
            let input = document.getElementById('password');
            let icono = document.getElementById('icono');

            if (input.type === "password") {
                input.type = "text";
                icono.classList.remove("bi-eye");
                icono.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icono.classList.remove("bi-eye-slash");
                icono.classList.add("bi-eye");
            }
        }
    </script>
</body>
</html>