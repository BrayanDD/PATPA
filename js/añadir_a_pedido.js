
var pedir_agregar = document.querySelectorAll('.pedir');


pedir_agregar.forEach(function (btn) {
    btn.addEventListener("click", function (evento) {
      pedir_agre(evento);
    });
  });

function pedir_agre(evento){
    var formulario = evento.target.closest('.formulario_acciones'); // Buscar el formulario más cercano al botón
    var id_producto = formulario.querySelector('.articulo').value;
    var cantidad = formulario.querySelector('#cantidad').value;
    console.log(id_producto);
    console.log(cantidad);
     $.ajax({
        url: '/patpa/php/añadir_pedido.php',
         type: 'POST',
         async: true,
         data: { id_producto: id_producto,
                cantidad: cantidad },
        success: function (response) {
            alert('Producto añadido a pedidos con éxito');
         },
        error: function (error) {
           console.log(error);
         }
       });

//Cambiar la cantidad
var actualizarBotones = document.querySelectorAll('.actualizar_carrito');

        actualizarBotones.forEach(function (boton) {
            boton.addEventListener('click', function (evento) {
                actualizarCantidad(evento);
            });
        });

        function actualizarCantidad(evento) {
            var nuevaCantidad = evento.target.parentElement.querySelector('.cantidad').value;
            var id_articulo = evento.target.getAttribute('data-id');


            // Hacer la solicitud AJAX
            $.ajax({
                url: '/patpa/php/consultas_carrito.php',
                type: 'POST',
                async: true,
                data: {
                    id_articulo: id_articulo,
                    nueva_cantidad: nuevaCantidad
                },
                success: function (response) {
                    console.log(response);
                    // Aquí puedes manejar la respuesta, por ejemplo, mostrar un mensaje de éxito.
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

}

