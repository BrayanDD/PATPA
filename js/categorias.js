$(document).ready(function() {

    //CUANDO SE LES DA CLICK A UN ARTICULO 
var Todos_productos = document.querySelectorAll(".articulos");

//CLICK AL BOTON DE CERRAR CUANDO YA SE DESPLEGÓ LA INFO
document.querySelector(".cerrar-articulo").addEventListener("click", cerrarArticulo);


//DESPLEGAR INFO
var articulo = document.querySelector(".mostrar_informacion");

var footer = document.querySelector("footer");

//BUSCAR TODOS LOS PRODUCTOS Y ADICIONARLES UN EVENTO
Todos_productos.forEach(function (articulo) {
  articulo.addEventListener("click", function (evento) {
    mostrar(evento);
  });
});



//CUANDO SE LE DA CLICK A UN PRODUCTO
function mostrar(evento) {
  articulo.style.visibility = "visible";
  setTimeout(function () {
    articulo.style.opacity = "1";
  }, 4);
  footer.style.visibility = "hidden";
  var idArticulo = evento.currentTarget.getAttribute('data-id');

  $.ajax({
    url: '/patpa/php/consultas_inicio.php',
    type: 'POST',
    async: true,
    data: { idArticulo: idArticulo },
    success: function (response) {
      console.log(response);
      if (response != 'error') {
        var info = JSON.parse(response);
        console.log(info);
        $('.mostrar_informacion h1').text(info.nombre);
        $('.precio ').text('$' + info.precio);
        $('.mostrar_informacion h5').text(info.nombre_categoria);
        $('.imagen_articulo_informacion img').attr('src', '../../' + info.imagen);
        $('#empresa').text(info.nombre_empresa);
        $('.informacion_empresa img').attr('src', '../../' + info.foto_empresa);
        $('.descripcion p').text(info.descripcion);

      }
    },
    error: function (error) {
      console.log(error);
    }
  });

}

function cerrarArticulo() {
  articulo.style.opacity = "0";
  footer.style.visibility = "visible";
  setTimeout(function () {
    articulo.style.visibility = "hidden";
  }, 5);
}

document.getElementById("selectCategorias").addEventListener("change", function() {
  // Obtener el valor seleccionado
  var selectedCategoryId = this.value;

  // Redirigir a la página de categorías con el ID de la categoría seleccionada
  if (selectedCategoryId) {
      window.location.href = "categorias_buscar.php?id_categoria=" + selectedCategoryId;
  }
});


//PAGINACION
var categoriaId = document.getElementById("categoria_pagina").value;
document.getElementById("anterior").addEventListener("click", function() {
  var pagina = document.getElementById("numero_pagina").innerText;
  if (pagina > 1) {
      var nuevaPagina = parseInt(pagina) - 1;
      console.log(nuevaPagina);
      cargarArticulosPorPagina(nuevaPagina);
  }
});

document.getElementById("siguiente").addEventListener("click", function() {
  var pagina = document.getElementById("numero_pagina").innerText;
  
  var nuevaPagina = parseInt(pagina) + 1;
  console.log(nuevaPagina);
  cargarArticulosPorPagina(nuevaPagina);
});

function cargarArticulosPorPagina(pagina) {
  $.ajax({
      url: '/patpa/php/consultas_categorias.php',
      type: 'POST',
      async: true,
      data: { pagina: pagina,
        categoriaId: categoriaId },
      success: function(response) {
          console.log(response);
          if (response.trim() !== '') {
            try {
                var jsonData = JSON.parse(response);
                console.log(jsonData);
                
                document.getElementById("numero_pagina").innerText = pagina;
                //referencia  "categoria"
                var categoriaElement = document.querySelector('.categoria');

                // Limpiar 
                categoriaElement.innerHTML = '';

                // Iterar sobre los elementos en la respuesta JSON
                jsonData.forEach(function(articulo) {
                    // Crear un nuevo elemento div con la clase "articulos"
                    var nuevoArticulo = document.createElement('div');
                    nuevoArticulo.className = 'articulos';
                    nuevoArticulo.setAttribute('data-id', articulo.id);

                    // Construir el contenido interno del nuevo artículo
                    nuevoArticulo.innerHTML = `
                        <div class="imagen_articulo">
                            <img src="../../${articulo.imagen}" alt="">
                        </div>
                        <div class="informacion_articulo">
                            <h2>${articulo.nombre}</h2>
                            <h4>${articulo.nombre_empresa}</h4>
                            <p>${articulo.nombre_categoria}</p>
                            <button>Detalles</button>
                        </div>
                    `;

                    // Agregar el nuevo artículo a la sección de "categoria"
                    categoriaElement.appendChild(nuevoArticulo);
                });
              
                } catch (error) {
                    console.error('Error al parsear la respuesta JSON:', error);
                }
            } else {
                console.log('La respuesta del servidor está vacía.');
            }
        },
      },
  )}
  });






