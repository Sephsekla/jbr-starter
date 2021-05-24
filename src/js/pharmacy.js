$ = jQuery;

import 'select2';

const markerIcon = 'data:image/svg+xml;utf-8,' + encodeURIComponent(`
<svg width="18px" height="25px" viewBox="0 0 18 25" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <title>location-pin</title>
    <defs>
        <path d="M870,787 C874.970563,787 879,790.997457 879,795.928571 C879,800.859686 870,812 870,812 C870,812 861,800.859686 861,795.928571 C861,790.997457 865.029437,787 870,787 Z M870,792.357143 C868.011775,792.357143 866.4,793.956126 866.4,795.928571 C866.4,797.901017 868.011775,799.5 870,799.5 C871.988225,799.5 873.6,797.901017 873.6,795.928571 C873.6,793.956126 871.988225,792.357143 870,792.357143 Z" id="path-1"></path>
    </defs>
    <g id="Desktop" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="3.0-Patient-Resources" transform="translate(-861.000000, -5013.000000)">
            <g id="Pharmacy-Locator" transform="translate(0.000000, 4226.000000)">
                <mask id="mask-2" fill="white">
                    <use xlink:href="#path-1"></use>
                </mask>
                <use id="location-pin" fill="#4A90E2" xlink:href="#path-1"></use>
            </g>
        </g>
    </g>
</svg>`);

export default function initPharmacy() {
    var app = {}
    app.$pharmacyfinder = $('.pharmacy-finder');
    app.$pharmacyList = $('.pharmacy-list');

    app.$markers = [];

    $(document).ready(function () {
        const options = {
            minimumResultsForSearch: -1
        };

        $('#pharmacy_name').select2(options);
        $('#state').select2(options);

        $(document).on('click', 'p.map a', app.focusMarkerClick)
    })

    app.getParameterByName = function (name, url = window.location.href) {
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    };

    app.initPharmacySearch = function () {

        app.$pharmacySearchState = app.$pharmacyfinder.find('select[name=state]');
        app.$pharmacySearchName = app.$pharmacyfinder.find('select[name=pharmacy_name]');

        app.urlState = app.getParameterByName('st');
        app.urlPharmacy = app.getParameterByName('pn');
        app.scroll = false;
        if (app.urlState !== null) {
            app.scroll = true;
            app.$pharmacySearchState.val(app.urlState);
        }
        if (app.urlPharmacy !== null) {
            app.scroll = true;
            app.$pharmacySearchName.val(app.urlPharmacy);
        }

        if (app.scroll) {
            const speed = 800;
            const scrollOffset = $('header.site-header').height();

            app.scrollTo = $('#pharmacylistings');
            if (app.scrollTo.length > 0) {
                setTimeout(function () {
                    $('html, body').animate({scrollTop: app.scrollTo.offset().top - scrollOffset}, speed);
                }, 500);
            }
        }

        app.pharmSearch(app.$pharmacySearchState.val(), app.$pharmacySearchName.find('option:selected').text(), app.$pharmacySearchName.val());

        app.$pharmacySearchName.on('change', function () {
            app.pharmSearch(app.$pharmacySearchState.val(), app.$pharmacySearchName.find('option:selected').text(), app.$pharmacySearchName.val());
        });
        app.$pharmacySearchState.on('change', function () {
            app.pharmSearch(app.$pharmacySearchState.val(), app.$pharmacySearchName.find('option:selected').text(), app.$pharmacySearchName.val());
        });

    };

    app.pharmSearch = function (state, name, term_id) {

        var pharmData = {
            'action': 'ff_get_pharmacy_search',
            'security': ajaxData.security,
            'term_id': term_id,
            'pharmacyname': name,
            'state': state
        };

        app.api_call(pharmData, 'text', function (results) {
            var listing = (results !== false) ? results : '<li class="empty">No Results</li>';
            app.$pharmacyList.html(listing);
            app.setupPharmacyMap()
        }, function (error) {
            console.log('error');
            console.log(error);
        });

    };

    app.api_call = function (data, dataType, successFunction, errorFunction) {

        var $validationApiCall = $.ajax({
            url: ajaxData.ajaxUrl,
            type: "POST",
            data: data,
            dataType: dataType
        });

        $.when($validationApiCall).then(
            function (results) {
                if (results !== '') {
                    successFunction(results)
                } else {
                    successFunction(false);
                }
            },
            function (error) {
                errorFunction(error);
            });
        return false;
    };

    if (app.$pharmacyfinder.length > 0) {
        app.initPharmacySearch();
    }

    app.setupPharmacyMap = function () {
        app.initMap()
    }

    app.initMap = function () {
        // app.markerBounds = new google.maps.LatLngBounds();
        var i = 0;

        var emptyResults = false;
        var initLoad = new google.maps.LatLng(40.712784, -74.005941);
        app.$gmap = new google.maps.Map(document.getElementById('map_pharmacy'), {
            zoom: 8,
            center: initLoad,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        });

        if (app.$pharmacyList.find('li').length > 0) {
            $.each(app.$pharmacyList.find('li'), function () {
                var lat = $(this).data('lat');
                var long = $(this).data('long');
                var url = $(this).find('p.map a').attr('href');

                if ($(this).hasClass('empty')) {
                    emptyResults = true;
                    return;
                }

                if (Math.sign(lat) === 0 || Math.sign(long) === 0) {
                    return;
                }

                var latLng = new google.maps.LatLng(lat, long);
                var markerCount = i;

                app.$markers[i] = new google.maps.Marker({
                    position: latLng,
                    map: app.$gmap,
                    icon: markerIcon,
                    url: url
                });

                google.maps.event.addListener(app.$markers[i], 'click', function() {
                    window.open(this.url)
                });

                i++;
                //app.markerBounds.extend(app.$markers[i].getPosition());
            })

            //app.$gmap.addMarker(app.$markers[i]);
            if (!emptyResults) {
                setTimeout(function () {
                    app.focusMarker(0) //load first in list
                }, 1000)
            }
        }


        $(window).on('resize', function () {
            app.mapResize()
        });
        app.mapResize();
    };

    app.focusMarker = function (count) {
        app.markerBounds = new google.maps.LatLngBounds();

        app.markerBounds.extend(app.$markers[count].getPosition());
        app.$gmap.fitBounds(app.markerBounds);
        app.$gmap.setZoom(15)
    }

    app.focusMarkerClick = function (e) {
        e.preventDefault();

        var c = $(this).data('count');

        if (typeof app.$markers[c] !== "undefined") {
            app.focusMarker(c)
        }
    };

    app.addMarker = function (location, map) {
        // Add the marker at the clicked location, and add the next-available label
        // from the array of alphabetical characters.
        new google.maps.Marker({
            position: location,
            label: labels[labelIndex++ % labels.length],
            map: map,
        });
    }

    app.mapResize = function () {

        var mapE = $('#map_canvas');
        var mapeW = mapE.parent().width();
        var mapeH = mapE.parent().height();

        mapE.css({
            'width': mapeW,
            'height': mapeH
        });

    };
}
