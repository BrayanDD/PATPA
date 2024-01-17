// VISTA EMPRESA

var elementosMenuInventario = document.querySelectorAll(".menu_inventario");
var articulo_empresa = document.querySelector(".informacion_articulo");
var urlOriginal = window.location.href;

document.querySelector(".cerrar_informacion_articulo").addEventListener("click", cerrar_articulo);

elementosMenuInventario.forEach(function(articulo) {
  articulo.addEventListener("click", function(evento) {
    mostrar_articulo(evento);
  });
});


function mostrar_articulo(evento) {
  articulo_empresa.style.visibility = "visible";

  setTimeout(function() {
    articulo_empresa.style.opacity = "1";
  }, 4);

  // Usuario empresa para poder editar
  var idArticulo = evento.currentTarget.getAttribute('data-id');
  // var ruta_actual = new URLSearchParams(window.location.search);
  // ruta_actual.set('articulo_id', idArticulo);
  // var nuevaURL = window.location.pathname + '?' + ruta_actual.toString();
  // window.history.replaceState({}, '', nuevaURL);
  $.ajax({
    url: '/patpa/php/consultas_empresas.php', 
    type: 'POST',
    async: true,
    data: {idArticulo: idArticulo},    
    success: function(response) {
      console.log(response);
      if(response != 'error'){
        var info = JSON.parse(response);
        console.log(info);
        $('.cabeza h2').text(info.nombre);
        $('.descripcion_pedido h3').text('$'+ info.precio);
        $('.descripcion_pedido p').text(info.descripcion);
        $('#articulo_id_consulta').val(info.id);
        $('.formulario_acciones .articulo').val(info.id);

        $('.contenido img').attr('src', '../../' + info.imagen);
        



      }
    },
    error: function(error) {
      console.log(error);
    }
  });
  

}

function cerrar_articulo() {
  articulo_empresa.style.opacity = "0";
  window.history.pushState({}, '', urlOriginal);

  setTimeout(function() {
    articulo_empresa.style.visibility = "hidden";
  }, 5);
}


const estrellas = document.querySelectorAll(".estrella");
const calificacion = document.querySelector(".calificacion");

estrellas.forEach(function (estrella) {
  estrella.addEventListener("click", function () {
    calificacion.setAttribute("data-calificacion", this.getAttribute("data-valor"));
    actualizarCalificacion();
  });
});

function actualizarCalificacion() {
  const valorCalificacion = calificacion.getAttribute("data-calificacion");
  estrellas.forEach(function (estrella) {
    estrella.classList.remove("active");
  });

  for (let i = 0; i < valorCalificacion; i++) {
    estrellas[i].classList.add("active");
  }
}

// CALIFICACION Y COMENTARIO
$(".estrella").click(function () {
  const valor = $(this).data("valor");
  $(".calificacion").attr("data-calificacion", valor);
  $("#calificacionSeleccionada").val(valor);
  actualizarCalificacion();
});


$("#enviarComentario").click(function () {
  // Obtener la calificación seleccionada
  var calificacion = $(".calificacion").data("calificacion");

  // Obtener el comentario
  var comentario = $("textarea[name='comentario']").val();
  var empresa_id = $("#empresa_id").val();
  if (calificacion === 0 || comentario.length < 15) {
    alert("Por favor, selecciona una calificación y asegúrate de que tu comentario tenga al menos 15 caracteres.");
    return;
}
 console.log(calificacion);
 console.log(comentario);
  $.ajax({
      type: "POST",
      url: "../../php/calificacion_y_comentario.php", 
      data:{ calificacion: calificacion,
            comentario: comentario,
            empresa_id: empresa_id
      },
      success: function (response) {
        console.log(response)
        if(response != 'denegado'){
          alert ("Se agrego con exito el comentario");
          location.reload();

          
        }else{alert ("Debes tener minimo 1 compra con esta empresa para comentar");
        location.reload();
      }
      }
  });
});