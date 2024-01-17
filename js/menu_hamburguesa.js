document.querySelector(".bar_menu").addEventListener("click", animate_bar);
document.querySelector(".bar_menu").addEventListener("click", mostrar);
document.querySelector(".cerrar_informacion").addEventListener("click", cerrar);

var linea1_bar = document.querySelector(".linea1_bar_menu");
var linea2_bar = document.querySelector(".linea2_bar_menu");
var linea3_bar = document.querySelector(".linea3_bar_menu");
var nav = document.querySelector(".container_header");
var cerrar = document.querySelector(".cerrar_informacion");

function animate_bar(){
    linea1_bar.classList.toggle("activelinea1_bar_menu");
    linea2_bar.classList.toggle("activelinea2_bar_menu");
    linea3_bar.classList.toggle("activelinea3_bar_menu");
    
}
function cerrar_animate(){
    setTimeout(function() {
        linea1_bar.style.transform = "";
        linea2_bar.style.opacity = "";
        linea2_bar.style.marginLeft = "";
        linea3_bar.style.transform = "";
    }, 1000);
}


function mostrar(){
    
        nav.style.opacity = "1"; 
        nav.style.visibility = "visible";
        cerrar.style.visibility = "visible";
  
}

function cerrar(){
    setTimeout(function() {
        nav.style.opacity = "0";
        nav.style.visibility = "hidden";
        linea1_bar.style.transform = "";
        linea2_bar.style.opacity = "";
        linea2_bar.style.marginLeft = "";
        linea3_bar.style.transform = "";
      }, 302);
  

}