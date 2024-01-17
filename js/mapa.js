function iniciarMap() {
    var latitud = parseFloat(document.getElementById('latitud').value);
    var longitud = parseFloat(document.getElementById('longitud').value);

    console.log(latitud);
    console.log(longitud);

    // Verificar si las conversiones son válidas
    if (isNaN(latitud) || isNaN(longitud)) {
        console.error("Error: Las coordenadas no son números válidos.");
        return;
    }

    var coord = { lat: latitud, lng: longitud };

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 20,
        center: coord
    });

    var marker = new google.maps.Marker({
        position: coord,
        map: map
    });
}
