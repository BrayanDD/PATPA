<?php 
include "../../php/consultas_empresas.php";
if(!isset($_SESSION['usuario'])){
    echo'
        <script>
            alert("Por favor inicie sesion");
            window.location = "../index.php";
        </script>
    ';
    session_destroy();
    die();
 }
?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="vista_empresa.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  
    <title>PATPA</title>
</head>
<body class="body_agregar">
    <div class="agregar_articulo">      
        <form action="../../php/consultas_empresas.php"  method="post" enctype="multipart/form-data">
            <h1>Agregar articulo nuevo</h1>
            <br>
            <br>
            <label for="nombre_producto">Nombre del producto: </label>
            
            <input type="text" id="nombre_producto" name="nombre_producto" required>
            <br>
            <br>
            <label for="imagen">Selecionar imagen: </label>
            <input type="file" id="imagen" name="imagen" required>
            <br>
            <br>

            <h4>¿En que categoria pertenece el producto?</h4>   
            <select  name="categoria" required>
                <option selected value="" disabled>Selecionar</option>
                 <?php 
                while($fila_mostrar_categoria = $mostrar_categoria->fetch_assoc()){
                ?>
                <option value="<?php echo $fila_mostrar_categoria['id'];?>"><?php echo $fila_mostrar_categoria['categorias'];?></option>
                <?php 
                    }
                ?> 
            </select>
            <br>
            <br>
            <h4>¿En que sección pertenece el producto?</h4>
            <select  name="seccion" required>
                <option selected value="" disabled>Selecionar</option>
                <?php 
                while($fila_mostrar_seccion = $mostrar_seccion->fetch_assoc()){
                ?>
                <option value="<?php echo $fila_mostrar_seccion['id'];?>"><?php echo $fila_mostrar_seccion['nombre'];?></option>
                <?php 
                 }
                ?>
            </select>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Nueva Seccion
            </button>
            <br>
            <br>
                <label for="descripcion">Descripcion: </label>
                <br>
                <textarea name="descripcion" id="descripcion" class="agregar_articulo_descripcion" cols="70" rows="5" required></textarea>
                

            <br>
            <br>
            <label for="agregar_articulo_precio" >
                Precio:
            </label>
            <input type="number" id="agregar_articulo_precio" name="precio" required>
            <br>
            <br>
            <a href="../usuarios/usuario_empresa.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button></a>
             <button type="submit" class="btn btn-primary" name="agregar_articulo">Guardar</button> 

        </form>
        <!-- Inicio para agregar nueva seccion -->
                     <!-- Button trigger modal -->

                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva secccion</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="../../php/consultas_empresas.php" method="post" >
                                        <label for="nombre_nueva_seccion">Nombre: </label>
                                        <textarea name="nueva_seccion_nombre" id="nombre_nueva_seccion" cols="50" rows="2" required></textarea>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" name="nueva_seccion" class="btn btn-primary">Guardar</button>  
                                    </form>
                                </div>
                            </div>  
                        </div>
                    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    

</body>

</html>