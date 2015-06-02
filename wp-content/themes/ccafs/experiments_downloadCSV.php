<?php
require('../../../wp-load.php');
global $wpdb;
// This needs to be set, in order for the script work, 
//in the case when the request variable is empty, throws 
//an e_notice of the empty array
error_reporting(0);

//$conexion = new mysqli('localhost', 'root', '', 'agimpacts', 3306);
//if (mysqli_connect_errno()) {
//  printf("The conexion to the server failed: %s\n", mysqli_connect_error());
//  exit();
//}

$region = $_REQUEST['region'];
$country = $_REQUEST['country'];
$ipcc1996 = $_REQUEST['ipcc1996'];
$ipcc2006 = $_REQUEST['ipcc2006'];
$source = $_REQUEST['source'];
$where = "  ";
$where1 = "";
$where2 = "";
$where3 = "";
$where4 = "";
$where5 = "";
$where6 = "";

if ($region != "" && $region != 'null' && $region != 'all') {
  $where .= " AND exp.exp_country IN (SELECT a.cny_name FROM wp_country a INNER JOIN wp_continent b ON (a.wp_continent_id_continent = b.id_continent AND b.cnt_name like '" . $region . "')) ";
}
if ($country != 'null' && $country != '') {
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
// DB table to use
$select = '';

$select = " idexperiment, exp_name, exp_keywords, exp_brief_desc, exp_country, exp_province_state, exp_nearest_city, exp_latitude, exp_longitude, exp_year_began, exp_year_ended, exp_mean_annual_precipitation, exp_mean_annual_temperature, exp_soil_taxo_desc, exp_soil_taxo_sys, exp_soil_surface_tex, exp_min_water_depth, exp_soil_ph, exp_soil_org_matter, exp_soil_n, exp_init_soil_carbon, exp_key_findings, id_treatment, treat_desc, treat_system, treat_tillage_type, treat_synt_n_fert_type, treat_manure_amend_type, treat_nit_rate, treat_method_app, treat_crop_rotation, treat_cover_crop, treat_res_rem, treat_res_burn, treat_irrigation, treat_other_soil_emiss_tech, treat_grain, treat_stover, treat_roots, treat_notes, treatr_type_rice_eco, treatr_water_manage, treatr_land_prep, treatr_user_herb, treatr_crop_season, treatr_num_grow_days, treatr_org_manage,  soi_ipcc_1996, soi_ipcc_2006, soi_gas, soi_crop, soi_gas_sampling_freq, soi_type_emission, soi_depth_measu, soi_ef_value, soi_ef_units, soi_equation, soi_lower_bound, soi_upper_bound, soi_uncertainty, soi_notes,  ent_ipcc_1996, ent_ipcc_2006, ent_gas, ent_type_emiss_fact, ent_type_livestock_manag_sys, ent_animal_bod_weight_ave, ent_weight_gain_ave, ent_subespecies_class, ent_feed_quant_access, ent_feed_quality, ent_milk_prod, ent_mitigation_tech, ent_ef_value, ent_ef_units, ent_equation, ent_lower_bound, ent_upper_bound, ent_notes,  man_ipcc_1996, man_ipcc_2006, man_gas, man_type_emiss_fact, man_type_manure_manag_sys, man_animal_weight, man_subspacies, man_num_animals_operation, man_operat_conditions, man_diet_feed_charact_anim, man_mitigation_tech, man_ef_value, man_ef_units, man_equation, man_lower_bound, man_upper_bound, man_notes,  gra_ipcc_1996, gra_ipcc_2006, gra_gas, gra_type_emiss_fact, gra_ecosyst_desc, gra_fuel_density, gra_whether_litter_liv_veg, gra_ef_value, gra_ef_units, gra_equation, gra_lower_bound, gra_upper_bound, gra_notes,  res_ipcc_1996, res_ipcc_2006, res_type_emiss_fact, res_type_crop, res_crop_area, res_crop_yield, res_crop_seasson, res_residue_desc, res_ef_value, res_ef_units, res_equation, res_lower_bound, res_upper_bound, res_notes,  bio_ipcc_1996, bio_ipcc_2006, bio_gas, bio_type_emiss_fact, bio_type_forest, bio_forest_age, bio_manag_pact_applied, bio_ef_value, bio_ef_units, bio_equation, bio_lower_bound, bio_upper_bound, bio_notes ";
$where .= " AND (soi.idef_soils is not null OR ent.idef_enteric is not null OR man.idef_manure is not null OR gra.idef_grassland_burning is not null OR res.idef_residue_burning is not null OR bio.idef_biomass is not null)";
$sql1 = "SELECT "
        . $select
        . " FROM wp_experiment exp "
        . " LEFT JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
        . " LEFT JOIN wp_ef_soils soi ON (soi.wp_treatment_id_treatment=tre.id_treatment $where1)"
        . " LEFT JOIN wp_ef_enteric ent ON (ent.wp_experiment_idexperiment=exp.idexperiment $where2)"
        . " LEFT JOIN wp_ef_manure man ON (man.wp_experiment_idexperiment=exp.idexperiment $where3)"
        . " LEFT JOIN wp_ef_grassland_burning gra ON (gra.wp_experiment_idexperiment=exp.idexperiment $where4)"
        . " LEFT JOIN wp_ef_residue_burning res ON (res.wp_experiment_idexperiment=exp.idexperiment $where5)"
        . " LEFT JOIN wp_ef_biomass bio ON (bio.wp_experiment_idexperiment=exp.idexperiment $where6)"
        . " WHERE 1 "
        . $where;
//  echo $sql1;
$resultado = $wpdb->get_results($sql1, ARRAY_N);
//echo $result; exit();
//$resultado = $wpdb->get_results($sql1, ARRAY_A);
$headers = array('Experiment ID','Experiment Name','Experiment keywords','Brief Description','Country','Province/State','Nearest city','Latitude (decimal)','Longitude (decimal)','Year Experiment Began','Year Experiment Ended','Mean annual precipitation (mm)','Mean annual temperature (°C)','Soil Taxonomic Description','Soil Taxonomy System','Surface Soil Texture','Minimum Water Table Depth (m)','Soil pH','Soil organic matter (%)','Soil N (%)','Soil organic carbon (%)','Key Findings','Treatment ID','Treatment description','System','Tillage type','Synthetic N fertilizer type','Manure/ Amendment Type','Nitrogen rate (kg N ha-1 yr-1)','Method of application','Crop Rotation','Cover crop','Residue removal','Residue burning','Irrigation','Any other soils emissions abatement technologies used?','Grain','Stover','Roots','Other/notes','Type of rice ecosystem','Water management','Land preparation','Use of herbicides','Crop season','Number of growing days','Organic management (manure/rice straw incorporation)','IPCC 1996','IPCC 2006','Gas','Crop','Gas sampling frequency','Type of emission factor','Depth of measurement (cm)','Value of EF','Units of EF','Equation','Lower bound of 95% CI','Upper bound of 95% CI','Uncertainty (expressed as 95% CI)','Notes','1996','2006','Gas','Type of emission factor','Type of livestock management system (pasture, feedlot, rangeland, combination)','Animal body weight (average)','Weight gain (average)','Subspecies classification','Feed quantity and accessibility (ad libitum)','Feed quality (describe)','Milk production (if dairy)','Mitigation technologies used','Value of EF','Units of EF','Equation','Lower bound of 95% CI','Upper bound of 95% CI','Notes','1996','2006','Gas','Type of emission factor','Type of manure management system','Animal weight (avg)','Subspecies','Number of animals in operation','Operational conditions of system: retention time of waste, recycling of waste, solids separation','Diet and feed characteristics for animals','Mitigation technologies used','Value of EF','Units of EF','Equation','Lower bound of 95% CI','Upper bound of 95% CI','Notes','1996','2006','Gas','Type of emission factor','Description of ecosystem','Density of fuel','Whether litter or living vegetation','Value of EF','Units of EF','Equation','Lower bound of 95% CI','Upper bound of 95% CI','Notes','1996','2006','Type of emission factor','Type of crop','Area of crop','Crop yield','Crop season','Description of residue (e.g. biomass density at time of burning)','Value of EF','Units of EF','Equation','Lower bound of 95% CI','Upper bound of 95% CI','Notes','1996','2006','Gas','Type of emission factor','Type of forest','Forest age','Management practices applied','Value of EF','Units of EF','Equation','Lower bound of 95% CI','Upper bound of 95% CI','Notes');
if (count($resultado) > 0) {

  $fp = fopen('php://output', 'w');
  if ($fp && $resultado) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="emissions.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $headers);
    foreach ($resultado as $row) {
      fputcsv($fp, array_values($row));
    }
    die;
  }
} else {
  echo "<script language='javascript'>alert('No Data Found');</script>";
}
?>