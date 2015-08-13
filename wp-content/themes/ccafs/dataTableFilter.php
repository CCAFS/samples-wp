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
$orderCol = $_REQUEST['order'][0]['column'] + 1;
$orderDir = $_REQUEST['order'][0]['dir'];
$where = " ";
$order = " ORDER BY exp.idexperiment_tec ";

if ($region != "" && $region != 'null' && $region != 'all') {
  $where .= " AND exp.exp_country IN (SELECT a.cny_name FROM wp_country a INNER JOIN wp_continent b ON (a.wp_continent_id_continent = b.id_continent AND b.cnt_name like '" . trim($region) . "')) ";
}
if ($country != 'null' && $country != '') {
  $where .= " AND exp.exp_country like '%" . trim($country) . "%' ";
}
// DB table to use
$limit = 'LIMIT ' . $_REQUEST['start'] . ',' . $_REQUEST['length'];
if ($orderCol) {
  $order = " ORDER BY " . $orderCol . " " . $orderDir;
}
$select = '';
if (isset($_REQUEST['allfields'])) {
  $sqlCount = "SELECT count(*) as total"
          . " FROM wp_experiment exp "
          . " LEFT JOIN wp_contact_info cnt ON (cnt.wp_experiment_idexperiment=exp.idexperiment)"
          . " LEFT JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_soils soi ON soi.wp_treatment_id_treatment=tre.id_treatment "
          . " LEFT JOIN wp_ef_enteric ent ON ent.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_manure man ON man.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_grassland_burning gra ON gra.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_residue_burning res ON res.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_biomass bio ON bio.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 "
          . $where;

  $select = " idexperiment, exp_name, exp_keywords, exp_brief_desc, exp_country, exp_province_state, exp_nearest_city, exp_latitude, exp_longitude, exp_year_began, exp_year_ended, exp_mean_annual_precipitation, exp_mean_annual_temperature, exp_soil_taxo_desc, exp_soil_taxo_sys, exp_soil_surface_tex, exp_min_water_depth, exp_soil_ph, exp_soil_org_matter, exp_key_findings, id_treatment, treat_desc, treat_system, treat_tillage_type, treat_synt_n_fert_type, treat_manure_amend_type, treat_nit_rate, treat_method_app, treat_cover_crop, treat_res_manage, treat_irrigation, treat_other_mitig_pract, treat_grain, treat_stover, treat_roots, treat_notes, treatr_water_manage, treatr_land_prep, treatr_user_herb, treatr_crop_season, treatr_num_grow_days, treatr_org_manage,  soi_ipcc_1996, soi_ipcc_2006, soi_gas, soi_crop, soi_gas_sampling_freq, soi_type_emission, soi_depth_measu, soi_ef_value, soi_ef_units, soi_equation, soi_lower_bound, soi_upper_bound, soi_uncertainty, soi_notes,  ent_ipcc_1996, ent_ipcc_2006, ent_gas, ent_type_emiss_fact, ent_type_livestock_manag_sys, ent_animal_bod_weight_ave, ent_weight_gain_ave, ent_subespecies_class, ent_feed_quant_access, ent_feed_quality, ent_milk_prod, ent_mitigation_tech, ent_ef_value, ent_ef_units, ent_equation, ent_lower_bound, ent_upper_bound, ent_notes,  man_ipcc_1996, man_ipcc_2006, man_gas, man_type_emiss_fact, man_type_manure_manag_sys, man_animal_weight, man_subspacies, man_num_animals_operation, man_operat_conditions, man_diet_feed_charact_anim, man_mitigation_tech, man_ef_value, man_ef_units, man_equation, man_lower_bound, man_upper_bound, man_notes,  gra_ipcc_1996, gra_ipcc_2006, gra_gas, gra_type_emiss_fact, gra_ecosyst_desc, gra_fuel_density, gra_whether_litter_liv_veg, gra_ef_value, gra_ef_units, gra_equation, gra_lower_bound, gra_upper_bound, gra_notes,  res_ipcc_1996, res_ipcc_2006, res_type_emiss_fact, res_type_crop, res_crop_area, res_crop_yield, res_crop_seasson, res_residue_desc, res_ef_value, res_ef_units, res_equation, res_lower_bound, res_upper_bound, res_notes,  bio_ipcc_1996, bio_ipcc_2006, bio_gas, bio_type_emiss_fact, bio_type_forest, bio_forest_age, bio_manag_pact_applied, bio_ef_value, bio_ef_units, bio_equation, bio_lower_bound, bio_upper_bound, bio_notes,cont_email_primary,cont_journal_citation ";
  $sql = "SELECT "
          . $select
          . " FROM wp_experiment exp "
          . " LEFT JOIN wp_contact_info cnt ON (cnt.wp_experiment_idexperiment=exp.idexperiment)"
          . " LEFT JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_soils soi ON soi.wp_treatment_id_treatment=tre.id_treatment "
          . " LEFT JOIN wp_ef_enteric ent ON ent.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_manure man ON man.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_grassland_burning gra ON gra.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_residue_burning res ON res.wp_experiment_idexperiment=exp.idexperiment "
          . " LEFT JOIN wp_ef_biomass bio ON bio.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 "
          . $where
          . $order . " " . $limit;
//  echo $sql."\n";
} /* elseif (isset($_REQUEST['soils'])) {
  $select = " exp.exp_country,"
  . " concat('Soils: ', soi.soi_crop),"
  . " soi.soi_type_emission,"
  . " ROUND(soi.soi_ef_value, 2) as ef_value,"
  . " soi.soi_ef_units,"
  . " soi.soi_ipcc_1996,"
  . " soi.soi_ipcc_2006";
  $where .= " AND soi.idef_soils is not null ";
  if ($ipcc1996 != 'null' && $ipcc1996 != '' && $ipcc1996 != 'all') {
  $ipcc1996 = explode(' ', $ipcc1996);
  $where .= " AND soi.soi_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006 != 'null' && $ipcc2006 != '' && $ipcc2006 != 'all') {
  $ipcc2006 = explode(' ', $ipcc2006);
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
  if ($ipcc1996 != 'null' && $ipcc1996 != '' && $ipcc1996 != 'all') {
  $ipcc1996 = explode(' ', $ipcc1996);
  $where .= " AND ent.ent_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006 != 'null' && $ipcc2006 != '' && $ipcc2006 != 'all') {
  $ipcc2006 = explode(' ', $ipcc2006);
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
  if ($ipcc1996 != 'null' && $ipcc1996 != '' && $ipcc1996 != 'all') {
  $ipcc1996 = explode(' ', $ipcc1996);
  $where .= " AND man.man_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006 != 'null' && $ipcc2006 != '' && $ipcc2006 != 'all') {
  $ipcc2006 = explode(' ', $ipcc2006);
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
  if ($ipcc1996 != 'null' && $ipcc1996 != '') {
  $ipcc1996 = explode(' ', $ipcc1996);
  $where .= " AND gra.gra_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006 != 'null' && $ipcc2006 != '') {
  $ipcc2006 = explode(' ', $ipcc2006);
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
  if ($ipcc1996 != 'null' && $ipcc1996 != '') {
  $ipcc1996 = explode(' ', $ipcc1996);
  $where .= " AND res.res_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006 != 'null' && $ipcc2006 != '') {
  $ipcc2006 = explode(' ', $ipcc2006);
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
  if ($ipcc1996 != 'null' && $ipcc1996 != '') {
  $ipcc1996 = explode(' ', $ipcc1996);
  $where .= " AND bio.bio_ipcc_1996 like '" . $ipcc1996[0] . "%' ";
  }
  if ($ipcc2006 != 'null' && $ipcc2006 != '') {
  $ipcc2006 = explode(' ', $ipcc2006);
  $where .= " AND bio.bio_ipcc_2006 like '" . $ipcc2006[0] . "%' ";
  }
  } */ else {
  $wherea = "";
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
  $sqlCount = "SELECT count(*) as total FROM (SELECT "
          . "exp.exp_country, concat('Soils: ', soi.soi_crop) as system, soi.soi_type_emission, ROUND(soi.soi_ef_value, 2) as ef_value, soi.soi_ef_units, soi.soi_ipcc_1996, soi.soi_ipcc_2006 , CONCAT('<button type=\"button\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN soi.idef_soils THEN CONCAT('soil',soi.idef_soils) ELSE '' END),'\">+</button>') as bot, 'soil' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
          . " INNER JOIN wp_ef_soils soi ON soi.wp_treatment_id_treatment=tre.id_treatment "
          . " WHERE 1 $where $where1"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Enteric: ', ent.ent_type_livestock_manag_sys) as system, ent.ent_type_emiss_fact, ROUND(ent.ent_ef_value, 2) as ef_value, ent.ent_ef_units, ent.ent_ipcc_1996, ent.ent_ipcc_2006 , CONCAT('<button type=\"button\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN ent.idef_enteric THEN CONCAT('enteric',ent.idef_enteric) ELSE '' END),'\">+</button>') as bot, 'enteric' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_enteric ent ON ent.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where2"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Manure: ', man.man_type_manure_manag_sys) as system, man.man_type_emiss_fact, ROUND(man.man_ef_value, 2) as ef_value, man.man_ef_units, man.man_ipcc_1996, man.man_ipcc_2006 , CONCAT('<button type=\"button\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN man.idef_manure THEN CONCAT('manure',man.idef_manure) ELSE '' END),'\">+</button>') as bot, 'manure' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_manure man ON man.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where3"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Grassland: ', gra.gra_ecosyst_desc) as system, gra.gra_type_emiss_fact, ROUND(gra.gra_ef_value, 2) as ef_value, gra.gra_ef_units, gra.gra_ipcc_1996, gra.gra_ipcc_2006 , CONCAT('<button type=\"button\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN gra.idef_grassland_burning THEN CONCAT('grassland',gra.idef_grassland_burning) ELSE '' END),'\">+</button>') as bot, 'grassland' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_grassland_burning gra ON gra.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where4"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Residue: ', res.res_type_crop) as system, res.res_type_emiss_fact, ROUND(res.res_ef_value, 2) as ef_value, res.res_ef_units, res.res_ipcc_1996, res.res_ipcc_2006 , CONCAT('<button type=\"button\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN res.idef_residue_burning THEN CONCAT('residue',res.idef_residue_burning) ELSE '' END),'\">+</button>') as bot, 'residue' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_residue_burning res ON res.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where5"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Biomass: ', bio.bio_type_forest) as system, bio.bio_type_emiss_fact, ROUND(bio.bio_ef_value, 2) as ef_value, bio.bio_ef_units, bio.bio_ipcc_1996, bio.bio_ipcc_2006 , CONCAT('<button type=\"button\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN bio.idef_biomass THEN CONCAT('biomass',bio.idef_biomass) ELSE '' END),'\">+</button>') as bot, 'biomass' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_biomass bio ON bio.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where6 ) as a "
          . "WHERE 1 ".$wherea;
//  echo $sqlCount."\n";
//  $count = $wpdb->get_row($sqlCount);

  $sql = "SELECT exp_country, system, soi_type_emission, ef_value, soi_ef_units, soi_ipcc_1996, soi_ipcc_2006, bot FROM (SELECT "
          . "exp.exp_country, concat('Soils: ', soi.soi_crop) as system, soi.soi_type_emission, ROUND(soi.soi_ef_value, 2) as ef_value, soi.soi_ef_units, soi.soi_ipcc_1996, soi.soi_ipcc_2006 , CONCAT('<button type=\"button\" style=\"padding: 10px 10px 7px;\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN soi.idef_soils THEN CONCAT('soil',soi.idef_soils) ELSE '' END),'\">+</button>') as bot, 'soil' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
          . " INNER JOIN wp_ef_soils soi ON soi.wp_treatment_id_treatment=tre.id_treatment "
          . " WHERE 1 $where $where1"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Enteric: ', ent.ent_type_livestock_manag_sys) as system, ent.ent_type_emiss_fact, ROUND(ent.ent_ef_value, 2) as ef_value, ent.ent_ef_units, ent.ent_ipcc_1996, ent.ent_ipcc_2006 , CONCAT('<button type=\"button\" style=\"padding: 10px 10px 7px;\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN ent.idef_enteric THEN CONCAT('enteric',ent.idef_enteric) ELSE '' END),'\">+</button>') as bot, 'enteric' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_enteric ent ON ent.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where2"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Manure: ', man.man_type_manure_manag_sys) as system, man.man_type_emiss_fact, ROUND(man.man_ef_value, 2) as ef_value, man.man_ef_units, man.man_ipcc_1996, man.man_ipcc_2006 , CONCAT('<button type=\"button\" style=\"padding: 10px 10px 7px;\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN man.idef_manure THEN CONCAT('manure',man.idef_manure) ELSE '' END),'\">+</button>') as bot, 'manure' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_manure man ON man.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where3"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Grassland: ', gra.gra_ecosyst_desc) as system, gra.gra_type_emiss_fact, ROUND(gra.gra_ef_value, 2) as ef_value, gra.gra_ef_units, gra.gra_ipcc_1996, gra.gra_ipcc_2006 , CONCAT('<button type=\"button\" style=\"padding: 10px 10px 7px;\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN gra.idef_grassland_burning THEN CONCAT('grassland',gra.idef_grassland_burning) ELSE '' END),'\">+</button>') as bot, 'grassland' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_grassland_burning gra ON gra.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where4"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Residue: ', res.res_type_crop) as system, res.res_type_emiss_fact, ROUND(res.res_ef_value, 2) as ef_value, res.res_ef_units, res.res_ipcc_1996, res.res_ipcc_2006 , CONCAT('<button type=\"button\" style=\"padding: 10px 10px 7px;\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN res.idef_residue_burning THEN CONCAT('residue',res.idef_residue_burning) ELSE '' END),'\">+</button>') as bot, 'residue' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_residue_burning res ON res.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where5"
          . " UNION "
          . " SELECT "
          . "exp.exp_country, concat('Biomass: ', bio.bio_type_forest) as system, bio.bio_type_emiss_fact, ROUND(bio.bio_ef_value, 2) as ef_value, bio.bio_ef_units, bio.bio_ipcc_1996, bio.bio_ipcc_2006 , CONCAT('<button type=\"button\" style=\"padding: 10px 10px 7px;\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN bio.idef_biomass THEN CONCAT('biomass',bio.idef_biomass) ELSE '' END),'\">+</button>') as bot, 'biomass' as type"
          . " FROM wp_experiment exp "
          . " INNER JOIN wp_ef_biomass bio ON bio.wp_experiment_idexperiment=exp.idexperiment "
          . " WHERE 1 $where $where6 ) as a "
          . "WHERE 1 ".$wherea
          . $order . " " . $limit;
//  echo $sql."\n";
//  $result = $wpdb->get_results($sql, ARRAY_N);
}

