<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container-form">
        <div class="forms">
            <div class="form login">
                <span class="login-title">Iniciar Sesión</span>

                <form action="" method="post">
                    <div class="input-field">
                        <input type="text" name="usuario" id="usuario" placeholder="Escriba su usuario">
                        <img src="assets/icons/user.svg" class="icon">
                    </div>
                    <div class="input-field">
                        <input type="password" name="contraseña" id="contraseña" placeholder="Escriba su contraseña" class="password">
                        <img src="assets/icons/lock.svg" class="icon">
                        <img src="assets/icons/eye-slash.svg" class="showHidePw">
                    </div>
                    <div class="input-field button">
                        <input type="submit" value="Iniciar Sesión">
                    </div>

                    <div class="checkbox-test">
                        <div class="checkbox-content">
                            <input type="checkbox" name="logCheck" id="logCheck">
                            <label for="logCheck" class="text">Recordar mi contraseña</label>
                        </div>
                        <a href="#" class="text">¿Olvidaste tu contraseña?</a>
                    </div>

                    <?php
                    if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
                        require_once "php/main.php";
                        require_once "php/iniciar_sesion.php";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>

</html>