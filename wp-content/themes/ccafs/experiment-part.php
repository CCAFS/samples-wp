<?php
require('../../../wp-load.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
  var templateUrl = '<?php get_bloginfo("url"); ?>';
  var templatePath = '<?php echo get_template_directory_uri(); ?>';
</script>
<div style="width:100%;height:400px;z-index: 1;" id="map-canvas"></div>
<br>
<div id="results_soils" style="z-index: 1" class="samples-table">
  <!--<h3>Soils</h3>-->
  <table id='resulttable_soils' name='resulttable_soils' class="display compact cell-border statistic-ag" style="font: 90%/1em "Helvetica Neue", HelveticaNeue, Helvetica, Arial, sans-serif;">
         <thead>
      <tr>
        <th>Country</th>
        <th>System</th>
        <th>Type of EF</th>
        <th>Value</th>
        <th>Units</th>
        <th style="min-width: 133px">1996 IPCC source/sink code</th>
        <th style="min-width: 138px">P2006 IPCC source/sink code</th>
      </tr>
    </thead>
  </table>
  <a href="" style="  color: #4929DD;text-decoration: underline;">View all fields</a>
</div>
<div id='downloadFile'>
  <h3>Download Data</h3>
  <a href='#' onClick='' title='Download Data for Excel'><img style='heigth:60px;width:60px;' src='<?php echo get_template_directory_uri() ?>/img/excel.png'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href='#' onClick=''title='Download Data for CSV'><img style='heigth:60px;width:60px;' src='<?php echo get_template_directory_uri() ?>/img/csv.png'></a>
</div>
<br>
<script>
  function markerClick(id) {
    jQuery('#markers_content').hide();
    jQuery('#markers_detail_' + id).show();
  }

  function markerBack(id) {
    jQuery('#markers_detail_' + id).hide();
    jQuery('#markers_content').show();
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
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(script, s);

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
      var markerCluster = new MarkerClusterer(map, markerArray);
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

  $(document).ready(function($) {
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
  });
</script>

