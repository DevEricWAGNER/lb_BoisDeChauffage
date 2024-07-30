<!DOCTYPE html>
<html>
<head>
    <title>Autocomplete Address</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #address-list {
            display: none;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background: #fff;
            z-index: 1000;
        }
        #address-list option {
            padding: 5px;
            cursor: pointer;
        }
        #address-list option:hover {
            background-color: #f0f0f0;
        }
        #coordinates {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div style="position: relative;">
        <input type="text" id="address" placeholder="Enter an address">
        <select id="address-list" size="5"></select>
    </div>
    <div id="coordinates">
        <p>Latitude: <span id="latitude"></span></p>
        <p>Longitude: <span id="longitude"></span></p>
        <p>Distance: <span id="distance"></span> km</p>
    </div>

    <script>
        $(document).ready(function() {
            let debounceTimer;
            const targetLat = 48.695160;
            const targetLon = 7.889900;

            $('#address').on('keyup', function() {
                clearTimeout(debounceTimer);

                let query = $(this).val();
                if (query.length > 2) {
                    debounceTimer = setTimeout(function() {
                        $.ajax({
                            url: '/autocomplete',
                            type: 'GET',
                            data: { query: query },
                            success: function(data) {
                                $('#address-list').empty().show();
                                if (Array.isArray(data)) {
                                    data.forEach(function(address) {
                                        $('#address-list').append(
                                            `<option data-lat="${address.lat}" data-lon="${address.lon}" data-address="${address.display_name}">${address.display_name}</option>`
                                        );
                                    });
                                } else {
                                    console.error('La réponse de l\'API n\'est pas au format attendu.');
                                }
                            },
                            error: function(xhr) {
                                console.error('Erreur lors de la requête AJAX:', xhr.responseText);
                            }
                        });
                    }, 1000);
                } else {
                    $('#address-list').empty().hide();
                }
            });

            $('#address-list').on('change', function() {
                let selectedOption = $(this).find('option:selected');
                let address = selectedOption.text();
                let lat = selectedOption.data('lat');
                let lon = selectedOption.data('lon');

                $('#address').val(address);
                $('#latitude').text(lat);
                $('#longitude').text(lon);
                $('#address-list').hide();

                // Calculer la distance routière
                calculateRoadDistance(targetLat, targetLon, lat, lon);
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#address, #address-list').length) {
                    $('#address-list').hide();
                }
            });

            function calculateRoadDistance(lat1, lon1, lat2, lon2) {
                console.log(`https://router.project-osrm.org/route/v1/driving/${lon1},${lat1};${lon2},${lat2}`)
                $.ajax({
                    url: `https://router.project-osrm.org/route/v1/driving/${lon1},${lat1};${lon2},${lat2}`,
                    type: 'GET',
                    success: function(response) {
                        if (response.routes && response.routes.length > 0) {
                            let distance = response.routes[0].distance / 1000; // Distance en km
                            $('#distance').text(distance.toFixed(2));
                        } else {
                            $('#distance').text("Distance non trouvée");
                        }
                    },
                    error: function(xhr) {
                        console.error('Erreur lors de la requête AJAX:', xhr.responseText);
                    }
                });
            }
        });
    </script>
</body>
</html>
