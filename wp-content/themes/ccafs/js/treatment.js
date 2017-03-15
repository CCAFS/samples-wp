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
var infowindow;

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
    ordering: true,
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

  jQuery('#fullview').dataTable({
    destroy: true,
    'scrollX': true,
//      'jQueryUI': true,
    "processing": true,
    "serverSide": true,
    searching: false,
    ordering: false,
    "ajax": {
      url: templatePath + "/dataTableFilter.php",
      type: 'POST',
      data: function(d) {
        d.region = jQuery('#region').val();
        d.country = jQuery('#country').val();
        d.ipcc1996 = jQuery('#ipcc1996').val();
        d.ipcc2006 = jQuery('#ipcc2006').val();
        d.soils = '1';
        d.allfields = 'true';
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

//function emissionMoreInfo(id) {
//  infowindow.close();
//  jQuery("#contm" + id).dialog({
//    height: 400,
//    width: 1024,
////      modal: true,
//    buttons: {
//      Cancel: function() {
//        jQuery(this).dialog("close");
//      }
//    }
//  });
//}

function HomeControl(controlDiv, map) {
  controlDiv.style.padding = '5px';
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = '#06A5C6';
  controlUI.style.border = '2px solid #06A5C6';
  controlUI.style.borderRadius = '3px';
  controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
  controlUI.style.cursor = 'pointer';
  controlUI.style.marginBottom = '22px';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Set map to initial view';
  controlDiv.appendChild(controlUI);
  var controlText = document.createElement('div');
  controlText.style.color = 'rgb(255,255,255)';
  controlText.style.fontFamily = 'inherit';
  controlText.style.fontWeight = 'inherit';
  controlText.style.fontSize = '16px';
//  controlText.style.lineHeight = '38px';
  controlText.style.paddingLeft = '5px';
  controlText.style.textTransform = 'uppercase';
  controlText.style.paddingRight = '5px';
  controlText.innerHTML = '<b>Home<b>'
  controlUI.appendChild(controlText);

  // Setup click-event listener: simply set the map to London
  google.maps.event.addDomListener(controlUI, 'click', function() {
    map.setCenter(myLatlng);
    map.setZoom(2);
  });
}

function emissionsBodyBox(result, i) {
  var body;
  if (result.type == 'soil') {
    body = "<div id='contm" + i + "' class='mapbox'>" + ' \n\
              <b>Crop1:</b> ' + result.value2 + '\n\
              <br><b>Treatment description:</b> ' + result.value1 + '\n\
              <br><b>Type of emission factor:</b> ' + result.value3 + '\n\
              <br><b>Value:</b> ' + parseFloat(result.ef_value).toFixed(2) + '\n\
              <br><b>Units:</b> ' + result.ef_units + '\n\
              <br><button type="button" class="pure-button pure-button-primary" data-toggle="modal" data-target="#contmm' + result.sid + '">more info</button>\n\
            </div>';
  } else if (result.type == 'enteric') {
    body = "<div id='contm" + i + "'><b>" + '</b> \n\
              <br><b>Subspecies classification:</b> ' + result.value1 + '\n\
              <br><b>Type of livestock management system:</b> ' + result.value2 + '\n\
              <br><b>Type of emission factor:</b> ' + result.value3 + '\n\
              <br><b>Value:</b> ' + result.ef_value + '\n\
              <br><b>Units:</b> ' + result.ef_units + '\n\
              <br><button type="button" class="pure-button pure-button-primary" data-toggle="modal" data-target="#contmm' + i + '">more info</button>\n\
            </div>';
  } else if (result.type == 'manure') {
    body = "<div id='contm" + i + "'><b>" + '</b> \n\
              <br><b>Subspecies:</b> ' + result.value1 + '\n\
              <br><b>Type of manure management system:</b> ' + result.value2 + '\n\
              <br><b>Type of emission factor:</b> ' + result.value3 + '\n\
              <br><b>Value:</b> ' + result.ef_value + '\n\
              <br><b>Units:</b> ' + result.ef_units + '\n\
              <br><button type="button" class="pure-button pure-button-primary" data-toggle="modal" data-target="#contmm' + i + '">more info</button>\n\
            </div>';
  } else if (result.type == 'grassland') {
    body = "<div id='contm" + i + "'><b>" + '</b> \n\
              <br><b>Description of ecosystem:</b> ' + result.value2 + '\n\
              <br><b>Type of emission factor:</b> ' + result.value1 + '\n\
              <br><b>Value:</b> ' + result.ef_value + '\n\
              <br><b>Units:</b> ' + result.ef_units + '\n\
              <br><button type="button" class="pure-button pure-button-primary" data-toggle="modal" data-target="#contmm' + i + '">more info</button>\n\
            </div>';
  } else if (result.type == 'residue') {
    body = "<div id='contm" + i + "'><b>" + '</b> \n\
              <br><b>Type of crop:</b> ' + result.value2 + '\n\
              <br><b>Type of emission factor:</b> ' + result.value1 + '\n\
              <br><b>Value:</b> ' + result.ef_value + '\n\
              <br><b>Units:</b> ' + result.ef_units + '\n\
              <br><button type="button" class="pure-button pure-button-primary" data-toggle="modal" data-target="#contmm' + i + '">more info</button>\n\
            </div>';
  } else if (result.type == 'biomass') {
    body = "<div id='contm" + i + "'><b>" + '</b> \n\
              <br><b>Type of forest:</b> ' + result.value2 + '\n\
              <br><b>Type of emission factor:</b> ' + result.value1 + '\n\
              <br><b>Value:</b> ' + result.ef_value + '\n\
              <br><b>Units:</b> ' + result.ef_units + '\n\
              <br><button type="button" class="pure-button pure-button-primary" data-toggle="modal" data-target="#contmm' + i + '">more info</button>\n\
            </div>';
  }
  return body;
}

function mapCallBack() {
  window.eqfeed_callback = function(results) {

    infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < results.features.length; i++) {
      var coords = results.features[i].geometry.coordinates;
      var latLng = new google.maps.LatLng(coords[0], coords[1]);
      var marker = new google.maps.Marker({
        position: latLng,
        title: results.features[i].properties.type + '-' + i
      });
      infowindows[i] = {};
      infowindows[i]['info'] = emissionsBodyBox(results.features[i].properties, i);
      infowindows[i]['detail'] = '<div class="modal fade" id="contmm' + results.features[i].properties.sid + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">All fields</h4></div><div class="modal-body" style="overflow:auto;">' + results.features[i].properties.detail + '</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>';
      jQuery('#infos-detail').append(infowindows[i]['detail']);
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.close();
        infowindow.setContent(infowindows[i]['info']);
        infowindow.open(map, this);
      });
      markerArray.push(marker);
    }
    //markerCluster = new MarkerClusterer(map, markerArray);
    markerCluster = new MarkerClusterer(map, markerArray, {imagePath: '/wp-content/themes/ccafs/js/js-marker-clusterer/images/m'});
    google.maps.event.addListener(markerCluster, "mouseover", function(c) {
//        log("mouseover: ");
//        log("&mdash;Center of cluster: " + c.getCenter());
      // Convert lat/long from cluster object to a usable MVCObject
      var info = new google.maps.MVCObject;
      info.set('position', c.getCenter());
      clusters = c.getMarkers();
      content = "<div id='markers_content'>";
      for (var i = 0; i < clusters.length; i++) {
//        content += "<div id='marker_" + i + "' class='markerOver' onclick='markerClick(" + i + ")'><img src='" + templatePath + "/img/soil_icon.png' height='20' width='20' onclick='markerBack(" + i + ")' align='left' style='cursor:pointer'>" + clusters[i].getTitle().split('-')[0] + (parseInt(clusters[i].getTitle().split('-')[1]) + 1) + '</div>';
      }
//      content += "</div>";

      for (var i = 0; i < clusters.length; i++) {
        contentid = clusters[i].getTitle().split('-')[1];
//        content += "<div id='markers_detail_" + i + "' style='display:none'>";
//        content += "<div><img src='" + templatePath + "/img/back_row.png' height='20' width='20' onclick='markerBack(" + i + ")' style='cursor:pointer'></div>";
        content += infowindows[contentid]['info'];
//        content += "</div>";
      }
      content += "</div>";
      infowindow.close();
      infowindow.setContent(content);
//      infowindow.setZIndex(9999);
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

//function fullviewopen() {
//  jQuery("#fullviewDiv").dialog("open");
//}

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
  mapCallBack();
}
google.maps.event.addDomListener(window, 'load', initialize);

function reloadMap() {
  markerCluster.removeMarkers(markerArray);
  markerArray = [];
  jQuery('#infos-detail').empty();
  infowindows = [];
  var script = document.createElement('script');
  script.src = templatePath + "/dataMapFilter.php?" + jQuery('#filtersh').serialize();
  document.getElementsByTagName('head')[0].appendChild(script);

  mapCallBack();
}

function downloadData() {
  window.open(templatePath + "/experiments_download.php?" + jQuery('#filtersh').serialize(), "_blank");
  window.close();
}

function downloadDataCSV() {
  window.open(templatePath + "/experiments_downloadCSV.php?" + jQuery('#filtersh').serialize(), "_blank");
  window.close();
}

var keys = [37, 38, 39, 40];

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
    e.preventDefault();
  e.returnValue = false;
}

function keydown(e) {
  for (var i = keys.length; i--; ) {
    if (e.keyCode === keys[i]) {
      preventDefault(e);
      return;
    }
  }
}

function wheel(e) {
  preventDefault(e);
}

function disable_scroll() {
  if (window.addEventListener) {
    window.addEventListener('DOMMouseScroll', wheel, false);
  }
  window.onmousewheel = document.onmousewheel = wheel;
  document.onkeydown = keydown;
}

function enable_scroll() {
  if (window.removeEventListener) {
    window.removeEventListener('DOMMouseScroll', wheel, false);
  }
  window.onmousewheel = document.onmousewheel = document.onkeydown = null;
}

$(document).ready(function($) {
  //$("#tabs").tabs();

  $('#resulttable_soils').dataTable({
    'scrollX': true,
//      'jQueryUI': true,
    "processing": true,
    "serverSide": true,
    searching: false,
    ordering: true,
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

  $('#fullview').dataTable({
    'scrollX': true,
//      'jQueryUI': true,
    "processing": true,
    "serverSide": true,
    searching: false,
    ordering: false,
    "ajax": {
      url: templatePath + "/dataTableFilter.php",
      type: 'POST',
      data: function(d) {
        d.region = $('#region').val();
        d.country = $('#country').val();
        d.ipcc1996 = $('#ipcc1996').val();
        d.ipcc2006 = $('#ipcc2006').val();
        d.soils = '1';
        d.allfields = 'true';
      },
      dataSrc: function(json) {
        if (json.data.length == 0) {
//          $("#tab_soils").hide();
        }
        return json.data;
      }
    }
  });

//  $("#fullviewDiv").dialog({
//    autoOpen: false,
//    height: $(window).height(),
//    width: $(window).width(),
//    modal: true,
//    dialogClass: "alert",
//    draggable: false,
//    open: function(event, ui) {
//      disable_scroll()
//    },
//    close: function(event, ui) {
//      enable_scroll()
//    },
//    buttons: {
//      Cancel: function() {
//        jQuery(this).dialog("close");
//      }
//    }
//  });

  $('#region').select2({
    placeholder: "Select a region",
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
    placeholder: "Select a country",
    allowClear: true,
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

  var menu = $('#form-content');
//  var contenedor = $('#menu-contenedor');
  var menu_offset = menu.offset();
  // Cada vez que se haga scroll en la pÃ¡gina
  // haremos un chequeo del estado del menÃº
  // y lo vamos a alternar entre 'fixed' y 'static'.
  $(window).on('scroll', function() {
    if ($(window).scrollTop() > menu_offset.top) {
      menu.addClass('menu-fijo');
    } else {
      menu.removeClass('menu-fijo');
    }
  });

});
