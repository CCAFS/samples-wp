/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var map;
var markerCluster;
var markerArray = [];
//var marker=[];
var infowindows = [];
var myLatlng = new google.maps.LatLng(12.968888, 10.138147);

function onchangeSubmit() {
//  jQuery("#filtersh").submit();
  reloadMap();
  jQuery('#resulttable_soils').dataTable({
    destroy: true,
    'scrollX': true,
//      'jQueryUI': true,
    "processing": true,
    "serverSide": true,
    searching: false,
    ordering: false,
    "ajax": {
      url: templatePath + "/dataTableFilter.php",
      data: function(d) {
        d.region = jQuery('#region').val();
        d.country = jQuery('#country').val();
        d.ipcc1996 = jQuery('#ipcc1996').val();
        d.ipcc2006 = jQuery('#ipcc2006').val();
        d.soils = '1';
      },
      dataSrc: function(json) {
        if (json.data.length == 0) {
//          $("#tab_soils").hide();
        }
        return json.data;
      }
    }
  });
}

function markerClick(id) {
  jQuery('#markers_content').hide();
  jQuery('#markers_detail_' + id).show();
}

function markerBack(id) {
  jQuery('#markers_detail_' + id).hide();
  jQuery('#markers_content').show();
}

function HomeControl(controlDiv, map) {
  controlDiv.style.padding = '5px';
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = '#fff';
  controlUI.style.border = '2px solid #fff';
  controlUI.style.borderRadius = '3px';
  controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
  controlUI.style.cursor = 'pointer';
  controlUI.style.marginBottom = '22px';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Set map to initial view';
  controlDiv.appendChild(controlUI);
  var controlText = document.createElement('div');
  controlText.style.color = 'rgb(25,25,25)';
  controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
  controlText.style.fontSize = '16px';
  controlText.style.lineHeight = '38px';
  controlText.style.paddingLeft = '5px';
  controlText.style.paddingRight = '5px';
  controlText.innerHTML = '<b>Home<b>'
  controlUI.appendChild(controlText);

  // Setup click-event listener: simply set the map to London
  google.maps.event.addDomListener(controlUI, 'click', function() {
    map.setCenter(myLatlng);
    map.setZoom(2);
  });
}

function initialize() {

  var mapOptions = {
    zoom: 2,
    center: myLatlng
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  // Create a DIV to hold the control and call HomeControl()
  var homeControlDiv = document.createElement('div');
  var homeControl = new HomeControl(homeControlDiv, map);
//  homeControlDiv.index = 1;
  map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
  var script = document.createElement('script');
  script.src = templatePath + "/dataMapFilter.php?" + jQuery('#filtersh').serialize();
  document.getElementsByTagName('head')[0].appendChild(script);

  window.eqfeed_callback = function(results) {

    var infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < results.features.length; i++) {
      var coords = results.features[i].geometry.coordinates;
      var latLng = new google.maps.LatLng(coords[0], coords[1]);
      var marker = new google.maps.Marker({
        position: latLng,
        title: results.features[i].properties.type + '-' + i
      });
      infowindows[i] = "<div id='contm" + i + "'><b>" + results.features[i].properties.type + "</b><br>Gas:" + results.features[i].properties.gas + '<br> \n\
                        ' + results.features[i].properties.type + ' emissions:\n\
                          <ul>\n\
                            <li>' + results.features[i].properties.value1 + '</li>\n\
                            <li>' + results.features[i].properties.ef_value + '</li>\n\
                            <li>' + results.features[i].properties.ef_units + '</li>\n\
                          </ul>\n\
                        </div>';
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.close();
        infowindow.setContent(infowindows[i]);
        infowindow.open(map, this);
      });
      markerArray.push(marker);
    }
    markerCluster = new MarkerClusterer(map, markerArray);
    google.maps.event.addListener(markerCluster, "mouseover", function(c) {
//        log("mouseover: ");
//        log("&mdash;Center of cluster: " + c.getCenter());
      // Convert lat/long from cluster object to a usable MVCObject
      var info = new google.maps.MVCObject;
      info.set('position', c.getCenter());
      clusters = c.getMarkers();
      content = "<div id='markers_content'>";
      for (var i = 0; i < clusters.length; i++) {
        content += "<div id='marker_" + i + "' class='markerOver' onclick='markerClick(" + i + ")'><img src='" + templatePath + "/img/soil_icon.png' height='20' width='20' onclick='markerBack(" + i + ")' align='left' style='cursor:pointer'>" + clusters[i].getTitle().split('-')[0] + (parseInt(clusters[i].getTitle().split('-')[1]) + 1) + '</div>';
      }
      content += "</div>";

      for (var i = 0; i < clusters.length; i++) {
        contentid = clusters[i].getTitle().split('-')[1];
        content += "<div id='markers_detail_" + i + "' style='display:none'>";
        content += "<div><img src='" + templatePath + "/img/back_row.png' height='20' width='20' onclick='markerBack(" + i + ")' style='cursor:pointer'></div>";
        content += infowindows[contentid];
        content += "</div>";
      }
      infowindow.close();
      infowindow.setContent(content);
      infowindow.setZIndex(9999);
      infowindow.open(map, info);
    });

    google.maps.event.addListener(markerCluster, "click", function(c) {
      infowindow.close();
    });
    google.maps.event.addListener(map, "click", function() {
      infowindow.close();
//        markeri.setMap(null);
    });
  }

}
google.maps.event.addDomListener(window, 'load', initialize);

