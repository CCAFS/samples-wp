<?php

/*
 * Copyright (C) 2015 CRSANCHEZ
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
require('../../../wp-load.php');
$region = $_REQUEST['region'];
$country = $_REQUEST['country'];
$ipcc1996 = $_REQUEST['ipcc1996'];
$ipcc2006 = $_REQUEST['ipcc2006'];
$source = $_REQUEST['source'];
$where = "  ";

if ($region != "" && $region != 'null' && $region != 'all') {
  $where .= " AND exp.exp_country IN (SELECT a.cny_name FROM wp_country a INNER JOIN wp_continent b ON (a.wp_continent_id_continent = b.id_continent AND b.cnt_name like '".$region."')) ";
}
if ($country != 'null' && $country!= '') {
  $where .= " AND exp.exp_country like '%" . $country . "%' ";
}
// DB table to use
$limit = 'LIMIT ' . $_REQUEST['start'] . ',' . $_REQUEST['length'];
$select = '';
if (isset($_REQUEST['allfields'])) {
  $select = " * ";
} elseif (isset($_REQUEST['soils'])) {
  $select = " exp.exp_country,"
          . " concat('Soils: ', soi.soi_crop),"
          . " soi.soi_type_emission,"
          . " ROUND(soi.soi_ef_value, 2) as ef_value,"
          . " soi.soi_ef_units,"
          . " soi.soi_ipcc_1996,"
          . " soi.soi_ipcc_2006";
  $where .= " AND soi.idef_soils is not null ";
  if ($ipcc1996!= 'null' && $ipcc1996!= '' && $ipcc1996 != 'all') {
    $ipcc1996 = explode(' ',$ipcc1996);
    $where .= " AND soi.soi_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006!= 'null' && $ipcc2006!= '' && $ipcc2006 != 'all') {
    $ipcc2006 = explode(' ',$ipcc2006);
    $where .= " AND soi.soi_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  }
} elseif (isset($_REQUEST['enteric'])) {
  $select = " exp.exp_brief_desc,"
          . " exp.exp_country,"
          . " exp.exp_nearest_city,"
          . " ent.ent_ipcc_1996,"
          . " ent.ent_ipcc_2006,"
          . " ent.ent_subespecies_class,"
          . " ent.ent_type_livestock_manag_sys,"
          . " ent.ent_gas,"
          . " ent.ent_mitigation_tech,"
          . " ent.ent_type_emission,"
          . " ent.ent_ef_value,"
          . " ent.ent_ef_units";
  $where .= " AND ent.idef_enteric is not null ";
  if ($ipcc1996!= 'null' && $ipcc1996!= '' && $ipcc1996 != 'all') {
    $ipcc1996 = explode(' ',$ipcc1996);
    $where .= " AND ent.ent_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006!= 'null' && $ipcc2006!= '' && $ipcc2006 != 'all') {
    $ipcc2006 = explode(' ',$ipcc2006);
    $where .= " AND ent.ent_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  }
} elseif (isset($_REQUEST['manure'])) {
  $select = " exp.exp_brief_desc,"
          . " exp.exp_country,"
          . " exp.exp_nearest_city,"
          . " man.man_ipcc_1996,"
          . " man.man_ipcc_2006,"
          . " man.man_subespecies,"
          . " man.man_type_manure_manag_sys,"
          . " man.man_gas,"
          . " man.man_mitigation_tech,"
          . " man.man_type_emiss_fact,"
          . " man.man_ef_value,"
          . " man.man_ef_units";
  $where .= " AND man.idef_manure is not null ";
  if ($ipcc1996!= 'null' && $ipcc1996!= '' && $ipcc1996 != 'all') {
    $ipcc1996 = explode(' ',$ipcc1996);
    $where .= " AND man.man_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006!= 'null' && $ipcc2006!= '' && $ipcc2006 != 'all') {
    $ipcc2006 = explode(' ',$ipcc2006);
    $where .= " AND man.man_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  }
} elseif (isset($_REQUEST['grassland'])) {
  $select = " exp.exp_brief_desc,"
          . " exp.exp_country,"
          . " exp.exp_nearest_city,"
          . " gra.gra_ipcc_1996,"
          . " gra.gra_ipcc_2006,"
          . " gra.gra_ecosyst_desc,"
          . " gra.gra_gas,"
          . " gra.gra_type_emiss_fact,"
          . " gra.gra_ef_value,"
          . " gra.gra_ef_units";
  $where .= " AND gra.idef_grassland_burning is not null ";
  if ($ipcc1996!= 'null' && $ipcc1996!= '') {
    $ipcc1996 = explode(' ',$ipcc1996);
    $where .= " AND gra.gra_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006!= 'null' && $ipcc2006!= '') {
    $ipcc2006 = explode(' ',$ipcc2006);
    $where .= " AND gra.gra_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  }
} elseif (isset($_REQUEST['residue'])) {
  $select = " exp.exp_brief_desc,"
          . " exp.exp_country,"
          . " exp.exp_nearest_city,"
          . " res.res_ipcc_1996,"
          . " res.res_ipcc_2006,"
          . " res.res_type_crop,"
          . " res.res_gas,"
          . " res.res_type_emiss_fact,"
          . " res.res_ef_value,"
          . " res.res_ef_units";
  $where .= " AND res.idef_residue_burning is not null ";
  if ($ipcc1996!= 'null' && $ipcc1996!= '') {
    $ipcc1996 = explode(' ',$ipcc1996);
    $where .= " AND res.res_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006!= 'null' && $ipcc2006!= '') {
    $ipcc2006 = explode(' ',$ipcc2006);
    $where .= " AND res.res_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  }
} elseif (isset($_REQUEST['biomass'])) {
  $select = " exp.exp_brief_desc,"
          . " exp.exp_country,"
          . " exp.exp_nearest_city,"
          . " bio.bio_ipcc_1996,"
          . " bio.bio_ipcc_2006,"
          . " bio.bio_type_forest,"
          . " bio.bio_gas,"
          . " bio.bio_type_emiss_fact,"
          . " bio.bio_ef_value,"
          . " bio.bio_ef_units ";
  $where .= " AND bio.idef_biomass is not null ";
  if ($ipcc1996!= 'null' && $ipcc1996!= '') {
    $ipcc1996 = explode(' ',$ipcc1996);
    $where .= " AND bio.bio_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006!= 'null' && $ipcc2006!= '') {
    $ipcc2006 = explode(' ',$ipcc2006);
    $where .= " AND bio.bio_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  }
}

$sql1 = "SELECT count(*) as total"
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
//echo $sql1;
$result = $wpdb->get_row($sql1);

$total_rows = $result->total;

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
        . $where
        . " ORDER BY exp.idexperiment_tec $limit";
//  echo $sql1;
$result = $wpdb->get_results($sql1, ARRAY_N);

echo json_encode(
        array(
//          "draw"=> 1,
          "recordsTotal" => $total_rows,
          "recordsFiltered" => $total_rows,
          "data" => $result
        )
);

