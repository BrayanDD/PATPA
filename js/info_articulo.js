document.querySelector(".articulos").addEventListener("click", mostrar);
document.querySelector(".cerrar_informacion").addEventListener("click", cerrar);

var articulo = document.querySelector(".mostrar_informacion");
var footer = document.querySelector("footer");


// VISTA EMPRESA
document.querySelector(".menu_inventario").addEventListener("click", mostrar);

document.querySelector(".cerrar_informacion_articulo").addEventListener("click", cerrar);
var articulo_empresa = document.querySelector(".informacion_articulo");


function mostrar(){
    articulo_empresa.style.visibility = "visible";

    articulo.style.visibility = "visible";
    setTimeout(function() {
        articulo_empresa.style.opacity = "1"; 
      
        articulo.style.opacity = "1"; 
      }, 4);
    footer.style.visibility = "hidden";
    
  
}

function cerrar(){
  articulo_empresa.style.opacity = "0"; 

  articulo.style.opacity = "0"; 

  footer.style.visibility = "visible";
  setTimeout(function() {
    articulo_empresa.style.visibility = "hidden";

    articulo.style.visibility = "hidden";
  }, 5);
  

}