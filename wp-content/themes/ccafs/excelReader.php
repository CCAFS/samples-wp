<?php

require('../../../wp-load.php');

/*
 * PHP Excel - Read a simple 2007 XLSX Excel file
 */

/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('America/Los_Angeles');
require_once ("/lib/PHPExcel/PHPExcel.php");
//include '/lib/PHPExcel/IOFactory.php';

$inputFileName = 'D:\My Documents\Sample F3 data\SAMPLES data input template_v4_test.xlsx';

//  Read your Excel workbook
try {
  $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
  $objPHPExcel = $objReader->load($inputFileName);
} catch (Exception $e) {
  die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
          . '": ' . $e->getMessage());
}

//  Get worksheet dimensions
$sheets = $objPHPExcel->getAllSheets();
foreach ($sheets as $key => $sheet) {
  if ($key != 0 && $key != 10) {
//$sheet = $objPHPExcel->getSheet(1);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
    $start = ($key == 4) ? 8 : 6;
    for ($row = $start; $row <= $highestRow; $row++) {
      //  Read a row of data into an array
      $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
      SheetProcess($key, $rowData[0]);
      foreach ($rowData[0] as $k => $v) {
//      if ($v)
//        echo "Row: " . $row . "- Col: " . ($k + 1) . " = " . $v . "<br />";
      }
    }
//  echo "//////////////////////////////////////////////////////////$key - ".$sheet->getTitle()."<br>";
  }
}

function SheetProcess($key, $sheet) {
  switch ($key) {
    case 1:
//      saveExpermient($sheet);
      break;
    case 2:
//      saveContact($sheet);
      break;
    case 3:
//      saveTreatment($sheet);
      break;
    case 4:
//      saveSoils($sheet);
      break;
    case 5:
//      saveEnteric($sheet);
      break;
    case 6:
//      saveManure($sheet);
      break;
    case 7:
//      saveGrassland($sheet);
      break;
    case 8:
//      saveResidue($sheet);
      break;
    case 9:
      saveBiomass($sheet);
      break;
  }
}

function saveExpermient($sheet) {
  global $wpdb;
//  echo "<pre>" . print_r($sheet, true) . "</pre>";
  $tablename = $wpdb->prefix . 'experiment';
  $columns = array(
    "-1" => "idexperiment_tec",
    "1" => "idexperiment",
    "0" => "exp_name",
    "2" => "exp_keywords",
    "3" => "exp_brief_desc",
    "4" => "exp_country",
    "5" => "exp_province_state",
    "6" => "exp_nearest_city",
    "7" => "exp_latitude",
    "8" => "exp_longitude",
    "9" => "exp_year_began",
    "10" => "exp_year_ended",
    "11" => "exp_mean_annual_precipitation",
    "12" => "exp_mean_annual_temperature",
    "13" => "exp_soil_taxo_desc",
    "14" => "exp_soil_taxo_sys",
    "15" => "exp_soil_surface_tex",
    "16" => "exp_min_water_depth",
    "17" => "exp_soil_ph",
    "18" => "exp_soil_org_matter",
    "19" => "exp_key_findings"
  );
  $experiment = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        if ($k == 7 || $k == 8) {
          $coord = explode(" ", $v);
          $experiment[$columns[$k]] = $coord[0];
        } else {
          $experiment[$columns[$k]] = $v;
        }
//        echo "Col: " . ($k + 1) . " = " . $v . "<br />";
      }
    }
    $rows_affected = $wpdb->insert($tablename, $experiment);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($experiment, true) . "</pre>";
//  echo "//////////////////////<br>";
}

function saveContact($sheet) {
  global $wpdb;

  $tablename = $wpdb->prefix . 'contact_info';
  $columns = array(
    "-1" => "idcontact_info",
    "2" => "cont_journal_citation",
    "3" => "cont_email_primary",
    "4" => "cont_where_assoc_downloaded",
    "1" => "wp_experiment_idexperiment"
  );
  $contact = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        $contact[$columns[$k]] = $v;
      }
    }
    $rows_affected = $wpdb->insert($tablename, $contact);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($contact, true) . "</pre>";
}