function reloadMap() {
  markerCluster.removeMarkers(markerArray);
  markerArray = [];
  var script = document.createElement('script');
  script.src = templatePath + "/dataMapFilter.php?" + jQuery('#filtersh').serialize();
  document.getElementsByTagName('head')[0].appendChild(script);

  window.eqfeed_callback = function(results) {

    var infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < results.features.length; i++) {
      var coords = results.features[i].geometry.coordinates;
      var latLng = new google.maps.LatLng(coords[0], coords[1]);
      var marker = new google.maps.Marker({
        position: latLng,
        title: results.features[i].properties.type + '-' + i
      });
      infowindows[i] = "<div id='contm" + i + "'><b>" + results.features[i].properties.type + "</b><br>Gas:" + results.features[i].properties.gas + '<br> \n\
                        ' + results.features[i].properties.type + ' emissions:\n\
                          <ul>\n\
                            <li>' + results.features[i].properties.value1 + '</li>\n\
                            <li>' + results.features[i].properties.ef_value + '</li>\n\
                            <li>' + results.features[i].properties.ef_units + '</li>\n\
                          </ul>\n\
                        </div>';
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.close();
        infowindow.setContent(infowindows[i]);
        infowindow.open(map, this);
      });
      markerArray.push(marker);
    }
    markerCluster = new MarkerClusterer(map, markerArray);
    google.maps.event.addListener(markerCluster, "mouseover", function(c) {
//        log("mouseover: ");
//        log("&mdash;Center of cluster: " + c.getCenter());
      // Convert lat/long from cluster object to a usable MVCObject
      var info = new google.maps.MVCObject;
      info.set('position', c.getCenter());
      clusters = c.getMarkers();
      content = "<div id='markers_content'>";
      for (var i = 0; i < clusters.length; i++) {
        content += "<div id='marker_" + i + "' class='markerOver' onclick='markerClick(" + i + ")'><img src='" + templatePath + "/img/soil_icon.png' height='20' width='20' onclick='markerBack(" + i + ")' align='left' style='cursor:pointer'>" + clusters[i].getTitle().split('-')[0] + (parseInt(clusters[i].getTitle().split('-')[1]) + 1) + '</div>';
      }
      content += "</div>";

      for (var i = 0; i < clusters.length; i++) {
        contentid = clusters[i].getTitle().split('-')[1];
        content += "<div id='markers_detail_" + i + "' style='display:none'>";
        content += "<div><img src='" + templatePath + "/img/back_row.png' height='20' width='20' onclick='markerBack(" + i + ")' style='cursor:pointer'></div>";
        content += infowindows[contentid];
        content += "</div>";
      }
      infowindow.close();
      infowindow.setContent(content);
      infowindow.setZIndex(9999);
      infowindow.open(map, info);
    });

    google.maps.event.addListener(markerCluster, "click", function(c) {
      infowindow.close();
    });
    google.maps.event.addListener(map, "click", function() {
      infowindow.close();
//        markeri.setMap(null);
    });
  }
}

$(document).ready(function($) {
  //$("#tabs").tabs();

  $('#resulttable_soils').dataTable({
    'scrollX': true,
//      'jQueryUI': true,
    "processing": true,
    "serverSide": true,
    searching: false,
    ordering: false,
    "ajax": {
      url: templatePath + "/dataTableFilter.php",
      data: function(d) {
        d.region = $('#region').val();
        d.country = $('#country').val();
        d.ipcc1996 = $('#ipcc1996').val();
        d.ipcc2006 = $('#ipcc2006').val();
        d.soils = '1';
      },
      dataSrc: function(json) {
        if (json.data.length == 0) {
//          $("#tab_soils").hide();
        }
        return json.data;
      }
    }
  });

  $('#region').select2({
    placeholder: "Search for a region",
    allowClear: true,
    width: 'off',
    ajax: {
      url: templatePath + "/dataSelectFilter.php",
      dataType: 'json',
      data: function(term, page) { // page is the one-based page number tracked by Select2
        return {
          region: term,
          option: 1
        };
      },
      results: function(data) {
        return {results: data};
      }
    },
  });

  $('#country').select2({
    placeholder: "Search for a country",
//    minimumInputLength: 3,
    ajax: {
      url: templatePath + "/dataSelectFilter.php",
      dataType: 'json',
      data: function(term, page) { // page is the one-based page number tracked by Select2
        return {
          country: term, //search term
          region: $("#region").val(),
          option: 2,
          page: page // page number
        };
      },
      results: function(data) {
        return {results: data};
      }
    }
  });

  $('#ipcc1996').select2({
    placeholder: "Select a value",
    allowClear: true
  });

  $('#ipcc2006').select2({
    placeholder: "Select a value",
    allowClear: true
  });

  $('#source').select2({
    placeholder: "Select a value",
    allowClear: true
  });

  $("#reset").on("click", function() {
    $('.js-data-ajax').select2('data', null);
    onchangeSubmit();
//    $('.js-data-ajax').val(null).trigger("change");
  });

  var menu = $('#filtersh');
//  var contenedor = $('#menu-contenedor');
  var menu_offset = menu.offset();
  // Cada vez que se haga scroll en la página
  // haremos un chequeo del estado del menú
  // y lo vamos a alternar entre 'fixed' y 'static'.
  $(window).on('scroll', function() {
    if ($(window).scrollTop() > menu_offset.top) {
      menu.addClass('menu-fijo');
    } else {
      menu.removeClass('menu-fijo');
    }
  });

});
