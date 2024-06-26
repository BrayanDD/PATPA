<?php
 session_start();
 if(isset($_SESSION['usuario'])){
   header("location: content/inicio.php");
   
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>

        <main>

            <div class="contenedor__todo">
                <div class="caja__trasera">
                    <div class="caja__trasera-login">
                        <h3>¿Ya tienes una cuenta?</h3>
                        <p>Inicia sesión para entrar en la página</p>
                        <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                    </div>
                    <div class="caja__trasera-register">
                        <h3>¿Aun no tienes cuenta?</h3>
                        <p>Regístrate para que puedas iniciar sesión como:</p>
                        <button id="btn__registrarse__usuario">Usuario</button>
                        <button id="btn__registrarse__repartidor">Repartidor</button>
                        <button id="btn__registrarse__empresa">Empresa</button>
                    </div>
                </div>

                <!--Formulario de Login y registro-->
                <div class="contenedor__login-register">
                    <!--Login-->
                    
                    <form action="php/login.php" class="formulario__login" method="POST"> 
                        <div id="imglogo">
                            <img src="images/patpa.png" width="70" height="50"   >
                            
                        </div>
                        
                        <h2>Iniciar Sesión</h2>
                        <input type="email" placeholder="Correo Electronico" name="correo">
                        <input type="password" placeholder="Contraseña" name="contraseña">
                        <button>Entrar</button>
                    </form>

                    <!--Register-->
                    

                    <!-- Formulario de Registro Usuario -->
                    <form action="php/registro.php" class="formulario__register__usuario" method="POST">
                        <h2>Regístrarse como Usuario</h2>
                        <input type="text" placeholder="Nombre" name="nombre" required>
                        <input type="email" placeholder="Correo Electronico" name="correo" required>
                        <input type="text" placeholder="Usuario" name="usuario" required>
                        <input type="text" placeholder="Direccion" name="direccion" required>
                        <input type="password" placeholder="Contraseña" name="contraseña" required>
                        <button type="submit" name="formulario1">Regístrarse</button>
                    </form>

                    <!-- Formulario de Registro Repartidor -->
                    <!-- <form action="php/registro.php" class="formulario__register__repartidor" method="POST">
                        <h2>Regístrarse como Repartidor</h2>
                        <input type="text" placeholder="Nombre" name="nombre" required>
                        <input type="email" placeholder="Correo Electronico" name="correo" required>
                        <input type="text" placeholder="Usuario" name="usuario" required>
                        <input type="text" placeholder="Direccion" name="direccion" required>
                        <input type="number" placeholder="Edad" name="edad" required>
                        <input type="password" placeholder="Contraseña" name="contraseña" required>
                        <button type="submit" name="formulario2">Regístrarse</button>
                    </form> -->

                    <!-- Formulario de Registro Empresa -->
                    <form action="php/registro.php" class="formulario__register__empresa" method="POST">
                        <h2>Regístrarse como Empresa</h2>
                        <input type="text" placeholder="Nombre" name="nombre" required>
                        <input type="email" placeholder="Correo Electronico" name="correo" required>
                        <input type="text" placeholder="Usuario" name="usuario" required>
                        <input type="text" placeholder="Direccion" name="direccion" required>
                       
                        <select id="categorias" class="form-select" name="categoria" required>
                            <option selected value="" disabled>Selecionar</option>
                            <option value="1">Comidas Rapidas</option>
                            <option value="2">Cenas</option>
                        </select>
                        <input type="password" placeholder="Contraseña" name="contraseña" required>
                        <button type="submit" name="formulario3">Regístrarse</button>
                    </form>

                </div>
            </div>

        </main>

        <script src="js/sesion.js"></script>
</body>
</html>