function saveTreatment($sheet) {
  global $wpdb;

  $tablename = $wpdb->prefix . 'treatment';
  $columns = array(
    "-1" => "wp_treat_consec",
    "1" => "id_treatment",
    "2" => "treat_desc",
    "3" => "treat_system",
    "4" => "treat_tillage_type",
    "5" => "treat_synt_n_fert_type",
    "6" => "treat_manure_amend_type",
    "7" => "treat_nit_rate",
    "8" => "treat_method_app",
    "9" => "treat_crop1",
    "10" => "treat_crop1_variety",
    "11" => "treat_crop2",
    "12" => "treat_crop3",
    "13" => "treat_cover_crop",
    "14" => "treat_res_manage", /**/
    "15" => "treat_irrigation",
    "16" => "treat_other_mitig_pract", /**/
    "17" => "treat_grain",
    "18" => "treat_stover",
    "19" => "treat_roots",
    "27" => "treat_notes",
    "22" => "treatr_crop_establish",
    "20" => "treatr_water_manage",
    "21" => "treatr_land_prep",
    "23" => "treatr_user_herb",
    "24" => "treatr_crop_season",
    "25" => "treatr_num_grow_days",
    "26" => "treatr_org_manage",
    "0" => "wp_experiment_idexperiment"
  );
  $contact = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        $contact[$columns[$k]] = $v;
      }
    }
    $rows_affected = $wpdb->insert($tablename, $contact);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($contact, true) . "</pre>";
}

function saveSoils($sheet) {
  global $wpdb;

  $tablename = $wpdb->prefix . 'ef_soils';
  $columns = array(
    "-1" => "idef_soils",
    "2" => "soi_ipcc_1996",
    "3" => "soi_ipcc_2006",
    "4" => "soi_gas",
    "5" => "soi_crop",
    "6" => "soi_gas_sampling_freq",
    "7" => "soi_type_emission",
    "8" => "soi_depth_measu",
    "9" => "soi_ef_value",
    "10" => "soi_ef_units",
    "111" => "soi_equation",
    "12" => "soi_lower_bound",
    "13" => "soi_upper_bound",
    "14" => "soi_uncertainty",
    "15" => "soi_notes",
    "1" => "wp_treatment_id_treatment"
  );
  $contact = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        $contact[$columns[$k]] = $v;
      }
    }
    $rows_affected = $wpdb->insert($tablename, $contact);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($contact, true) . "</pre>";
}

function saveEnteric($sheet) {
  global $wpdb;

  $tablename = $wpdb->prefix . 'ef_enteric';
  $columns = array(
    "1" => "ent_ipcc_1996",
    "2" => "ent_ipcc_2006",
    "3" => "ent_gas",
    "4" => "ent_type_emiss_fact",
    "5" => "ent_type_livestock_manag_sys",
    "6" => "ent_animal_bod_weight_ave",
    "7" => "ent_weight_gain_ave",
    "8" => "ent_subespecies_class",
    "9" => "ent_feed_quant_access",
    "10" => "ent_feed_quality",
    "11" => "ent_milk_prod",
    "12" => "ent_mitigation_tech",
    "13" => "ent_ef_value",
    "14" => "ent_ef_units",
    "15" => "ent_equation",
    "16" => "ent_lower_bound",
    "17" => "ent_upper_bound",
    "18" => "ent_notes",
    "0" => "wp_experiment_idexperiment"
  );
  $contact = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        $contact[$columns[$k]] = $v;
      }
    }
    $rows_affected = $wpdb->insert($tablename, $contact);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($contact, true) . "</pre>";
}

