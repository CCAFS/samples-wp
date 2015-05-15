<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require('../../../wp-load.php');
$region = $_REQUEST['region'];
$country = $_REQUEST['country'];
$ipcc1996 = $_REQUEST['ipcc1996'];
$ipcc2006 = $_REQUEST['ipcc2006'];
$source = $_REQUEST['source'];
$where = "";
$where1 = "";
$where2 = "";
$where3 = "";
$where4 = "";
$where5 = "";
$where6 = "";

if ($region != "" && $region != 'null' && $region != 'all') {
  $where .= " AND exp.exp_country IN (SELECT a.cny_name FROM wp_country a INNER JOIN wp_continent b ON (a.wp_continent_id_continent = b.id_continent AND b.cnt_name like '" . $region . "')) ";
}
if ($country != 'null' && $country != '' && $country != 'all') {
  $where .= " AND exp.exp_country like '%" . $country . "%' ";
}
if ($ipcc1996 != 'null' && $ipcc1996 != '' && $ipcc1996 != 'all') {
  $ipcc1996 = explode(' ', $ipcc1996);
  $where1 .= " AND soi.soi_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  $where2 .= " AND ent.ent_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  $where3 .= " AND man.man_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  $where4 .= " AND gra.gra_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  $where5 .= " AND res.res_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  $where6 .= " AND bio.bio_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
}
if ($ipcc2006 != 'null' && $ipcc2006 != '' && $ipcc2006 != 'all') {
  $ipcc2006 = explode(' ', $ipcc2006);
  $where1 .= " AND soi.soi_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  $where2 .= " AND ent.ent_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  $where3 .= " AND man.man_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  $where4 .= " AND gra.gra_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  $where5 .= " AND res.res_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  $where6 .= " AND bio.bio_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
}
$where .= " AND exp.exp_latitude NOT IN ('','N/A') AND exp.exp_longitude NOT IN ('','N/A') ";
$where .= " AND (soi.idef_soils is not null OR ent.idef_enteric is not null OR man.idef_manure is not null OR gra.idef_grassland_burning is not null OR res.idef_residue_burning is not null OR bio.idef_biomass is not null)";
$sql1 = "SELECT * "
        . " FROM wp_experiment exp "
        . " LEFT JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
        . " LEFT JOIN wp_ef_soils soi ON (soi.wp_treatment_id_treatment=tre.id_treatment $where1)"
        . " LEFT JOIN wp_ef_enteric ent ON (ent.wp_experiment_idexperiment=exp.idexperiment $where2)"
        . " LEFT JOIN wp_ef_manure man ON (man.wp_experiment_idexperiment=exp.idexperiment $where3)"
        . " LEFT JOIN wp_ef_grassland_burning gra ON (gra.wp_experiment_idexperiment=exp.idexperiment $where4)"
        . " LEFT JOIN wp_ef_residue_burning res ON (res.wp_experiment_idexperiment=exp.idexperiment $where5)"
        . " LEFT JOIN wp_ef_biomass bio ON (bio.wp_experiment_idexperiment=exp.idexperiment $where6)"
        . " WHERE 1 "
        . $where
        . " ORDER BY exp.idexperiment_tec $limit";
