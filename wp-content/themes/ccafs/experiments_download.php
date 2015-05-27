<?php

require('../../../wp-load.php');
global $wpdb;
// This needs to be set, in order for the script work, 
//in the case when the request variable is empty, throws 
//an e_notice of the empty array
//error_reporting(0);


require_once ("/lib/PHPExcel/PHPExcel.php");
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

if ($region != "" && $region != 'null' && $region != 'all') {
  $where .= " AND exp.exp_country IN (SELECT a.cny_name FROM wp_country a INNER JOIN wp_continent b ON (a.wp_continent_id_continent = b.id_continent AND b.cnt_name like '" . $region . "')) ";
}
if ($country != 'null' && $country != '') {
  $where .= " AND exp.exp_country like '%" . $country . "%' ";
}
// DB table to use
$select = '';

$select = " idexperiment, exp_name, exp_keywords, exp_brief_desc, exp_country, exp_province_state, exp_nearest_city, exp_latitude, exp_longitude, exp_year_began, exp_year_ended, exp_mean_annual_precipitation, exp_mean_annual_temperature, exp_soil_taxo_desc, exp_soil_taxo_sys, exp_soil_surface_tex, exp_min_water_depth, exp_soil_ph, exp_soil_org_matter, exp_soil_n, exp_init_soil_carbon, exp_key_findings, id_treatment, treat_desc, treat_system, treat_tillage_type, treat_synt_n_fert_type, treat_manure_amend_type, treat_nit_rate, treat_method_app, treat_crop_rotation, treat_cover_crop, treat_res_rem, treat_res_burn, treat_irrigation, treat_other_soil_emiss_tech, treat_grain, treat_stover, treat_roots, treat_notes, treatr_type_rice_eco, treatr_water_manage, treatr_land_prep, treatr_user_herb, treatr_crop_season, treatr_num_grow_days, treatr_org_manage,  soi_ipcc_1996, soi_ipcc_2006, soi_gas, soi_crop, soi_gas_sampling_freq, soi_type_emission, soi_depth_measu, soi_ef_value, soi_ef_units, soi_equation, soi_lower_bound, soi_upper_bound, soi_uncertainty, soi_notes,  ent_ipcc_1996, ent_ipcc_2006, ent_gas, ent_type_emiss_fact, ent_type_livestock_manag_sys, ent_animal_bod_weight_ave, ent_weight_gain_ave, ent_subespecies_class, ent_feed_quant_access, ent_feed_quality, ent_milk_prod, ent_mitigation_tech, ent_ef_value, ent_ef_units, ent_equation, ent_lower_bound, ent_upper_bound, ent_notes,  man_ipcc_1996, man_ipcc_2006, man_gas, man_type_emiss_fact, man_type_manure_manag_sys, man_animal_weight, man_subspacies, man_num_animals_operation, man_operat_conditions, man_diet_feed_charact_anim, man_mitigation_tech, man_ef_value, man_ef_units, man_equation, man_lower_bound, man_upper_bound, man_notes,  gra_ipcc_1996, gra_ipcc_2006, gra_gas, gra_type_emiss_fact, gra_ecosyst_desc, gra_fuel_density, gra_whether_litter_liv_veg, gra_ef_value, gra_ef_units, gra_equation, gra_lower_bound, gra_upper_bound, gra_notes,  res_ipcc_1996, res_ipcc_2006, res_type_emiss_fact, res_type_crop, res_crop_area, res_crop_yield, res_crop_seasson, res_residue_desc, res_ef_value, res_ef_units, res_equation, res_lower_bound, res_upper_bound, res_notes,  bio_ipcc_1996, bio_ipcc_2006, bio_gas, bio_type_emiss_fact, bio_type_forest, bio_forest_age, bio_manag_pact_applied, bio_ef_value, bio_ef_units, bio_equation, bio_lower_bound, bio_upper_bound, bio_notes ";

