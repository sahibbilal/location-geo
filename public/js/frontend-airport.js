
// setTimeout(function (){
    initializeMap();
// }, 3000);
function initializeMap() {
    setTimeout(function (){
        var from_lat    =  Number(document.getElementById("from_lat").value);
        var from_lng    = Number(document.getElementById("to_lng").value);
        const directionsRenderer = new google.maps.DirectionsRenderer();
        const directionsService = new google.maps.DirectionsService();

        const map = new google.maps.Map(document.getElementById("airtport-map"), {
            zoom: 14,
            center: {
                lat: from_lat,
                lng: from_lng
            },
        });
        directionsRenderer.setMap(map);
        calculateAndDisplayRoute(directionsService, directionsRenderer);
    }, 3000);
}

function calculateAndDisplayRoute(directionsService, directionsRenderer) {

    var from_lat    = Number(document.getElementById("from_lat").value);
    var from_lng    = Number(document.getElementById("from_lng").value);
    var to_lat      = Number(document.getElementById("to_lat").value);
    var to_lng      = Number(document.getElementById("to_lng").value);

    directionsService.route({
        origin: { lat: from_lat, lng: from_lng },
        destination: { lat: to_lat, lng: to_lng },
        travelMode: google.maps.TravelMode['DRIVING'],
    })
    .then((response) => {
        directionsRenderer.setDirections(response);
    })
    .catch((e) => window.alert("Directions request failed due to " + status));
}
