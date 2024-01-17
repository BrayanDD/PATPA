
var pedidos = document.querySelectorAll('.detalles');

var mostrar_articulos = document.querySelector('.informacion_articulo');

pedidos.forEach(function (pedido) {
    pedido.addEventListener("click", function (evento) {
      ver_pedido(evento);
    });
  });

function ver_pedido(evento){
    
    mostrar_articulos.style.visibility = "visible";
    mostrar_articulos.style.opacity = "1";
    setTimeout(function() {
        mostrar_articulos.style.opacity = "1";
      }, 7);

      var info_pedido = evento.currentTarget.closest('tr').querySelector('.id_pedido');
      var id_pedido = info_pedido.textContent;
      console.log(id_pedido);

      $.ajax({
        url: '/patpa/php/consultas_pedidos.php',
        type: 'POST',
        async: true,
        data: { id_pedido: id_pedido },
        success: function (response) {
            var info = JSON.parse(response);
            console.log(info);
    
            // Seleccionar el contenedor de la tabla y el contenedor del precio final
            var informacionArticulo = $(".informacion_articulo .contenido table");
            var precioFinalContainer = $(".informacion_articulo .final h4");
    
            // Limpiar el contenido existente antes de agregar nuevos elementos
            informacionArticulo.empty();
    
            // Crear fila de encabezado
            var encabezado = $("<tr>");
            encabezado.append("<th>Articulo</th>");
            encabezado.append("<th>Imagen</th>");
            encabezado.append("<th>Precio Unitario</th>");
            encabezado.append("<th>Cantidad</th>");
            encabezado.append("<th>Total</th>");
            informacionArticulo.append(encabezado);
    
            // Recorrer los artículos y agregar filas a la tabla
            var precio_final = 0;
    
            info[id_pedido].forEach(function (articulo) {
                // Convertir los valores a números antes de sumar
                var precioUnitario = parseFloat(articulo.precio_articulo);
                var cantidad = parseFloat(articulo.cantidad);
                var totalArticulo = parseFloat(articulo.total);
    
                // Agregar fila a la tabla
                var fila = $("<tr>");
                fila.append("<td>" + articulo.nombre_articulo + "</td>");
                fila.append("<td><img src=../../" + articulo.imagen_articulo + " alt='imagen'></td>");
                fila.append("<td>" + parseInt(precioUnitario) + "</td>");
                fila.append("<td>" + parseInt(cantidad) + "</td>");
                fila.append("<td>" + parseInt(totalArticulo) + "</td>");
                informacionArticulo.append(fila);
    
                // Sumar el total de este artículo al precio_final
                precio_final += totalArticulo;
            });
    
            // Mostrar el precio final como un número entero
            precioFinalContainer.text("Precio Final: $" + parseInt(precio_final));
    
        },
        error: function (error) {
            console.log(error);
        }
    });
    
    
    



}