$sql1 = "SELECT "
        . $select
        . " FROM wp_experiment exp "
        . " LEFT JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
        . " LEFT JOIN wp_ef_soils soi ON soi.wp_treatment_id_treatment=tre.id_treatment "
        . " LEFT JOIN wp_ef_enteric ent ON ent.wp_experiment_idexperiment=exp.idexperiment "
        . " LEFT JOIN wp_ef_manure man ON man.wp_experiment_idexperiment=exp.idexperiment "
        . " LEFT JOIN wp_ef_grassland_burning gra ON gra.wp_experiment_idexperiment=exp.idexperiment "
        . " LEFT JOIN wp_ef_residue_burning res ON res.wp_experiment_idexperiment=exp.idexperiment "
        . " LEFT JOIN wp_ef_biomass bio ON bio.wp_experiment_idexperiment=exp.idexperiment "
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

  $titleReport = "Emissions";
  $titleColumns = array('idexperiment','exp_name','exp_keywords','exp_brief_desc','exp_country','exp_province_state','exp_nearest_city','exp_latitude','exp_longitude','exp_year_began','exp_year_ended','exp_mean_annual_precipitation','exp_mean_annual_temperature','exp_soil_taxo_desc','exp_soil_taxo_sys','exp_soil_surface_tex','exp_min_water_depth','exp_soil_ph','exp_soil_org_matter','exp_soil_n','exp_init_soil_carbon','exp_key_findings','id_treatment','treat_desc','treat_system','treat_tillage_type','treat_synt_n_fert_type','treat_manure_amend_type','treat_nit_rate','treat_method_app','treat_crop_rotation','treat_cover_crop','treat_res_rem','treat_res_burn','treat_irrigation','treat_other_soil_emiss_tech','treat_grain','treat_stover','treat_roots','treat_notes','treatr_type_rice_eco','treatr_water_manage','treatr_land_prep','treatr_user_herb','treatr_crop_season','treatr_num_grow_days','treatr_org_manage','soi_ipcc_1996','soi_ipcc_2006','soi_gas','soi_crop','soi_gas_sampling_freq','soi_type_emission','soi_depth_measu','soi_ef_value','soi_ef_units','soi_equation','soi_lower_bound','soi_upper_bound','soi_uncertainty','soi_notes','ent_ipcc_1996','ent_ipcc_2006','ent_gas','ent_type_emiss_fact','ent_type_livestock_manag_sys','ent_animal_bod_weight_ave','ent_weight_gain_ave','ent_subespecies_class','ent_feed_quant_access','ent_feed_quality','ent_milk_prod','ent_mitigation_tech','ent_ef_value','ent_ef_units','ent_equation','ent_lower_bound','ent_upper_bound','ent_notes','man_ipcc_1996','man_ipcc_2006','man_gas','man_type_emiss_fact','man_type_manure_manag_sys','man_animal_weight','man_subspacies','man_num_animals_operation','man_operat_conditions','man_diet_feed_charact_anim','man_mitigation_tech','man_ef_value','man_ef_units','man_equation','man_lower_bound','man_upper_bound','man_notes','gra_ipcc_1996','gra_ipcc_2006','gra_gas','gra_type_emiss_fact','gra_ecosyst_desc','gra_fuel_density','gra_whether_litter_liv_veg','gra_ef_value','gra_ef_units','gra_equation','gra_lower_bound','gra_upper_bound','gra_notes','res_ipcc_1996','res_ipcc_2006','res_type_emiss_fact','res_type_crop','res_crop_area','res_crop_yield','res_crop_seasson','res_residue_desc','res_ef_value','res_ef_units','res_equation','res_lower_bound','res_upper_bound','res_notes','bio_ipcc_1996','bio_ipcc_2006','bio_gas','bio_type_emiss_fact','bio_type_forest','bio_forest_age','bio_manag_pact_applied','bio_ef_value','bio_ef_units','bio_equation','bio_lower_bound','bio_upper_bound','bio_notes');

  $objPHPExcel->setActiveSheetIndex(0)
          ->mergeCells('A1:AM1');

  // Add the titles
  $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A1', $titleReport)
          ->setCellValue('A3', $titleColumns[0])
          ->setCellValue('B3', $titleColumns[1])
          ->setCellValue('C3', $titleColumns[2])
          ->setCellValue('D3', $titleColumns[3])
          ->setCellValue('E3', $titleColumns[4])
          ->setCellValue('F3', $titleColumns[5])
          ->setCellValue('G3', $titleColumns[6])
          ->setCellValue('H3', $titleColumns[7])
          ->setCellValue('I3', $titleColumns[8])
          ->setCellValue('J3', $titleColumns[9])
          ->setCellValue('K3', $titleColumns[10])
          ->setCellValue('L3', $titleColumns[11])
          ->setCellValue('M3', $titleColumns[12])
          ->setCellValue('N3', $titleColumns[13])
          ->setCellValue('O3', $titleColumns[14])
          ->setCellValue('P3', $titleColumns[15])
          ->setCellValue('Q3', $titleColumns[16])
          ->setCellValue('R3', $titleColumns[17])
          ->setCellValue('S3', $titleColumns[18])
          ->setCellValue('T3', $titleColumns[19])
          ->setCellValue('U3', $titleColumns[20])
          ->setCellValue('V3', $titleColumns[21])
          ->setCellValue('W3', $titleColumns[22])
          ->setCellValue('X3', $titleColumns[23])
          ->setCellValue('Y3', $titleColumns[24])
          ->setCellValue('Z3', $titleColumns[25])
          ->setCellValue('AA3', $titleColumns[26])
          ->setCellValue('AB3', $titleColumns[27])
          ->setCellValue('AC3', $titleColumns[28])
          ->setCellValue('AD3', $titleColumns[29])
          ->setCellValue('AE3', $titleColumns[30])
          ->setCellValue('AF3', $titleColumns[31])
          ->setCellValue('AG3', $titleColumns[32])
          ->setCellValue('AH3', $titleColumns[33])
          ->setCellValue('AI3', $titleColumns[34])
          ->setCellValue('AJ3', $titleColumns[35])
          ->setCellValue('AK3', $titleColumns[36])
          ->setCellValue('AL3', $titleColumns[37])
          ->setCellValue('AM3', $titleColumns[38]);

  //Then add the data
  $i = 4;
  foreach ($dataResult as $row) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $row['doi_article'])
            ->setCellValue('B' . $i, $row['author'])
            ->setCellValue('C' . $i, $row['year'])
            ->setCellValue('D' . $i, $row['journal'])
            ->setCellValue('E' . $i, $row['volume'])
            ->setCellValue('F' . $i, $row['issue'])
            ->setCellValue('G' . $i, $row['page_start'])
            ->setCellValue('H' . $i, $row['page_end'])
            ->setCellValue('I' . $i, $row['reference'])
            ->setCellValue('J' . $i, $row['paper_title'])
            ->setCellValue('K' . $i, $row['crop'])
            ->setCellValue('L' . $i, $row['scientific_name'])
            ->setCellValue('M' . $i, $row['projection_co2'])
            ->setCellValue('N' . $i, $row['baseline_co2'])
            ->setCellValue('O' . $i, $row['temp_change'])
            ->setCellValue('P' . $i, $row['precipitation_change'])
            ->setCellValue('Q' . $i, $row['yield_change'])
            ->setCellValue('R' . $i, $row['projec_yield_change_start'])
            ->setCellValue('S' . $i, $row['project_yield_change_end'])
            ->setCellValue('T' . $i, $row['adaptation'])
            ->setCellValue('U' . $i, $row['climate_scenario'])
            ->setCellValue('V' . $i, $row['num_gcm_used'])
            ->setCellValue('W' . $i, $row['gcm'])
            ->setCellValue('X' . $i, $row['num_impact_model_used'])
            ->setCellValue('Y' . $i, $row['impact_models'])
            ->setCellValue('Z' . $i, $row['base_line_start'])
            ->setCellValue('AA' . $i, $row['base_line_end'])
            ->setCellValue('AB' . $i, $row['projection_start'])
            ->setCellValue('AC' . $i, $row['projection_end'])
            ->setCellValue('AD' . $i, $row['geo_scope'])
            ->setCellValue('AE' . $i, $row['region'])
            ->setCellValue('AF' . $i, $row['country'])
            ->setCellValue('AG' . $i, $row['state'])
            ->setCellValue('AH' . $i, $row['city'])
            ->setCellValue('AI' . $i, $row['latitude'])
            ->setCellValue('AJ' . $i, $row['longitude'])
            ->setCellValue('AK' . $i, $row['spatial_scale'])
            ->setCellValue('AL' . $i, $row['comments'])
            ->setCellValue('AM' . $i, $row['contributor']);
    $i++;
  }

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

  $objPHPExcel->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($titleStyle);
  $objPHPExcel->getActiveSheet()->getStyle('A3:AM3')->applyFromArray($columnStyle);
  $objPHPExcel->getActiveSheet()->setSharedStyle($dataStyle, "A4:AM" . ($i - 1));

  for ($i = 'A'; $i <= 'AM'; $i++) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->getColumnDimension($i)->setAutoSize(TRUE);
  }

  // Name of the Sheet
  $objPHPExcel->getActiveSheet()->setTitle('Estimate');

  // Activate the Sheet, to show when the file opens.
  $objPHPExcel->setActiveSheetIndex(0);
  // Inmovilize panels 
  $objPHPExcel->getActiveSheet(0)->freezePane('A4');
  $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);

  // Send the file to the browser, with the desire name(Excel2007)
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Crop_Estimate.xlsx"');
  header('Cache-Control: max-age=0');

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('php://output');
  exit;
} else {
  echo "<script language='javascript'>alert('No Data Found');</script>";
}
?>