function saveManure($sheet) {
  global $wpdb;

  $tablename = $wpdb->prefix . 'ef_manure';
  $columns = array(
    "1" => "man_ipcc_1996",
    "2" => "man_ipcc_2006",
    "3" => "man_gas",
    "4" => "man_type_emiss_fact",
    "5" => "man_type_manure_manag_sys",
    "6" => "man_animal_weight",
    "7" => "man_subspacies",
    "8" => "man_num_animals_operation",
    "9" => "man_operat_conditions",
    "10" => "man_diet_feed_charact_anim",
    "11" => "man_mitigation_tech",
    "12" => "man_ef_value",
    "13" => "man_ef_units",
    "14" => "man_equation",
    "15" => "man_lower_bound",
    "16" => "man_upper_bound",
    "17" => "man_notes",
    "0" => "wp_experiment_idexperiment"
  );
  $contact = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        $contact[$columns[$k]] = $v;
      }
    }
    $rows_affected = $wpdb->insert($tablename, $contact);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($contact, true) . "</pre>";
}

function saveGrassland($sheet) {
  global $wpdb;

  $tablename = $wpdb->prefix . 'ef_grassland_burning';
  $columns = array(
    "1" => "gra_ipcc_1996",
    "2" => "gra_ipcc_2006",
    "3" => "gra_gas",
    "4" => "gra_type_emiss_fact",
    "5" => "gra_ecosyst_desc",
    "6" => "gra_fuel_density",
    "7" => "gra_whether_litter_liv_veg",
    "8" => "gra_ef_value",
    "9" => "gra_ef_units",
    "10" => "gra_equation",
    "11" => "gra_lower_bound",
    "12" => "gra_upper_bound",
    "13" => "gra_notes",
    "0" => "wp_experiment_idexperiment"
  );
  $contact = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        $contact[$columns[$k]] = $v;
      }
    }
    $rows_affected = $wpdb->insert($tablename, $contact);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($contact, true) . "</pre>";
}

function saveResidue($sheet) {
  global $wpdb;

  $tablename = $wpdb->prefix . 'ef_residue_burning';
  $columns = array(
    "1" => "res_ipcc_1996",
    "2" => "res_ipcc_2006",
    "3" => "res_gas",
    "4" => "res_type_emiss_fact",
    "5" => "res_type_crop",
    "6" => "res_crop_area",
    "7" => "res_crop_yield",
    "8" => "res_crop_seasson",
    "9" => "res_residue_desc",
    "10" => "res_ef_value",
    "11" => "res_ef_units",
    "12" => "res_equation",
    "13" => "res_lower_bound",
    "14" => "res_upper_bound",
    "15" => "res_notes",
    "0" => "wp_experiment_idexperiment"
  );
  $contact = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        $contact[$columns[$k]] = $v;
      }
    }
    $rows_affected = $wpdb->insert($tablename, $contact);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($contact, true) . "</pre>";
}

function saveBiomass($sheet) {
  global $wpdb;

  $tablename = $wpdb->prefix . 'ef_biomass';
  $columns = array(
    "1" => "bio_ipcc_1996",
    "2" => "bio_ipcc_2006",
    "3" => "bio_gas",
    "4" => "bio_type_emiss_fact",
    "5" => "bio_type_forest",
    "6" => "bio_forest_age",
    "7" => "bio_manag_pact_applied",
    "8" => "bio_ef_value",
    "9" => "bio_ef_units",
    "10" => "bio_equation",
    "11" => "bio_lower_bound",
    "12" => "bio_upper_bound",
    "13" => "bio_notes",
    "0" => "wp_experiment_idexperiment"
  );
  $contact = array();
  if ($sheet[1] != '') {
    foreach ($sheet as $k => $v) {
      if ($v && $columns[$k]) {
        $contact[$columns[$k]] = $v;
      }
    }
    $rows_affected = $wpdb->insert($tablename, $contact);
    if (!$rows_affected) {
      $wpdb->show_errors();
      $wpdb->print_error();
    } else {
//    $tablename = $wpdb->prefix . 'article';
//    $wpdb->update($tablename, array('status' => '0'), array('id' => $_GET['article']));
    }
  }
//  echo "<pre>" . print_r($contact, true) . "</pre>";
}

?>