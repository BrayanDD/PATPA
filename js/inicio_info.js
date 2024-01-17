//CUANDO SE LES DA CLICK A UN ARTICULO O EMPRESA
var Todos_productos = document.querySelectorAll(".producto");
var empresas = document.querySelectorAll(".local");

//CLICK AL BOTON DE CERRAR CUANDO YA SE DESPLEGÓ LA INFO
document.querySelector(".cerrar-articulo").addEventListener("click", cerrarArticulo);
document.querySelector(".cerrar-empresa").addEventListener("click", cerrarEmpresa);

//DESPLEGAR INFO
var articulo = document.querySelector(".mostrar_informacion");
var empresa_info = document.querySelector(".mostrar_informacion_empresa");
var footer = document.querySelector("footer");

//BUSCAR TODOS LOS PRODUCTOS Y ADICIONARLES UN EVENTO
Todos_productos.forEach(function (articulo) {
  articulo.addEventListener("click", function (evento) {
    mostrar(evento);
  });
});

//BUSCAR TODaS LAS EMPRESAS Y ADICIONARLES UN EVENTO
empresas.forEach(function (empresa) {
  empresa.addEventListener("click", function (evento) {
    mostrar_empresa(evento);
  });
});

//CUANDO SE LE DA CLICK A UNA EMPRESA
function mostrar_empresa(evento) {
  
  var idEmpresa = evento.currentTarget.getAttribute('data-id');

  window.location.href = "../content/empresas/vista_empresa.php?id_empresa="+ idEmpresa;

}

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
        $('.imagen_articulo_informacion img').attr('src', '../' + info.imagen);
        $('#empresa').text(info.nombre_empresa);
        $('.informacion_empresa img').attr('src', '../' + info.foto_empresa);
        $('.descripcion p').text(info.descripcion);
        $('.articulo').val(info.id);


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

function cerrarEmpresa() {
  empresa_info.style.opacity = "0";
  footer.style.visibility = "visible";
  setTimeout(function () {
    empresa_info.style.visibility = "hidden";
  }, 5);
}
