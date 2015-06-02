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
    if ($result[$i]['idef_soils']) {
      echo '"value1":"' . $result[$i]['treat_desc'] . '", '
      . '"value2":"' . $result[$i]['soi_crop'] . '", '
      . '"value3":"' . $result[$i]['soi_type_emission'] . '", '
      . '"ef_value":"' . $result[$i]['soi_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['soi_ef_units'] . '", '
      . '"detail":"' . getGasEmissionDetail($result[$i]) . '", '
      . '"type":"soil"';
    } elseif ($result[$i]['idef_enteric']) {
      echo '"value1":"' . $result[$i]['ent_subespecies_class'] . '", '
      . '"value2":"' . $result[$i]['ent_type_livestock_manag_sys'] . '", '
      . '"value3":"' . $result[$i]['ent_type_emiss_fact'] . '", '
      . '"ef_value":"' . $result[$i]['ent_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['ent_ef_units'] . '", '
      . '"type":"enteric"';
    } elseif ($result[$i]['idef_manure']) {
      echo '"value1":"' . $result[$i]['man_subspacies'] . '", '
      . '"value2":"' . $result[$i]['man_type_manure_manag_sys'] . '", '
      . '"value3":"' . $result[$i]['man_type_emiss_fact'] . '", '
      . '"ef_value":"' . $result[$i]['man_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['man_ef_units'] . '", '
      . '"type":"manure"';
    } elseif ($result[$i]['idef_grassland_burning']) {
      echo '"value1":"' . $result[$i]['gra_type_emiss_fact'] . '", '
      . '"value2":"' . $result[$i]['gra_ecosyst_desc'] . '", '
      . '"ef_value":"' . $result[$i]['gra_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['gra_ef_units'] . '", '
      . '"type":"grassland"';
    } elseif ($result[$i]['idef_residue_burning']) {
      echo '"value1":"' . $result[$i]['res_type_emiss_fact'] . '", '
      . '"value2":"' . $result[$i]['res_type_crop'] . '", '
      . '"ef_value":"' . $result[$i]['res_ef_value'] . '", '
      . '"ef_units":"' . $result[$i]['res_ef_units'] . '", '
      . '"type":"residue"';
    } elseif ($result[$i]['idef_biomass']) {
      echo '"value1":"' . $result[$i]['bio_type_emiss_fact'] . '", '
      . '"value2":"' . $result[$i]['bio_type_forest'] . '", '
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
          . "</tr>"
          . "<tr>";
  if ($emission['idef_soils']) {
    $result .= "<td>" . $emission['idexperiment'] . "</td>"
            . "<td>" . $emission['exp_name'] . "</td>"
            . "<td>" . $emission['exp_keywords'] . "</td>"
            . "<td>" . $emission['exp_brief_desc'] . "</td>"
            . "<td>" . $emission['exp_country'] . "</td>"
            . "<td>" . $emission['exp_province_state'] . "</td>"
            . "<td>" . $emission['exp_nearest_city'] . "</td>"
            . "<td>" . $emission['exp_latitude'] . "</td>"
            . "<td>" . $emission['exp_longitude'] . "</td>"
            . "<td>" . $emission['exp_year_began'] . "</td>"
            . "<td>" . $emission['exp_year_ended'] . "</td>"
            . "<td>" . $emission['exp_mean_annual_precipitation'] . "</td>"
            . "<td>" . $emission['exp_mean_annual_temperature'] . "</td>"
            . "<td>" . $emission['exp_soil_taxo_desc'] . "</td>"
            . "<td>" . $emission['exp_soil_taxo_sys'] . "</td>"
            . "<td>" . $emission['exp_soil_surface_tex'] . "</td>"
            . "<td>" . $emission['exp_min_water_depth'] . "</td>"
            . "<td>" . $emission['exp_soil_ph'] . "</td>"
            . "<td>" . $emission['exp_soil_org_matter'] . "</td>"
            . "<td>" . $emission['exp_soil_n'] . "</td>"
            . "<td>" . $emission['exp_init_soil_carbon'] . "</td>"
            . "<td>" . $emission['exp_key_findings'] . "</td>"
            . "<td>" . $emission['id_treatment'] . "</td>"
            . "<td>" . $emission['treat_desc'] . "</td>"
            . "<td>" . $emission['treat_system'] . "</td>"
            . "<td>" . $emission['treat_tillage_type'] . "</td>"
            . "<td>" . $emission['treat_synt_n_fert_type'] . "</td>"
            . "<td>" . $emission['treat_manure_amend_type'] . "</td>"
            . "<td>" . $emission['treat_nit_rate'] . "</td>"
            . "<td>" . $emission['treat_method_app'] . "</td>"
            . "<td>" . $emission['treat_crop_rotation'] . "</td>"
            . "<td>" . $emission['treat_cover_crop'] . "</td>"
            . "<td>" . $emission['treat_res_rem'] . "</td>"
            . "<td>" . $emission['treat_res_burn'] . "</td>"
            . "<td>" . $emission['treat_irrigation'] . "</td>"
            . "<td>" . $emission['treat_other_soil_emiss_tech'] . "</td>"
            . "<td>" . $emission['treat_grain'] . "</td>"
            . "<td>" . $emission['treat_stover'] . "</td>"
            . "<td>" . $emission['treat_roots'] . "</td>"
            . "<td>" . $emission['treat_notes'] . "</td>"
            . "<td>" . $emission['treatr_type_rice_eco'] . "</td>"
            . "<td>" . $emission['treatr_water_manage'] . "</td>"
            . "<td>" . $emission['treatr_land_prep'] . "</td>"
            . "<td>" . $emission['treatr_user_herb'] . "</td>"
            . "<td>" . $emission['treatr_crop_season'] . "</td>"
            . "<td>" . $emission['treatr_num_grow_days'] . "</td>"
            . "<td>" . $emission['treatr_org_manage'] . "</td>"
            . "<td>" . $emission['soi_ipcc_1996'] . "</td>"
            . "<td>" . $emission['soi_ipcc_2006'] . "</td>"
            . "<td>" . $emission['soi_gas'] . "</td>"
            . "<td>" . $emission['soi_crop'] . "</td>"
            . "<td>" . $emission['soi_gas_sampling_freq'] . "</td>"
            . "<td>" . $emission['soi_type_emission'] . "</td>"
            . "<td>" . $emission['soi_depth_measu'] . "</td>"
            . "<td>" . $emission['soi_ef_value'] . "</td>"
            . "<td>" . $emission['soi_ef_units'] . "</td>"
            . "<td>" . $emission['soi_equation'] . "</td>"
            . "<td>" . $emission['soi_lower_bound'] . "</td>"
            . "<td>" . $emission['soi_upper_bound'] . "</td>"
            . "<td>" . $emission['soi_uncertainty'] . "</td>"
            . "<td>" . $emission['soi_notes'] . "</td>"
            . "</tr>";
  } elseif ($emission['idef_enteric']) {
    
  } elseif ($emission['idef_manure']) {
    
  } elseif ($emission['idef_grassland_burning']) {
    
  } elseif ($emission['idef_residue_burning']) {
    
  } elseif ($emission['idef_biomass']) {
    
  }
  $result .= "</table>";
  return $result;
}
