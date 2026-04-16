<x-guest-layout>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

    <div class="card shadow-sm" style="max-width: 400px; width:100%;">

        <!-- HEADER -->
        <div class="card-header text-center fw-bold">
            Registro
        </div>

        <!-- BODY -->
        <div class="card-body p-3">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-2">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-2 position-relative">
                    <label class="form-label">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        required
                        pattern="(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*#?&]).{8,}"
                        title="Debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial">

                    <div id="requisitosPassword" class="row mt-2" style="font-size: 0.8rem;">
                        <div class="col-6 text-danger" id="reqLength">❌ 8 caracteres</div>
                        <div class="col-6 text-danger" id="reqUpper">❌ Mayúscula</div>
                        <div class="col-6 text-danger" id="reqNumber">❌ Número</div>
                        <div class="col-6 text-danger" id="reqSymbol">❌ Símbolo</div>
                    </div> 

                    <span onclick="togglePassword()" 
                        style="position:absolute; right:15px; top:38px; cursor:pointer;">
                        <i id="iconoPassword" class="bi bi-eye text-primary"></i>
                    </span>
                </div>

                <!-- CONFIRMAR -->
                <div class="mb-4 position-relative">
                    <label class="form-label">Confirmar contraseña</label>
                        <div id="mensajePassword" 
                            style="position:absolute; bottom:-25px; left:0;" 
                            class="text-danger fw-semibold d-none">
                            Las contraseñas no coinciden
                        </div>
                        <input 
                            type="password" 
                            id="password_confirmation"
                            name="password_confirmation" 
                            class="form-control" 
                            required>
                    <span onclick="togglePasswordConfirm()" 
                        style="position:absolute; right:15px; top:38px; cursor:pointer;">
                        <i id="iconoConfirm" class="bi bi-eye text-primary"></i>
                    </span>
                </div>

                <!-- LINK + BOTON -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        Ya tengo cuenta
                    </a>

                    <button type="submit" id="btnRegistro" class="btn btn-primary" disabled>
                        Registrarse
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
function togglePassword() {
    let input = document.getElementById('password');
    let icono = document.getElementById('iconoPassword');

    if (input.type === "password") {
        input.type = "text";
        icono.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        input.type = "password";
        icono.classList.replace("bi-eye-slash", "bi-eye");
    }
}

function togglePasswordConfirm() {
    let input = document.getElementById('password_confirmation');
    let icono = document.getElementById('iconoConfirm');

    if (input.type === "password") {
        input.type = "text";
        icono.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        input.type = "password";
        icono.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>

<script>
const password = document.getElementById('password');
const confirmPassword = document.getElementById('password_confirmation');
const mensaje = document.getElementById('mensajePassword');
const boton = document.getElementById('btnRegistro');

function validarPasswords() {
    if (password.value === "" || confirmPassword.value === "") {
        mensaje.classList.add('d-none');
        boton.disabled = true;
        return;
    }

    if (password.value !== confirmPassword.value) {
        mensaje.classList.remove('d-none');
        mensaje.classList.remove('text-success');
        mensaje.classList.add('text-danger');
        mensaje.textContent = "Las contraseñas no coinciden";
        boton.disabled = true;
    } else {
        mensaje.classList.remove('d-none');
        mensaje.classList.remove('text-danger');
        mensaje.classList.add('text-success');
        mensaje.textContent = "Las contraseñas coinciden";
        boton.disabled = false;
    }
}

// Escuchar cambios en tiempo real
password.addEventListener('keyup', validarPasswords);
confirmPassword.addEventListener('keyup', validarPasswords);
</script>

<script>
function validarPasswords() {
    let pass = document.getElementById('password').value;
    let confirm = document.querySelector('[name="password_confirmation"]').value;
    let mensaje = document.getElementById('mensajePassword');

    if (pass !== confirm && confirm.length > 0) {
        mensaje.classList.remove('d-none');
    } else {
        mensaje.classList.add('d-none');
    }
}

// Detectar mientras escribe
document.getElementById('password').addEventListener('input', validarPasswords);
document.querySelector('[name="password_confirmation"]').addEventListener('input', validarPasswords);
</script>

<script>
document.getElementById('password').addEventListener('input', function() {
    let value = this.value;

    let length = value.length >= 8;
    let upper = /[A-Z]/.test(value);
    let number = /[0-9]/.test(value);
    let symbol = /[^A-Za-z0-9]/.test(value);

    actualizar('reqLength', length);
    actualizar('reqUpper', upper);
    actualizar('reqNumber', number);
    actualizar('reqSymbol', symbol);
});

function actualizar(id, cumple) {
    let item = document.getElementById(id);

    if (cumple) {
        item.textContent = item.textContent.replace('❌', '✔');
        item.classList.remove('text-danger');
        item.classList.add('text-success');
    } else {
        item.textContent = item.textContent.replace('✔', '❌');
        item.classList.remove('text-success');
        item.classList.add('text-danger');
    }
}
</script>

</x-guest-layout>