/* $sql1 = "SELECT count(*) as total"
  . " FROM wp_experiment exp "
  . " LEFT JOIN wp_contact_info cnt ON (cnt.wp_experiment_idexperiment=exp.idexperiment)"
  . " LEFT JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_soils soi ON soi.wp_treatment_id_treatment=tre.id_treatment "
  . " LEFT JOIN wp_ef_enteric ent ON ent.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_manure man ON man.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_grassland_burning gra ON gra.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_residue_burning res ON res.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_biomass bio ON bio.wp_experiment_idexperiment=exp.idexperiment "
  . " WHERE 1 "
  . $where; */
//echo $sql1;
$count = $wpdb->get_row($sqlCount);

$total_rows = $count->total;
//$wpdb->query('SET @i := -1;');
/* $sql1 = "SELECT "
  . $select . " , CONCAT('<button type=\"button\" class=\"pure-button pure-button-primary\" data-toggle=\"modal\" data-target=\"#contmm',(CASE WHEN soi.idef_soils THEN CONCAT('soil',soi.idef_soils) ELSE '' END),'\">+</button>') as bot"
  . " FROM wp_experiment exp "
  . " LEFT JOIN wp_contact_info cnt ON (cnt.wp_experiment_idexperiment=exp.idexperiment)"
  . " LEFT JOIN wp_treatment tre ON tre.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_soils soi ON soi.wp_treatment_id_treatment=tre.id_treatment "
  . " LEFT JOIN wp_ef_enteric ent ON ent.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_manure man ON man.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_grassland_burning gra ON gra.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_residue_burning res ON res.wp_experiment_idexperiment=exp.idexperiment "
  . " LEFT JOIN wp_ef_biomass bio ON bio.wp_experiment_idexperiment=exp.idexperiment "
  . " WHERE 1 "
  . $where
  . $order . " " . $limit; */
//  echo $sql1;
$result = $wpdb->get_results($sql, ARRAY_N);

echo json_encode(
        array(
//          "draw"=> 1,
          "recordsTotal" => $total_rows,
          "recordsFiltered" => $total_rows,
          "data" => $result
        )
);

