<?php

require('../../../wp-load.php');
global $wpdb;
// This needs to be set, in order for the script work, 
//in the case when the request variable is empty, throws 
//an e_notice of the empty array
//error_reporting(0);


require_once ("lib/PHPExcel/PHPExcel.php");
//    require_once("conexion/conexion.php");
//    $conexion = new mysqli('localhost','root','','agimpacts',3306);
//    if (mysqli_connect_errno()) {
//        printf("The conexion to the server failed: %s\n", mysqli_connect_error());
//    exit();
//    }
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

$titleStyle = array(
  'font' => array(
    'name' => 'Verdana',
    'bold' => true,
    'italic' => false,
    'strike' => false,
    'size' => 11,
    'color' => array(
      'rgb' => '000000'
    )
  ),
  'fill' => array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'color' => array('argb' => '416725')
  ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  ),
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    'rotation' => 0,
    'wrap' => TRUE
  )
);

$columnStyle = array(
  'font' => array(
    'name' => 'Arial',
    'bold' => true,
    'color' => array(
      'rgb' => '000000'
    )
  ),
  'fill' => array(
    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
    'rotation' => 90,
    'startcolor' => array(
      'rgb' => 'FFFFFF'
    ),
    'endcolor' => array(
      'argb' => 'FFFFFF'
    )
  ),
  'borders' => array(
    'top' => array(
      'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
      'color' => array(
        'rgb' => '416725'
      )
    ),
    'bottom' => array(
      'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
      'color' => array(
        'rgb' => '416725'
      )
    )
  ),
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    'wrap' => TRUE
  )
);

$dataStyle = new PHPExcel_Style();
$dataStyle->applyFromArray(
        array(
          'font' => array(
            'name' => 'Arial',
            'color' => array(
              'rgb' => '000000'
            )
          ),
          'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFF')
          ),
          'borders' => array(
            'left' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => array(
                'rgb' => '3a2a47'
              )
            )
          )
        )
);

$dataStyleLast = new PHPExcel_Style();
$dataStyleLast->applyFromArray(
        array(
          'font' => array(
            'name' => 'Arial',
            'color' => array(
              'rgb' => '000000'
            )
          ),
          'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFF')
          ),
          'borders' => array(
            'left' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => array(
                'rgb' => '3a2a47'
              )
            ),
            'bottom' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => array(
                'rgb' => '3a2a47'
              )
            )
          )
        )
);

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
$where .= " AND (soi.idef_soils is not null OR ent.idef_enteric is not null OR man.idef_manure is not null OR gra.idef_grassland_burning is not null OR res.idef_residue_burning is not null OR bio.idef_biomass is not null)";
// DB table to use
$select = '';

