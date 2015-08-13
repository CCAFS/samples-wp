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
$wherea = "";
$where1 = "";
$where2 = "";
$where3 = "";
$where4 = "";
$where5 = "";
$where6 = "";

if ($region != "" && $region != 'null' && $region != 'all') {
  $where .= " AND exp.exp_country IN (SELECT a.cny_name FROM wp_country a INNER JOIN wp_continent b ON (a.wp_continent_id_continent = b.id_continent AND b.cnt_name like '" . trim($region) . "')) ";
}
if ($country != 'null' && $country != '' && $country != 'all') {
  $where .= " AND exp.exp_country like '%" . trim($country) . "%' ";
}
if ($source != 'null' && $source != '' && $source != 'all') {
  if ($source == 'Soils') {
    $wherea .= " AND type = 'soil' ";
  } else if ($source == 'Livestock') {
    $wherea .= " AND type = 'enteric' ";
  } else if ($source == 'Manure') {
    $wherea .= " AND type = 'manure' ";
  } else if ($source == 'Grassland burning') {
    $wherea .= " AND type = 'grassland' ";
  } else if ($source == 'Residue burning') {
    $wherea .= " AND type = 'residue' ";
  } else if ($source == 'Biomass carbon') {
    $wherea .= " AND type = 'biomass' ";
  }
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
//$where .= " AND (soi.idef_soils is not null OR ent.idef_enteric is not null OR man.idef_manure is not null OR gra.idef_grassland_burning is not null OR res.idef_residue_burning is not null OR bio.idef_biomass is not null)";
/*$sql1 = "SELECT * "
        . " FROM wp_experiment exp "
        . " LEFT JOIN wp_contact_info cnt ON (cnt.wp_experiment_idexperiment=exp.idexperiment)"
        . " LEFT JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
        . " LEFT JOIN wp_ef_soils soi ON (soi.wp_treatment_id_treatment=tre.id_treatment $where1)"
        . " LEFT JOIN wp_ef_enteric ent ON (ent.wp_experiment_idexperiment=exp.idexperiment $where2)"
        . " LEFT JOIN wp_ef_manure man ON (man.wp_experiment_idexperiment=exp.idexperiment $where3)"
        . " LEFT JOIN wp_ef_grassland_burning gra ON (gra.wp_experiment_idexperiment=exp.idexperiment $where4)"
        . " LEFT JOIN wp_ef_residue_burning res ON (res.wp_experiment_idexperiment=exp.idexperiment $where5)"
        . " LEFT JOIN wp_ef_biomass bio ON (bio.wp_experiment_idexperiment=exp.idexperiment $where6)"
        . " WHERE 1 "
        . $where
        . " ORDER BY exp.idexperiment_tec $limit";*/

$sql = "SELECT * FROM ((SELECT " 
        . " soi.soi_type_emission as value1, tre.treat_desc as value2, soi.soi_crop as value3, ROUND(soi.soi_ef_value, 2) as ef_value, soi.soi_ef_units as ef_units, 'soil' as type, idef_soils as id, exp_latitude, exp_longitude"
        . " FROM wp_experiment exp "
        . " INNER JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
        . " INNER JOIN wp_ef_soils soi ON soi.wp_treatment_id_treatment=tre.id_treatment "
        . " WHERE 1 $where $where1)"
        . " UNION "
        . " (SELECT "
        . " ent.ent_type_emiss_fact as value1, ent.ent_type_livestock_manag_sys as value2, ent.ent_subespecies_class as value3, ROUND(ent.ent_ef_value, 2) as ef_value, ent.ent_ef_units as ef_units, 'enteric' as type, idef_enteric as id, exp_latitude, exp_longitude"
        . " FROM wp_experiment exp "
        . " INNER JOIN wp_ef_enteric ent ON ent.wp_experiment_idexperiment=exp.idexperiment "
        . " WHERE 1 $where $where2)"
        . " UNION "
        . " (SELECT "
        . " man.man_type_emiss_fact as value1, man.man_type_manure_manag_sys as value2, man.man_subspacies as value3, ROUND(man.man_ef_value, 2) as ef_value, man.man_ef_units as ef_units, 'manure' as type, idef_manure as id, exp_latitude, exp_longitude"
        . " FROM wp_experiment exp "
        . " INNER JOIN wp_ef_manure man ON man.wp_experiment_idexperiment=exp.idexperiment "
        . " WHERE 1 $where $where3)"
        . " UNION "
        . " (SELECT "
        . " gra.gra_type_emiss_fact as value1, gra.gra_ecosyst_desc as value2, '' as value3,ROUND(gra.gra_ef_value, 2) as ef_value, gra.gra_ef_units as ef_units, 'grassland' as type, idef_grassland_burning as id, exp_latitude, exp_longitude"
        . " FROM wp_experiment exp "
        . " INNER JOIN wp_ef_grassland_burning gra ON gra.wp_experiment_idexperiment=exp.idexperiment "
        . " WHERE 1 $where $where4)"
        . " UNION "
        . " (SELECT "
        . " res.res_type_emiss_fact as value1, res.res_type_crop as value2, '' as value3, ROUND(res.res_ef_value, 2) as ef_value, res.res_ef_units as ef_units, 'residue' as type, idef_residue_burning as id, exp_latitude, exp_longitude"
        . " FROM wp_experiment exp "
        . " INNER JOIN wp_ef_residue_burning res ON res.wp_experiment_idexperiment=exp.idexperiment "
        . " WHERE 1 $where $where5)"
        . " UNION "
        . " (SELECT "
        . " bio.bio_type_emiss_fact as value1, bio.bio_type_forest as value2, '' as value3, ROUND(bio.bio_ef_value, 2) as ef_value, bio.bio_ef_units as ef_units, 'biomass' as type, bio_type_emiss_fact as id, exp_latitude, exp_longitude"
        . " FROM wp_experiment exp "
        . " INNER JOIN wp_ef_biomass bio ON bio.wp_experiment_idexperiment=exp.idexperiment "
        . " WHERE 1 $where $where6)) as a WHERE 1 $wherea";
//  echo $sql."\n";
$result = $wpdb->get_results($sql, ARRAY_A);
//$emissions = array();
//foreach ($result as $key => $emission) {
//  if ($emission['idef_soils']) {
//    
//  } elseif ($emission['idef_enteric']) {
//    
//  } elseif ($emission['idef_manure']) {
//    
//  } elseif ($emission['idef_grassland_burning']) {
//    
//  } elseif ($emission['idef_residue_burning']) {
//    
//  } elseif ($emission['idef_biomass']) {
//    
//  }
//}
//echo "<pre>". print_r($result,true)."</pre>\n";
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
    if ($result[$i]['type'] == 'soil') {
      echo '"value1":"' . $result[$i]['value2'] . '", '
      . '"value2":"' . $result[$i]['value3'] . '", '
      . '"value3":"' . $result[$i]['value1'] . '", '
      . '"ef_value":"' . $result[$i]['ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['ef_units'] . '", '
      . '"detail":"' . getGasEmissionDetail($result[$i]['id']) . '", '
      . '"sid":"soil' . $result[$i]['id'] . '", '
      . '"type":"soil"';
    } elseif ($result[$i]['type'] == 'enteric') {
      echo '"value1":"' . $result[$i]['value3'] . '", '
      . '"value2":"' . $result[$i]['value2'] . '", '
      . '"value3":"' . $result[$i]['value1'] . '", '
      . '"ef_value":"' . $result[$i]['ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['ef_units'] . '", '
      . '"sid":"enteric' . $result[$i]['id'] . '", '
      . '"type":"enteric"';
    } elseif ($result[$i]['type'] == 'manure') {
      echo '"value1":"' . $result[$i]['value3'] . '", '
      . '"value2":"' . $result[$i]['value2'] . '", '
      . '"value3":"' . $result[$i]['value1'] . '", '
      . '"ef_value":"' . $result[$i]['ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['ef_units'] . '", '
      . '"sid":"manure' . $result[$i]['id'] . '", '
      . '"type":"manure"';
    } elseif ($result[$i]['type'] == 'grassland') {
      echo '"value1":"' . $result[$i]['value1'] . '", '
      . '"value2":"' . $result[$i]['value2'] . '", '
      . '"ef_value":"' . $result[$i]['ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['ef_units'] . '", '
      . '"sid":"grassland' . $result[$i]['id'] . '", '
      . '"type":"grassland"';
    } elseif ($result[$i]['type'] == 'residue') {
      echo '"value1":"' . $result[$i]['value1'] . '", '
      . '"value2":"' . $result[$i]['value2'] . '", '
      . '"ef_value":"' . $result[$i]['ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['ef_units'] . '", '
      . '"sid":"residue' . $result[$i]['id'] . '", '
      . '"type":"residue"';
    } elseif ($result[$i]['type'] == 'biomass') {
      echo '"value1":"' . $result[$i]['value1'] . '", '
      . '"value2":"' . $result[$i]['value2'] . '", '
      . '"ef_value":"' . $result[$i]['ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['ef_units'] . '", '
      . '"sid":"biomass' . $result[$i]['id'] . '", '
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
  global $wpdb;
  $sql = "SELECT * , ROUND(soi.soi_ef_value, 2) as ef_value "
        . " FROM wp_experiment exp "
        . " LEFT JOIN wp_contact_info cnt ON (cnt.wp_experiment_idexperiment=exp.idexperiment)"
        . " INNER JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
        . " INNER JOIN wp_ef_soils soi ON (soi.wp_treatment_id_treatment=tre.id_treatment AND soi.idef_soils = $emission) ";
  
  $results = $wpdb->get_results($sql, ARRAY_A);
//  echo "<pre>". print_r($results,true)."</pre>\n";
  $result = "<table class='display compact cell-border statistic-ag dataTable no-footer samples-table'>"
          . "<tr>"
          /* . "<th>Experiment ID</th>"
            . "<th>Exp. Name</th>"
            . "<th>Exp brief desc</th>"
            . "<th>Treatment ID</th>"
            . "<th>Treat desc</th>"
            . "<th>Crop</th>"
            . "<th>Type emission</th>"
            . "<th>Ef value</th>"
            . "<th>Ef units</th>"
            . "<th>IPCC 1996</th>"
            . "<th>IPCC 2006</th>" */
          . "<th>Experiment ID</th>"
          . "<th>Experiment Name</th>"
          . "<th>Experiment keywords</th>"
          . "<th>Brief Description</th>"
          . "<th>Country</th>"
          . "<th>Province/State</th>"
          . "<th>Nearest city</th>"
          . "<th>Latitude (decimal)</th>"
          . "<th>Longitude (decimal)</th>"
          . "<th>Year Experiment Began</th>"
          . "<th>Year Experiment Ended</th>"
          . "<th>Mean annual precipitation (mm)</th>"
          . "<th>Mean annual temperature (°C)</th>"
          . "<th>Soil Taxonomic Description</th>"
          . "<th>Soil Taxonomy System</th>"
          . "<th>Surface Soil Texture</th>"
          . "<th>Minimum Water Table Depth (m)</th>"
          . "<th>Soil pH</th>"
          . "<th>Soil organic matter (%)</th>"
          . "<th>Soil N (%)</th>"
          . "<th>Soil organic carbon (%)</th>"
          . "<th>Key Findings</th>"
          . "<th>Treatment ID</th>"
          . "<th>Treatment description</th>"
          . "<th>System</th>"
          . "<th>Tillage type</th>"
          . "<th>Synthetic N fertilizer type</th>"
          . "<th>Manure/ Amendment Type</th>"
          . "<th>Nitrogen rate (kg N ha-1 yr-1)</th>"
          . "<th>Method of application</th>"
          . "<th>Crop Rotation</th>"
          . "<th>Cover crop</th>"
          . "<th>Residue removal</th>"
          . "<th>Residue burning</th>"
          . "<th>Irrigation</th>"
          . "<th>Any other soils emissions abatement technologies used?</th>"
          . "<th>Grain</th>"
          . "<th>Stover</th>"
          . "<th>Roots</th>"
          . "<th>Other/notes</th>"
          . "<th>Type of rice ecosystem</th>"
          . "<th>Water management</th>"
          . "<th>Land preparation</th>"
          . "<th>Use of herbicides</th>"
          . "<th>Crop season</th>"
          . "<th>Number of growing days</th>"
          . "<th>Organic management (manure/rice straw incorporation)</th>"
          . "<th>1996</th>"
          . "<th>2006</th>"
          . "<th>Gas</th>"
          . "<th>Crop</th>"
          . "<th>Gas sampling frequency</th>"
          . "<th>Type of emission factor</th>"
          . "<th>Depth of measurement (cm)</th>"
          . "<th>Value of EF</th>"
          . "<th>Units of EF</th>"
          . "<th>Equation</th>"
          . "<th>Lower bound of 95% CI</th>"
          . "<th>Upper bound of 95% CI</th>"
          . "<th>Uncertainty (expressed as 95% CI)</th>"
          . "<th>Notes</th>"
          . "<th>Contact information</th>"
          . "<th>Journal citation</th>"
          . "</tr>"
          . "<tr>";
  if ($results[0]['idef_soils']) {
    $result .= "<td>" . $results[0]['idexperiment'] . "</td>"
            . "<td>" . $results[0]['exp_name'] . "</td>"
            . "<td>" . $results[0]['exp_keywords'] . "</td>"
            . "<td>" . $results[0]['exp_brief_desc'] . "</td>"
            . "<td>" . $results[0]['exp_country'] . "</td>"
            . "<td>" . $results[0]['exp_province_state'] . "</td>"
            . "<td>" . $results[0]['exp_nearest_city'] . "</td>"
            . "<td>" . $results[0]['exp_latitude'] . "</td>"
            . "<td>" . $results[0]['exp_longitude'] . "</td>"
            . "<td>" . $results[0]['exp_year_began'] . "</td>"
            . "<td>" . $results[0]['exp_year_ended'] . "</td>"
            . "<td>" . $results[0]['exp_mean_annual_precipitation'] . "</td>"
            . "<td>" . $results[0]['exp_mean_annual_temperature'] . "</td>"
            . "<td>" . $results[0]['exp_soil_taxo_desc'] . "</td>"
            . "<td>" . $results[0]['exp_soil_taxo_sys'] . "</td>"
            . "<td>" . $results[0]['exp_soil_surface_tex'] . "</td>"
            . "<td>" . $results[0]['exp_min_water_depth'] . "</td>"
            . "<td>" . $results[0]['exp_soil_ph'] . "</td>"
            . "<td>" . $results[0]['exp_soil_org_matter'] . "</td>"
            . "<td>" . $results[0]['exp_soil_n'] . "</td>"
            . "<td>" . $results[0]['exp_init_soil_carbon'] . "</td>"
            . "<td>" . $results[0]['exp_key_findings'] . "</td>"
            . "<td>" . $results[0]['id_treatment'] . "</td>"
            . "<td>" . $results[0]['treat_desc'] . "</td>"
            . "<td>" . $results[0]['treat_system'] . "</td>"
            . "<td>" . $results[0]['treat_tillage_type'] . "</td>"
            . "<td>" . $results[0]['treat_synt_n_fert_type'] . "</td>"
            . "<td>" . $results[0]['treat_manure_amend_type'] . "</td>"
            . "<td>" . $results[0]['treat_nit_rate'] . "</td>"
            . "<td>" . $results[0]['treat_method_app'] . "</td>"
            . "<td>" . $results[0]['treat_crop_rotation'] . "</td>"
            . "<td>" . $results[0]['treat_cover_crop'] . "</td>"
            . "<td>" . $results[0]['treat_res_rem'] . "</td>"
            . "<td>" . $results[0]['treat_res_burn'] . "</td>"
            . "<td>" . $results[0]['treat_irrigation'] . "</td>"
            . "<td>" . $results[0]['treat_other_soil_emiss_tech'] . "</td>"
            . "<td>" . $results[0]['treat_grain'] . "</td>"
            . "<td>" . $results[0]['treat_stover'] . "</td>"
            . "<td>" . $results[0]['treat_roots'] . "</td>"
            . "<td>" . $results[0]['treat_notes'] . "</td>"
            . "<td>" . $results[0]['treatr_type_rice_eco'] . "</td>"
            . "<td>" . $results[0]['treatr_water_manage'] . "</td>"
            . "<td>" . $results[0]['treatr_land_prep'] . "</td>"
            . "<td>" . $results[0]['treatr_user_herb'] . "</td>"
            . "<td>" . $results[0]['treatr_crop_season'] . "</td>"
            . "<td>" . $results[0]['treatr_num_grow_days'] . "</td>"
            . "<td>" . $results[0]['treatr_org_manage'] . "</td>"
            . "<td>" . $results[0]['soi_ipcc_1996'] . "</td>"
            . "<td>" . $results[0]['soi_ipcc_2006'] . "</td>"
            . "<td>" . $results[0]['soi_gas'] . "</td>"
            . "<td>" . $results[0]['soi_crop'] . "</td>"
            . "<td>" . $results[0]['soi_gas_sampling_freq'] . "</td>"
            . "<td>" . $results[0]['soi_type_emission'] . "</td>"
            . "<td>" . $results[0]['soi_depth_measu'] . "</td>"
            . "<td>" . $results[0]['ef_value'] . "</td>"
            . "<td>" . $results[0]['soi_ef_units'] . "</td>"
            . "<td>" . $results[0]['soi_equation'] . "</td>"
            . "<td>" . $results[0]['soi_lower_bound'] . "</td>"
            . "<td>" . $results[0]['soi_upper_bound'] . "</td>"
            . "<td>" . $results[0]['soi_uncertainty'] . "</td>"
            . "<td>" . $results[0]['soi_notes'] . "</td>"
            . "<td>" . $results[0]['cont_email_primary'] . "</td>"
            . "<td>" . $results[0]['cont_journal_citation'] . "</td>"
            . "</tr>";
  } /*elseif ($emission['idef_enteric']) {
    
  } elseif ($emission['idef_manure']) {
    
  } elseif ($emission['idef_grassland_burning']) {
    
  } elseif ($emission['idef_residue_burning']) {
    
  } elseif ($emission['idef_biomass']) {
    
  }*/
  $result .= "</table>";
  return $result;
}