//  echo $sql1;
$result = $wpdb->get_results($sql1, ARRAY_A);
$emissions = array();
foreach ($result as $key => $emission) {
  if ($emission['idef_soils']) {
    
  } elseif ($emission['idef_enteric']) {
    
  } elseif ($emission['idef_manure']) {
    
  } elseif ($emission['idef_grassland_burning']) {
    
  } elseif ($emission['idef_residue_burning']) {
    
  } elseif ($emission['idef_biomass']) {
    
  }
}
//echo "<pre>". print_r($result,true)."</pre>";
echo 'eqfeed_callback({ "type": "FeatureCollection",
          "features": [';
for ($i = 0; $i < count($result); $i++) {
  if (is_numeric($result[$i]['exp_latitude']) && is_numeric($result[$i]['exp_longitude'])) {
    echo '
             { "type": "Feature",
              "id": "' . $i . '",
              "geometry": {"type": "Point", "coordinates": [' . $result[$i]['exp_latitude'] . ', ' . $result[$i]['exp_longitude'] . ']},
              "properties": {
                 ';
    if ($emission['idef_soils']) {
      echo '"gas":"' . $result[$i]['soi_gas'] . '", '
      . '"value1":"' . $result[$i]['soi_crop'] . '", '
      . '"ef_value":"' . $result[$i]['soi_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['soi_ef_units'] . '", '
      . '"detail":"' . getGasEmissionDetail($result[$i]) . '", '
      . '"type":"soil"';
    } elseif ($emission['idef_enteric']) {
      echo '"gas":"' . $result[$i]['ent_gas'] . '", '
      . '"value1":"' . $result[$i]['ent_type_livestock_manag_sys'] . '", '
      . '"ef_value":"' . $result[$i]['ent_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['ent_ef_units'] . '", '
      . '"type":"enteric"';
    } elseif ($emission['idef_manure']) {
      echo '"gas":"' . $result[$i]['man_gas'] . '", '
      . '"value1":"' . $result[$i]['man_type_manure_manag_sys'] . '", '
      . '"ef_value":"' . $result[$i]['man_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['man_ef_units'] . '", '
      . '"type":"manure"';
    } elseif ($emission['idef_grassland_burning']) {
      echo '"gas":"' . $result[$i]['gra_gas'] . '", '
      . '"value1":"' . $result[$i]['gra_ecosyst_desc'] . '", '
      . '"ef_value":"' . $result[$i]['gra_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['gra_ef_units'] . '", '
      . '"type":"grassland"';
    } elseif ($emission['idef_residue_burning']) {
      echo '"gas":"' . $result[$i]['res_gas'] . '", '
      . '"value1":"' . $result[$i]['res_type_crop'] . '", '
      . '"ef_value":"' . $result[$i]['res_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['res_ef_units'] . '", '
      . '"type":"residue"';
    } elseif ($emission['idef_biomass']) {
      echo '"gas":"' . $result[$i]['bio_gas'] . '", '
      . '"value1":"' . $result[$i]['bio_type_forest'] . '", '
      . '"ef_value":"' . $result[$i]['bio_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['bio_ef_units'] . '", '
      . '"type":"biomass"';
    }

    echo '}
             }, 
            ';
  }
}
echo ']
     });';

function getGasEmissionDetail($emission) {
  $result = "<table class='display compact cell-border statistic-ag dataTable no-footer samples-table'><tr><th>Experiment ID</th>"
          . "<th>Exp. Name</th>"
          . "<th>Exp brief desc</th>"
          . "<th>Treatment ID</th>"
          . "<th>Treat desc</th>"
          . "<th>Crop</th>"
          . "<th>Type emission</th>"
          . "<th>Ef value</th>"
          . "<th>Ef units</th>"
          . "<th>IPCC 1996</th>"
          . "<th>IPCC 2006</th></tr><tr>";
  if ($emission['idef_soils']) {
    $result .= "<td>" . $emission['idexperiment'] . "</td>"
            . "<td>" . $emission['exp_name'] . "</td>"
            . "<td>" . $emission['exp_brief_desc'] . "</td>"
            . "<td>" . $emission['id_treatment'] . "</td>"
            . "<td>" . $emission['treat_desc'] . "</td>"
            . "<td>" . $emission['soi_crop'] . "</td>"
            . "<td>" . $emission['soi_type_emission'] . "</td>"
            . "<td>" . $emission['soi_ef_value'] . "</td>"
            . "<td>" . $emission['soi_ef_units'] . "</td>"
            . "<td>" . $emission['soi_ipcc_1996'] . "</td>"
            . "<td>" . $emission['soi_ipcc_2006'] . "</td></tr>";
  } elseif ($emission['idef_enteric']) {
    
  } elseif ($emission['idef_manure']) {
    
  } elseif ($emission['idef_grassland_burning']) {
    
  } elseif ($emission['idef_residue_burning']) {
    
  } elseif ($emission['idef_biomass']) {
    
  }
  $result .= "</table>";
  return $result;
}