$select = " DISTINCT idexperiment, exp_name, exp_keywords, exp_brief_desc, exp_country, exp_province_state, exp_nearest_city, exp_latitude, exp_longitude, exp_year_began, exp_year_ended, exp_mean_annual_precipitation, exp_mean_annual_temperature, exp_soil_taxo_desc, exp_soil_taxo_sys, exp_soil_surface_tex, exp_min_water_depth, exp_soil_ph, exp_soil_org_matter, exp_soil_n, exp_init_soil_carbon, exp_key_findings ";

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
//$result = $wpdb->get_results($sql1, ARRAY_N);
//echo $result; exit();
$dataResult = $wpdb->get_results($sql1, ARRAY_A);
if (count($dataResult)) {
  // Create the PHPExcel Object
  $objPHPExcel = new PHPExcel();

  // Assign the book properties
  $objPHPExcel->getProperties()->setCreator("CCAFS CGIAR") //Autor
          ->setLastModifiedBy("CCAFS CGIAR")
          ->setTitle("emissions")
          ->setSubject("emissions")
          ->setDescription("emissions")
          ->setKeywords("emissions")
          ->setCategory("emissions");

  $titleReport = "Emissions Experiment";
  $titleColumnsExp = array('Experiment ID', 'Experiment Name', 'Experiment keywords', 'Brief Description', 'Country', 'Province/State', 'Nearest city', 'Latitude (decimal)', 'Longitude (decimal)', 'Year Experiment Began', 'Year Experiment Ended', 'Mean annual precipitation (mm)', 'Mean annual temperature (°C)', 'Soil Taxonomic Description', 'Soil Taxonomy System', 'Surface Soil Texture', 'Minimum Water Table Depth (m)', 'Soil pH', 'Soil organic matter (%)', 'Soil N (%)', 'Soil organic carbon (%)', 'Key Findings');
  $titleColumnsTreat = array('Experiment ID', 'Treatment ID', 'Treatment description', 'System', 'Tillage type', 'Synthetic N fertilizer type', 'Manure/ Amendment Type', 'Nitrogen rate (kg N ha-1 yr-1)', 'Method of application', 'Crop Rotation', 'Cover crop', 'Residue removal', 'Residue burning', 'Irrigation', 'Any other soils emissions abatement technologies used?', 'Grain', 'Stover', 'Roots', 'Other/notes', 'Type of rice ecosystem', 'Water management', 'Land preparation', 'Use of herbicides', 'Crop season', 'Number of growing days', 'Organic management (manure/rice straw incorporation)');
  $titleColumnsSoil = array('Experiment ID', 'Treatment ID', 'IPCC 1996', 'IPCC 2006', 'Gas', 'Crop', 'Gas sampling frequency', 'Type of emission factor', 'Depth of measurement (cm)', 'Value of EF', 'Units of EF', 'Equation', 'Lower bound of 95% CI', 'Upper bound of 95% CI', 'Uncertainty (expressed as 95% CI)', 'Notes');
  $titleColumnsEnt = array('Experiment ID', 'IPCC1996', 'IPCC2006', 'Gas', 'Type of emission factor', 'Type of livestock management system (pasture, feedlot, rangeland, combination)', 'Animal body weight (average)', 'Weight gain (average)', 'Subspecies classification', 'Feed quantity and accessibility (ad libitum)', 'Feed quality (describe)', 'Milk production (if dairy)', 'Mitigation technologies used', 'Value of EF', 'Units of EF', 'Equation', 'Lower bound of 95% CI', 'Upper bound of 95% CI', 'Notes');
  $titleColumnsMan = array('Experiment ID', 'IPCC1996', 'IPCC2006', 'Gas', 'Type of emission factor', 'Type of manure management system', 'Animal weight (avg)', 'Subspecies', 'Number of animals in operation', 'Operational conditions of system: retention time of waste, recycling of waste, solids separation', 'Diet and feed characteristics for animals', 'Mitigation technologies used', 'Value of EF', 'Units of EF', 'Equation', 'Lower bound of 95% CI', 'Upper bound of 95% CI', 'Notes');
  $titleColumnsGra = array('Experiment ID', 'IPCC1996', 'IPCC2006', 'Gas', 'Type of emission factor', 'Description of ecosystem', 'Density of fuel', 'Whether litter or living vegetation', 'Value of EF', 'Units of EF', 'Equation', 'Lower bound of 95% CI', 'Upper bound of 95% CI', 'Notes');
  $titleColumnsRes = array('Experiment ID', 'IPCC1996', 'IPCC2006', 'Type of emission factor', 'Type of crop', 'Area of crop', 'Crop yield', 'Crop season', 'Description of residue (e.g. biomass density at time of burning)', 'Value of EF', 'Units of EF', 'Equation', 'Lower bound of 95% CI', 'Upper bound of 95% CI', 'Notes');
  $titleColumnsBio = array('Experiment ID', 'IPCC1996', 'IPCC2006', 'Gas', 'Type of emission factor', 'Type of forest', 'Forest age', 'Management practices applied', 'Value of EF', 'Units of EF', 'Equation', 'Lower bound of 95% CI', 'Upper bound of 95% CI', 'Notes');

  $objPHPExcel->setActiveSheetIndex(0)
          ->mergeCells('A1:V1');

  // Add the titles
  $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A1', $titleReport)
          ->setCellValue('A3', $titleColumnsExp[0])
          ->setCellValue('B3', $titleColumnsExp[1])
          ->setCellValue('C3', $titleColumnsExp[2])
          ->setCellValue('D3', $titleColumnsExp[3])
          ->setCellValue('E3', $titleColumnsExp[4])
          ->setCellValue('F3', $titleColumnsExp[5])
          ->setCellValue('G3', $titleColumnsExp[6])
          ->setCellValue('H3', $titleColumnsExp[7])
          ->setCellValue('I3', $titleColumnsExp[8])
          ->setCellValue('J3', $titleColumnsExp[9])
          ->setCellValue('K3', $titleColumnsExp[10])
          ->setCellValue('L3', $titleColumnsExp[11])
          ->setCellValue('M3', $titleColumnsExp[12])
          ->setCellValue('N3', $titleColumnsExp[13])
          ->setCellValue('O3', $titleColumnsExp[14])
          ->setCellValue('P3', $titleColumnsExp[15])
          ->setCellValue('Q3', $titleColumnsExp[16])
          ->setCellValue('R3', $titleColumnsExp[17])
          ->setCellValue('S3', $titleColumnsExp[18])
          ->setCellValue('T3', $titleColumnsExp[19])
          ->setCellValue('U3', $titleColumnsExp[20])
          ->setCellValue('V3', $titleColumnsExp[21]);

  //Then add the data
  $i = 4;
  foreach ($dataResult as $row) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $row['idexperiment'])
            ->setCellValue('B' . $i, $row['exp_name'])
            ->setCellValue('C' . $i, $row['exp_keywords'])
            ->setCellValue('D' . $i, $row['exp_brief_desc'])
            ->setCellValue('E' . $i, $row['exp_country'])
            ->setCellValue('F' . $i, $row['exp_province_state'])
            ->setCellValue('G' . $i, $row['exp_nearest_city'])
            ->setCellValue('H' . $i, $row['exp_latitude'])
            ->setCellValue('I' . $i, $row['exp_longitude'])
            ->setCellValue('J' . $i, $row['exp_year_began'])
            ->setCellValue('K' . $i, $row['exp_year_ended'])
            ->setCellValue('L' . $i, $row['exp_mean_annual_precipitation'])
            ->setCellValue('M' . $i, $row['exp_mean_annual_temperature'])
            ->setCellValue('N' . $i, $row['exp_soil_taxo_desc'])
            ->setCellValue('O' . $i, $row['exp_soil_taxo_sys'])
            ->setCellValue('P' . $i, $row['exp_soil_surface_tex'])
            ->setCellValue('Q' . $i, $row['exp_min_water_depth'])
            ->setCellValue('R' . $i, $row['exp_soil_ph'])
            ->setCellValue('S' . $i, $row['exp_soil_org_matter'])
            ->setCellValue('T' . $i, $row['exp_soil_n'])
            ->setCellValue('U' . $i, $row['exp_init_soil_carbon'])
            ->setCellValue('V' . $i, $row['exp_key_findings']);
    $i++;
  }
  $objPHPExcel->setActiveSheetIndex(0);
  $objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray($titleStyle);
  $objPHPExcel->getActiveSheet()->getStyle('A3:V3')->applyFromArray($columnStyle);
  $objPHPExcel->getActiveSheet()->setSharedStyle($dataStyle, "A4:V" . ($i - 1));
  $objPHPExcel->getActiveSheet()->setSharedStyle($dataStyleLast, "A" . ($i - 1) . ":V" . ($i - 1));

  $select = " DISTINCT id_treatment, idexperiment, treat_desc, treat_system, treat_tillage_type, treat_synt_n_fert_type, treat_manure_amend_type, treat_nit_rate, treat_method_app, treat_crop_rotation, treat_cover_crop, treat_res_rem, treat_res_burn, treat_irrigation, treat_other_soil_emiss_tech, treat_grain, treat_stover, treat_roots, treat_notes, treatr_type_rice_eco, treatr_water_manage, treatr_land_prep, treatr_user_herb, treatr_crop_season, treatr_num_grow_days, treatr_org_manage ";
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
//$result = $wpdb->get_results($sql1, ARRAY_N);
//echo $result; exit();
  $dataResult = $wpdb->get_results($sql1, ARRAY_A);

  $titleReport = "Emissions Treatment";
  $objPHPExcel->createSheet();
  $objPHPExcel->setActiveSheetIndex(1)
          ->mergeCells('A1:Z1');

  // Add the titles
  $objPHPExcel->setActiveSheetIndex(1)
          ->setCellValue('A1', $titleReport)
          ->setCellValue('A3', $titleColumnsTreat[0])
          ->setCellValue('B3', $titleColumnsTreat[1])
          ->setCellValue('C3', $titleColumnsTreat[2])
          ->setCellValue('D3', $titleColumnsTreat[3])
          ->setCellValue('E3', $titleColumnsTreat[4])
          ->setCellValue('F3', $titleColumnsTreat[5])
          ->setCellValue('G3', $titleColumnsTreat[6])
          ->setCellValue('H3', $titleColumnsTreat[7])
          ->setCellValue('I3', $titleColumnsTreat[8])
          ->setCellValue('J3', $titleColumnsTreat[9])
          ->setCellValue('K3', $titleColumnsTreat[10])
          ->setCellValue('L3', $titleColumnsTreat[11])
          ->setCellValue('M3', $titleColumnsTreat[12])
          ->setCellValue('N3', $titleColumnsTreat[13])
          ->setCellValue('O3', $titleColumnsTreat[14])
          ->setCellValue('P3', $titleColumnsTreat[15])
          ->setCellValue('Q3', $titleColumnsTreat[16])
          ->setCellValue('R3', $titleColumnsTreat[17])
          ->setCellValue('S3', $titleColumnsTreat[18])
          ->setCellValue('T3', $titleColumnsTreat[19])
          ->setCellValue('U3', $titleColumnsTreat[20])
          ->setCellValue('V3', $titleColumnsTreat[21])
          ->setCellValue('W3', $titleColumnsTreat[22])
          ->setCellValue('X3', $titleColumnsTreat[23])
          ->setCellValue('Y3', $titleColumnsTreat[24])
          ->setCellValue('Z3', $titleColumnsTreat[25]);

  //Then add the data
  $i = 4;
  foreach ($dataResult as $row) {
    $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A' . $i, $row['idexperiment'])
            ->setCellValue('B' . $i, $row['id_treatment'])
            ->setCellValue('C' . $i, $row['treat_desc'])
            ->setCellValue('D' . $i, $row['treat_system'])
            ->setCellValue('E' . $i, $row['treat_tillage_type'])
            ->setCellValue('F' . $i, $row['treat_synt_n_fert_type'])
            ->setCellValue('G' . $i, $row['treat_manure_amend_type'])
            ->setCellValue('H' . $i, $row['treat_nit_rate'])
            ->setCellValue('I' . $i, $row['treat_method_app'])
            ->setCellValue('J' . $i, $row['treat_crop_rotation'])
            ->setCellValue('K' . $i, $row['treat_cover_crop'])
            ->setCellValue('L' . $i, $row['treat_res_rem'])
            ->setCellValue('M' . $i, $row['treat_res_burn'])
            ->setCellValue('N' . $i, $row['treat_irrigation'])
            ->setCellValue('O' . $i, $row['treat_other_soil_emiss_tech'])
            ->setCellValue('P' . $i, $row['treat_grain'])
            ->setCellValue('Q' . $i, $row['treat_stover'])
            ->setCellValue('R' . $i, $row['treat_roots'])
            ->setCellValue('S' . $i, $row['treat_notes'])
            ->setCellValue('T' . $i, $row['treatr_type_rice_eco'])
            ->setCellValue('U' . $i, $row['treatr_water_manage'])
            ->setCellValue('V' . $i, $row['treatr_land_prep'])
            ->setCellValue('W' . $i, $row['treatr_user_herb'])
            ->setCellValue('X' . $i, $row['treatr_crop_season'])
            ->setCellValue('Y' . $i, $row['treatr_num_grow_days'])
            ->setCellValue('Z' . $i, $row['treatr_org_manage']);
    $i++;
  }

  $objPHPExcel->setActiveSheetIndex(1);
  $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($titleStyle);
  $objPHPExcel->getActiveSheet()->getStyle('A3:Z3')->applyFromArray($columnStyle);
  $objPHPExcel->getActiveSheet()->setSharedStyle($dataStyle, "A4:Z" . ($i - 1));
  $objPHPExcel->getActiveSheet()->setSharedStyle($dataStyleLast, "A" . ($i - 1) . ":Z" . ($i - 1));

  $select = " idexperiment, exp_name, exp_keywords, exp_brief_desc, exp_country, exp_province_state, exp_nearest_city, exp_latitude, exp_longitude, exp_year_began, exp_year_ended, exp_mean_annual_precipitation, exp_mean_annual_temperature, exp_soil_taxo_desc, exp_soil_taxo_sys, exp_soil_surface_tex, exp_min_water_depth, exp_soil_ph, exp_soil_org_matter, exp_soil_n, exp_init_soil_carbon, exp_key_findings, id_treatment, treat_desc, treat_system, treat_tillage_type, treat_synt_n_fert_type, treat_manure_amend_type, treat_nit_rate, treat_method_app, treat_crop_rotation, treat_cover_crop, treat_res_rem, treat_res_burn, treat_irrigation, treat_other_soil_emiss_tech, treat_grain, treat_stover, treat_roots, treat_notes, treatr_type_rice_eco, treatr_water_manage, treatr_land_prep, treatr_user_herb, treatr_crop_season, treatr_num_grow_days, treatr_org_manage,  soi_ipcc_1996, soi_ipcc_2006, soi_gas, soi_crop, soi_gas_sampling_freq, soi_type_emission, soi_depth_measu, soi_ef_value, soi_ef_units, soi_equation, soi_lower_bound, soi_upper_bound, soi_uncertainty, soi_notes,  ent_ipcc_1996, ent_ipcc_2006, ent_gas, ent_type_emiss_fact, ent_type_livestock_manag_sys, ent_animal_bod_weight_ave, ent_weight_gain_ave, ent_subespecies_class, ent_feed_quant_access, ent_feed_quality, ent_milk_prod, ent_mitigation_tech, ent_ef_value, ent_ef_units, ent_equation, ent_lower_bound, ent_upper_bound, ent_notes,  man_ipcc_1996, man_ipcc_2006, man_gas, man_type_emiss_fact, man_type_manure_manag_sys, man_animal_weight, man_subspacies, man_num_animals_operation, man_operat_conditions, man_diet_feed_charact_anim, man_mitigation_tech, man_ef_value, man_ef_units, man_equation, man_lower_bound, man_upper_bound, man_notes,  gra_ipcc_1996, gra_ipcc_2006, gra_gas, gra_type_emiss_fact, gra_ecosyst_desc, gra_fuel_density, gra_whether_litter_liv_veg, gra_ef_value, gra_ef_units, gra_equation, gra_lower_bound, gra_upper_bound, gra_notes,  res_ipcc_1996, res_ipcc_2006, res_type_emiss_fact, res_type_crop, res_crop_area, res_crop_yield, res_crop_seasson, res_residue_desc, res_ef_value, res_ef_units, res_equation, res_lower_bound, res_upper_bound, res_notes,  bio_ipcc_1996, bio_ipcc_2006, bio_gas, bio_type_emiss_fact, bio_type_forest, bio_forest_age, bio_manag_pact_applied, bio_ef_value, bio_ef_units, bio_equation, bio_lower_bound, bio_upper_bound, bio_notes ";
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
  //$result = $wpdb->get_results($sql1, ARRAY_N);
  //echo $result; exit();
  $dataResult = $wpdb->get_results($sql1, ARRAY_A);

  $titleReport = "EF - Soils";
  $objPHPExcel->createSheet();
  $objPHPExcel->setActiveSheetIndex(2)
          ->mergeCells('A1:P1');

  // Add the titles
  $objPHPExcel->setActiveSheetIndex(2)
          ->setCellValue('A1', $titleReport)
          ->setCellValue('A3', $titleColumnsSoil[0])
          ->setCellValue('B3', $titleColumnsSoil[1])
          ->setCellValue('C3', $titleColumnsSoil[2])
          ->setCellValue('D3', $titleColumnsSoil[3])
          ->setCellValue('E3', $titleColumnsSoil[4])
          ->setCellValue('F3', $titleColumnsSoil[5])
          ->setCellValue('G3', $titleColumnsSoil[6])
          ->setCellValue('H3', $titleColumnsSoil[7])
          ->setCellValue('I3', $titleColumnsSoil[8])
          ->setCellValue('J3', $titleColumnsSoil[9])
          ->setCellValue('K3', $titleColumnsSoil[10])
          ->setCellValue('L3', $titleColumnsSoil[11])
          ->setCellValue('M3', $titleColumnsSoil[12])
          ->setCellValue('N3', $titleColumnsSoil[13])
          ->setCellValue('O3', $titleColumnsSoil[14])
          ->setCellValue('P3', $titleColumnsSoil[15]);

  //Then add the data
  $i = 4;
  foreach ($dataResult as $row) {
    $objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue('A' . $i, $row['idexperiment'])
            ->setCellValue('B' . $i, $row['id_treatment'])
            ->setCellValue('C' . $i, $row['soi_ipcc_1996'])
            ->setCellValue('D' . $i, $row['soi_ipcc_2006'])
            ->setCellValue('E' . $i, $row['soi_gas'])
            ->setCellValue('F' . $i, $row['soi_crop'])
            ->setCellValue('G' . $i, $row['soi_gas_sampling_freq'])
            ->setCellValue('H' . $i, $row['soi_type_emission'])
            ->setCellValue('I' . $i, $row['soi_depth_measu'])
            ->setCellValue('J' . $i, $row['soi_ef_value'])
            ->setCellValue('K' . $i, $row['soi_ef_units'])
            ->setCellValue('L' . $i, $row['soi_equation'])
            ->setCellValue('M' . $i, $row['soi_lower_bound'])
            ->setCellValue('N' . $i, $row['soi_upper_bound'])
            ->setCellValue('O' . $i, $row['soi_uncertainty'])
            ->setCellValue('P' . $i, $row['soi_notes']);
    $i++;
  }

  $objPHPExcel->setActiveSheetIndex(2);
  $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($titleStyle);
  $objPHPExcel->getActiveSheet()->getStyle('A3:P3')->applyFromArray($columnStyle);
  $objPHPExcel->getActiveSheet()->setSharedStyle($dataStyle, "A4:P" . ($i - 1));
  $objPHPExcel->getActiveSheet()->setSharedStyle($dataStyleLast, "A" . ($i - 1) . ":P" . ($i - 1));

  for ($i = 'A'; $i <= 'V'; $i++) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->getColumnDimension($i)->setAutoSize(TRUE);
  }

  for ($i = 'A'; $i <= 'Z'; $i++) {
    $objPHPExcel->setActiveSheetIndex(1)
            ->getColumnDimension($i)->setAutoSize(TRUE);
  }

  for ($i = 'A'; $i <= 'P'; $i++) {
    $objPHPExcel->setActiveSheetIndex(2)
            ->getColumnDimension($i)->setAutoSize(TRUE);
  }

  // Name of the Sheet
  $objPHPExcel->setActiveSheetIndex(0)->setTitle('Experiment');
  $objPHPExcel->setActiveSheetIndex(1)->setTitle('Treatment');
  $objPHPExcel->setActiveSheetIndex(2)->setTitle('EF - Soils');

  // Activate the Sheet, to show when the file opens.
//  $objPHPExcel->setActiveSheetIndex(0);
  // Inmovilize panels 
  $objPHPExcel->setActiveSheetIndex(0)->freezePane('A4');
  $objPHPExcel->setActiveSheetIndex(0)->freezePaneByColumnAndRow(0, 4);
  $objPHPExcel->setActiveSheetIndex(1)->freezePane('A4');
  $objPHPExcel->setActiveSheetIndex(1)->freezePaneByColumnAndRow(0, 4);
  $objPHPExcel->setActiveSheetIndex(2)->freezePane('A4');
  $objPHPExcel->setActiveSheetIndex(2)->freezePaneByColumnAndRow(0, 4);

  // Send the file to the browser, with the desire name(Excel2007)
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="emissions.xlsx"');
  header('Cache-Control: max-age=0');

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('php://output');
  exit;
} else {
  echo "<script language='javascript'>alert('No Data Found');</script>";
}
?>