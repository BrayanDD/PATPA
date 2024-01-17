$(document).ready(function() {

    //CUANDO SE LES DA CLICK A UN ARTICULO 
var Todos_empresa = document.querySelectorAll(".empresa");







//BUSCAR TODOS LOS PRODUCTOS Y ADICIONARLES UN EVENTO
Todos_empresa.forEach(function (empresa) {
  empresa.addEventListener("click", function (evento) {
    mostrar(evento);
  });
});



//CUANDO SE LE DA CLICK A UN PRODUCTO
function mostrar(evento) {
  var empresaId = evento.currentTarget.dataset.id;
  window.location.href = "vista_empresa.php?id_empresa=" + empresaId;
}


document.getElementById("selectCategorias").addEventListener("change", function() {
  // Obtener el valor seleccionado
  var selectedCategoryId = this.value;

  // Redirigir a la página de categorías con el ID de la categoría seleccionada
  if (selectedCategoryId) {
      window.location.href = "empresa_buscar.php?id_categoria=" + selectedCategoryId;
  }
});

;


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
      url: '/patpa/php/consultas_empresas.php',
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
                jsonData.forEach(function(empresa) {
                    // Crear un nuevo elemento div con la clase "articulos"
                    var nuevoEmpresa = document.createElement('div');
                    nuevoEmpresa.className = 'articulos';
                    nuevoEmpresa.setAttribute('data-id', empresa.id);

                    // Construir el contenido interno del nuevo artículo
                    nuevoEmpresa.innerHTML = `
                        <div class="imagen_articulo">
                            <img src="../../${empresa.foto}" alt="">
                        </div>
                        <div class="informacion_articulo">
                            <h2>${empresa.usuario}</h2>
                            <h4>${empresa.nombre_categoria}</h4>
                            <p>${empresa.direccion}</p>
                            <button>Detalles</button>
                        </div>
                    `;

                    // Agregar el nuevo artículo a la sección de "categoria"
                    categoriaElement.appendChild(nuevoEmpresa);
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






