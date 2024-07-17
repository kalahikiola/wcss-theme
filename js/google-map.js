(function( $ ) {

    /**
     * initMap
     *
     * Renders a Google Map onto the selected jQuery element
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @return  object The map instance.
     */
    function initMap( $el ) {
    
        // Find marker elements within map.
        var $markers = $el.find('.marker');
    
        // Create generic map with custom styles.
        var mapArgs = {
            zoom        : $el.data('zoom') || 16,
            mapTypeId   : google.maps.MapTypeId.ROADMAP,
            styles: [
                {
                    "stylers": [
                        { "hue": "#bbff00" },
                        { "weight": 0.5 },
                        { "gamma": 0.5 }
                    ]
                },
                {
                    "elementType": "labels",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },
                {
                    "featureType": "landscape.natural",
                    "stylers": [
                        { "color": "#a4cc48" }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                        { "color": "#ffffff" },
                        { "visibility": "on" },
                        { "weight": 1 }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "labels",
                    "stylers": [
                        { "visibility": "on" }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels",
                    "stylers": [
                        { "visibility": "simplified" },
                        { "gamma": 1.14 },
                        { "saturation": -18 }
                    ]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "labels",
                    "stylers": [
                        { "saturation": 30 },
                        { "gamma": 0.76 }
                    ]
                },
                {
                    "featureType": "road.local",
                    "stylers": [
                        { "visibility": "simplified" },
                        { "weight": 0.4 },
                        { "lightness": -8 }
                    ]
                },
                {
                    "featureType": "water",
                    "stylers": [
                        { "color": "#4aaecc" }
                    ]
                },
                {
                    "featureType": "landscape.man_made",
                    "stylers": [
                        { "color": "#718e32" }
                    ]
                },
                {
                    "featureType": "poi.business",
                    "stylers": [
                        { "saturation": 68 },
                        { "lightness": -61 }
                    ]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        { "weight": 2.7 },
                        { "color": "#f4f9e8" }
                    ]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        { "weight": 1.5 },
                        { "color": "#e53013" },
                        { "saturation": -42 },
                        { "lightness": 28 }
                    ]
                }
            ]
        };
        var map = new google.maps.Map( $el[0], mapArgs );
    
        // Add markers.
        map.markers = [];
        $markers.each(function(){
            initMarker( $(this), map );
        });
    
        // Center map based on markers.
        centerMap( map );
    
        // Return map instance.
        return map;
    }
    
    /**
     * initMarker
     *
     * Creates a marker for the given jQuery element and map.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @param   object The map instance.
     * @return  object The marker instance.
     */
    function initMarker( $marker, map ) {
    
        // Get position from marker.
        var lat = $marker.data('lat');
        var lng = $marker.data('lng');
        var latLng = {
            lat: parseFloat( lat ),
            lng: parseFloat( lng )
        };
    
        // Create marker instance.
        var marker = new google.maps.Marker({
            position : latLng,
            map: map
        });
    
        // Append to reference for later use.
        map.markers.push( marker );
    
        // If marker contains HTML, add it to an infoWindow.
        if( $marker.html() ){
    
            // Create info window.
            var infowindow = new google.maps.InfoWindow({
                content: $marker.html()
            });
    
            // Show info window when marker is clicked.
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open( map, marker );
            });
        }
    }
    
    /**
     * centerMap
     *
     * Centers the map showing all markers in view.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   object The map instance.
     * @return  void
     */
    function centerMap( map ) {
    
        // Create map boundaries from all map markers.
        var bounds = new google.maps.LatLngBounds();
        map.markers.forEach(function( marker ){
            bounds.extend({
                lat: marker.position.lat(),
                lng: marker.position.lng()
            });
        });
    
        // Case: Single marker.
        if( map.markers.length == 1 ){
            map.setCenter( bounds.getCenter() );
    
        // Case: Multiple markers.
        } else{
            map.fitBounds( bounds );
        }
    }
    
    // Render maps on page load.
    $(document).ready(function(){
        $('.acf-map').each(function(){
            var map = initMap( $(this) );
        });
    });
    
    })(jQuery);
