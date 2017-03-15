<?php
/**
 * Template Name: experiments
 * @package WordPress
 * @subpackage SAMPLES
 */
get_header();
$version = '1.0';
?>
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/select2/3.5.2/select2.css?<?php echo $version; ?>">
<script src="<?php echo get_template_directory_uri(); ?>/js/select2/3.5.2/select2.js?<?php echo $version; ?>"></script>
<link rel="stylesheet" href="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/jqueryui/dataTables.jqueryui.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.6/css/jquery.dataTables.css">
<script type="text/javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/experiment.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/pure-min-custom.css">
<!--<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/treatment.css?<?php echo $version; ?>">-->
<script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/infobox/src/infobox_packed.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/js-marker-clusterer/1.0.0/markerclusterer_compiled.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/treatment.js?<?php echo $version; ?>"></script>
<div id="loading" style="z-index:9999;display: none"><img style="" src="<?php echo get_template_directory_uri(); ?>/img/loading.gif" alt="Loader" /></div>
<script type="text/javascript">
  var templateUrl = '<?php get_bloginfo("url"); ?>';
  var templatePath = '<?php echo get_template_directory_uri(); ?>';
</script>
<?php
$spaces = array(
  '1' => '',
  '2' => '&nbsp;&nbsp;&nbsp;&nbsp;',
  '3' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
  '4' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
);

$source = array(
  '', 'all', 'Soils', 'Livestock', 'Manure', 'Grassland burning', 'Residue burning', 'Biomass carbon'
);

$ipcc1996 = array(
  array('name' => '', 'level' => ''),
  array('name' => 'all', 'level' => ''),
  array('name' => '4 Agriculture', 'level' => '1'),
  array('name' => '4A Enteric fermentation ', 'level' => '2'),
  array('name' => '4A1 Cattle', 'level' => '3'),
  array('name' => '4A1a Dairy', 'level' => '4'),
  array('name' => '4A1b Non dairy', 'level' => '4'),
  array('name' => '4A2 Buffalo', 'level' => '3'),
  array('name' => '4A3 Sheep', 'level' => '3'),
  array('name' => '4A4 Goats', 'level' => '3'),
  array('name' => '4A5 Camels and llamas', 'level' => '3'),
  array('name' => '4A6 Horses', 'level' => '3'),
  array('name' => '4A7 Mules and asses', 'level' => '3'),
  array('name' => '4A8 Swine', 'level' => '3'),
  array('name' => '4A9 Poultry', 'level' => '3'),
  array('name' => '4A10 Other', 'level' => '3'),
  array('name' => '4B Manure management ', 'level' => '2'),
  array('name' => '4B1 Cattle', 'level' => '3'),
  array('name' => '4B1a Dairy', 'level' => '4'),
  array('name' => '4B1b Non dairy', 'level' => '4'),
  array('name' => '4A2 Buffalo', 'level' => '3'),
  array('name' => '4A3 Sheep', 'level' => '3'),
  array('name' => '4A4 Goats', 'level' => '3'),
  array('name' => '4A5 Camels and llamas', 'level' => '3'),
  array('name' => '4A6 Horses', 'level' => '3'),
  array('name' => '4A7 Mules and asses', 'level' => '3'),
  array('name' => '4A8 Swine', 'level' => '3'),
  array('name' => '4A9 Poultry', 'level' => '3'),
  array('name' => '4A10 Other', 'level' => '3'),
  array('name' => '4C Rice cultivation ', 'level' => '2'),
  array('name' => '4C1 Irrigated', 'level' => '3'),
  array('name' => '4C1a Continuously flooded', 'level' => '4'),
  array('name' => '4C1b Intermittently flooded', 'level' => '4'),
  array('name' => '4C2 Rained', 'level' => '3'),
  array('name' => '4C2a Flood prone', 'level' => '4'),
  array('name' => '4C2b Drought prone', 'level' => '4'),
  array('name' => '4C3 Deep water', 'level' => '3'),
  array('name' => '4C3a Water depth 50-100cm', 'level' => '4'),
  array('name' => '4C3b Water depth > 100cm', 'level' => '4'),
  array('name' => '4C4 Other', 'level' => '3'),
  array('name' => '4D Agricultural soils', 'level' => '2'),
  array('name' => '4E Prescribed burning of savannas ', 'level' => '2'),
  array('name' => '4F Field burning of agricultural residues ', 'level' => '2'),
  array('name' => '4F1 Cereals', 'level' => '3'),
  array('name' => '4F2 Pulse', 'level' => '3'),
  array('name' => '4F3 Tuber and root', 'level' => '3'),
  array('name' => '4F4 Sugar cane', 'level' => '3'),
  array('name' => '4G Other', 'level' => '2'),
  array('name' => '5 Land-use change and forestry', 'level' => '1'),
  array('name' => '5A Changes in forest and other woody biomass stocks', 'level' => '2'),
  array('name' => '5A1 Tropical forest', 'level' => '3'),
  array('name' => '5A2 Temperate forest', 'level' => '3'),
  array('name' => '5B Forest and grassland conversion', 'level' => '2'),
  array('name' => '5B1 Tropical forest', 'level' => '3'),
  array('name' => '5B2 Temperate forest ', 'level' => '3'),
  array('name' => '5C Abandonment of managed lands', 'level' => '2'),
  array('name' => '5D CO2 emissions and removals from soil ', 'level' => '2'),
  array('name' => '5E Other', 'level' => '2'),
  array('name' => '5-CL Cropland', 'level' => '2'),
  array('name' => '5-GL Grassland', 'level' => '2'),
  array('name' => '5-WL Wetlands', 'level' => '2')
);

$ipcc2006 = array(
  array('name' => '', 'level' => ''),
  array('name' => 'all', 'level' => ''),
  array('name' => '3A Livestock', 'level' => '1'),
  array('name' => '3A1 Enteric fermentation ', 'level' => '2'),
  array('name' => '3A1a Cattle', 'level' => '3'),
  array('name' => '3A1ai Dairy', 'level' => '4'),
  array('name' => '3A1aii Other cattle', 'level' => '4'),
  array('name' => '3A1b Buffalo', 'level' => '3'),
  array('name' => '3A1c Sheep', 'level' => '3'),
  array('name' => '3A1d Goats', 'level' => '3'),
  array('name' => '3A1e Camels', 'level' => '3'),
  array('name' => '3A1f Horses', 'level' => '3'),
  array('name' => '3A1g Mules and asses', 'level' => '3'),
  array('name' => '3A1h Swine', 'level' => '3'),
  array('name' => '3A1j Other', 'level' => '3'),
  array('name' => '3A2 Manure management ', 'level' => '2'),
  array('name' => '3A2a Cattle', 'level' => '3'),
  array('name' => '3A2ai Dairy', 'level' => '4'),
  array('name' => '3A2aii Other cattle', 'level' => '4'),
  array('name' => '3A2b Buffalo', 'level' => '3'),
  array('name' => '3A2c Sheep', 'level' => '3'),
  array('name' => '3A2d Goats', 'level' => '3'),
  array('name' => '3A2e Camels', 'level' => '3'),
  array('name' => '3A2f Horses', 'level' => '3'),
  array('name' => '3A2g Mules and asses', 'level' => '3'),
  array('name' => '3A2h Swine', 'level' => '3'),
  array('name' => '3A2j Other', 'level' => '3'),
  array('name' => '3B Land', 'level' => '1'),
  array('name' => '3B1 Forest land ', 'level' => '2'),
  array('name' => '3B1a Forest land remaining forest land', 'level' => '3'),
  array('name' => '3B1b Land converted to forest land', 'level' => '3'),
  array('name' => '3B2 Cropland', 'level' => '2'),
  array('name' => '3B2a Cropland remaining cropland', 'level' => '3'),
  array('name' => '3B2b Land converted to cropland', 'level' => '3'),
  array('name' => '3B3 Grassland ', 'level' => '2'),
  array('name' => '3B3a  Grassland remaining grassland', 'level' => '3'),
  array('name' => '3B3b Land converted to grassland', 'level' => '3'),
  array('name' => '3B4 Wetlands ', 'level' => '2'),
  array('name' => '3B4a Wetland remaining wetland', 'level' => '3'),
  array('name' => '3B4b Land converted to wetland', 'level' => '3'),
  array('name' => '3C Aggregate sources and non-CO2 emissions sources on land ', 'level' => '1'),
  array('name' => '3C1 Emissions from biomass burning ', 'level' => '2'),
  array('name' => '3C1a Biomass burning in forest land', 'level' => '3'),
  array('name' => '3C1b Biomass burning in croplands', 'level' => '3'),
  array('name' => '3C1c Biomass burning in grasslands', 'level' => '3'),
  array('name' => '3C1d Biomass burning in all other land', 'level' => '3'),
  array('name' => '3C2 Liming ', 'level' => '2'),
  array('name' => '3C3 Urea application ', 'level' => '2'),
  array('name' => '3C4 Direct N2O emissions from managed soils ', 'level' => '2'),
  array('name' => '3C5 Indirect N2O emissions from managed soils ', 'level' => '2'),
  array('name' => '3C6 Indirect N2O emissions from manure management', 'level' => '2'),
  array('name' => '3C7 Rice cultivations ', 'level' => '2'),
  array('name' => '3C8 Other ', 'level' => '2'),
  array('name' => '3D Other', 'level' => '1')
);
?>
<div class="banner general">
  <div class="container header-wrapper">
    <header class="entry-header">
      <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
      <h4 class="subheader"><?php echo CFS()->get('subheader'); ?></h4>
    </header><!-- .entry-header -->
  </div><!-- /header-wrapper -->

</div><!-- /banner -->

<div class="container">
  <section id="content" class="row">
    <div class="col-sm-8" id="primary">

      <div id="main-content">
        <!--</div>-->
        <!--<br>-->
        <label id="map_title" name="map_title">Beta version, June 2015</label>
        <div id="map-canvas"></div>

        <div id="results_soils" style="z-index: 1" class="samples-table">

          <!--          <div id='downloadFile'>
                      <h3>Download Data</h3>
                      <a href='#' onClick='downloadData()' title='Download Data for Excel'><img src='<?php // echo get_template_directory_uri()       ?>/img/excel.png'></a>
                      <a href='#' onClick='downloadDataCSV()'title='Download Data for CSV'><img src='<?php // echo get_template_directory_uri()       ?>/img/csv.png'></a>
                      <button class='pure-button pure-button-primary' type='button' name='viewall' id='viewall' onClick='viewAllFields()'>View all fields</button>
                      <button class='pure-button pure-button-primary' type='button' name='viewall' id='viewall' onClick='viewAllFieldsh()'>View all fields</button>
                    </div>-->
          <div class="dropdown">
            <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="pure-button pure-button-primary">
              Download
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
              <li><a href='#' onClick='downloadData()' title='Download Data for Excel'>Excel</a></li>
              <li><a href='#' onClick='downloadDataCSV()'title='Download Data for CSV'>CSV</a></li>
            </ul>
            <button type="button" class="pure-button pure-button-primary" data-toggle="modal" data-target="#myModal">
              View all fields
            </button>
          </div>
          <br>
          <table id='resulttable_soils' name='resulttable_soils' class="display compact cell-border statistic-ag dataTable">
            <thead>
              <tr>
                <th>Country</th>
                <th>System</th>
                <th>Type of EF</th>
                <th>Value</th>
                <th>Units</th>
                <th>1996 IPCC source/sink code</th>
                <th>2006 IPCC source/sink code</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div><!-- /#resulttable_soils -->
      </div><!-- #main-content -->
    </div><!-- /#primary -->
    <div class="col-sm-4 sidebar">
      <div id="form-content">
        <form id="filtersh" class="pure-form pure-form-stacked">
          <label for="region">Region</label>
          <input type="hidden" id="region" name="region" onchange="onchangeSubmit()" class="js-data-ajax">
    <!--      <select class="js-data-ajax" style="width: 300px;box-shadow: none!important;" name="region" id="region" onchange="onchangeSubmit()">
          <?php
          if (isset($_GET['region'])) {
            echo "<option value='" . $_GET['region'] . "' selected='selected'>" . $_GET['region'] . "</option>";
          }
          ?>
          </select>-->

          <label for="country">Country</label>
          <input type="hidden" id="country" name="country" onchange="onchangeSubmit()" class="js-data-ajax">
    <!--      <select class="js-data-ajax" style="width: 300px;box-shadow: none!important;" name="country1" id="country" onchange="onchangeSubmit()">
          <?php
          if (isset($_GET['country'])) {
            echo "<option value='" . $_GET['country'] . "' selected='selected'>" . $_GET['country'] . "</option>";
          }
          ?>
          </select>-->

          <label for="ipcc1996">1996 IPCC sink/source category</label>

          <select class="js-data-ajax" style="width: 300px;box-shadow: none!important;" name="ipcc1996" id="ipcc1996" onchange="onchangeSubmit()">
            <?php
            if (isset($_GET['ipcc1996'])) {
              echo "<option value'" . $_GET['ipcc1996'] . "' selected='selected'>" . $_GET['ipcc1996'] . "</option>";
            }
            foreach ($ipcc1996 as $val) {
              echo "<option value='" . $val['name'] . "' >" . $spaces[$val['level']] . $val['name'] . "</option>";
            }
            ?>
          </select>

          <label for="ipcc2006">2006 IPCC sink/source category</label>

          <select class="js-data-ajax" style="width: 300px;box-shadow: none!important;" name="ipcc2006" id="ipcc2006" onchange="onchangeSubmit()">
            <?php
            if (isset($_GET['ipcc2006'])) {
              echo "<option value'" . $_GET['ipcc2006'] . "' selected='selected'>" . $_GET['ipcc2006'] . "</option>";
            }
            foreach ($ipcc2006 as $val) {
              echo "<option value='" . $val['name'] . "' >" . $spaces[$val['level']] . $val['name'] . "</option>";
            }
            ?>
          </select>

          <label for="ipcc2006">Source</label>
          <select class="js-data-ajax" style="width: 300px;box-shadow: none!important;" name="source" id="source" onchange="onchangeSubmit()">
            <?php
            if (isset($_GET['source'])) {
              echo "<option value='" . $_GET['source'] . "' selected='selected'>" . $_GET['source'] . "</option>";
            }
            foreach ($source as $val) {
              echo "<option value='" . $val . "' >" . $val . "</option>";
            }
            ?>
          </select>
          <br><br>
          <!--<button class="pure-button pure-button-primary" type="button" onchange="onchangeSubmit()">Search</button>-->
          <button class="pure-button pure-button-primary" type="button" name="reset" id="reset">Reset</button>
        </form>
      </div>
    </div>
    <div id="infos-detail" style="display: block">
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">All fields</h4>
          </div>
          <div class="modal-body">
            <table id="fullview" name="fullview" class="display compact cell-border statistic-ag dataTable no-footer samples-table">
              <thead>
                <tr>
                  <th>idexperiment</th>
                  <th>exp_name</th>
                  <th>exp_keywords</th>
                  <th>exp_brief_desc</th>
                  <th>exp_country</th>
                  <th>exp_province_state</th>
                  <th>exp_nearest_city</th>
                  <th>exp_latitude</th>
                  <th>exp_longitude</th>
                  <th>exp_year_began</th>
                  <th>exp_year_ended</th>
                  <th>exp_mean_annual_precipitation</th>
                  <th>exp_mean_annual_temperature</th>
                  <th>exp_soil_taxo_desc</th>
                  <th>exp_soil_taxo_sys</th>
                  <th>exp_soil_surface_tex</th>
                  <th>exp_min_water_depth</th>
                  <th>exp_soil_ph</th>
                  <th>exp_soil_org_matter</th>
                  <th>exp_key_findings</th>
                  <th>id_treatment</th>
                  <th>treat_desc</th>
                  <th>treat_system</th>
                  <th>treat_tillage_type</th>
                  <th>treat_synt_n_fert_type</th>
                  <th>treat_manure_amend_type</th>
                  <th>treat_nit_rate</th>
                  <th>treat_method_app</th>
                  <th>treat_cover_crop</th>
                  <th>treat_res_manag</th>
                  <th>treat_irrigation</th>
                  <th>treat_other_mitig_pract</th>
                  <th>treat_grain</th>
                  <th>treat_stover</th>
                  <th>treat_roots</th>
                  <th>treat_notes</th>
                  <th>treatr_water_manage</th>
                  <th>treatr_land_prep</th>
                  <th>treatr_user_herb</th>
                  <th>treatr_crop_season</th>
                  <th>treatr_num_grow_days</th>
                  <th>treatr_org_manage</th>

                  <th>soi_ipcc_1996</th>
                  <th>soi_ipcc_2006</th>
                  <th>soi_gas</th>
                  <th>soi_crop</th>
                  <th>soi_gas_sampling_freq</th>
                  <th>soi_type_emission</th>
                  <th>soi_depth_measu</th>
                  <th>soi_ef_value</th>
                  <th>soi_ef_units</th>
                  <th>soi_equation</th>
                  <th>soi_lower_bound</th>
                  <th>soi_upper_bound</th>
                  <th>soi_uncertainty</th>
                  <th>soi_notes</th>

                  <th>ent_ipcc_1996</th>
                  <th>ent_ipcc_2006</th>
                  <th>ent_gas</th>
                  <th>ent_type_emiss_fact</th>
                  <th>ent_type_livestock_manag_sys</th>
                  <th>ent_animal_bod_weight_ave</th>
                  <th>ent_weight_gain_ave</th>
                  <th>ent_subespecies_class</th>
                  <th>ent_feed_quant_access</th>
                  <th>ent_feed_quality</th>
                  <th>ent_milk_prod</th>
                  <th>ent_mitigation_tech</th>
                  <th>ent_ef_value</th>
                  <th>ent_ef_units</th>
                  <th>ent_equation</th>
                  <th>ent_lower_bound</th>
                  <th>ent_upper_bound</th>
                  <th>ent_notes</th>

                  <th>man_ipcc_1996</th>
                  <th>man_ipcc_2006</th>
                  <th>man_gas</th>
                  <th>man_type_emiss_fact</th>
                  <th>man_type_manure_manag_sys</th>
                  <th>man_animal_weight</th>
                  <th>man_subspacies</th>
                  <th>man_num_animals_operation</th>
                  <th>man_operat_conditions</th>
                  <th>man_diet_feed_charact_anim</th>
                  <th>man_mitigation_tech</th>
                  <th>man_ef_value</th>
                  <th>man_ef_units</th>
                  <th>man_equation</th>
                  <th>man_lower_bound</th>
                  <th>man_upper_bound</th>
                  <th>man_notes</th>

                  <th>gra_ipcc_1996</th>
                  <th>gra_ipcc_2006</th>
                  <th>gra_gas</th>
                  <th>gra_type_emiss_fact</th>
                  <th>gra_ecosyst_desc</th>
                  <th>gra_fuel_density</th>
                  <th>gra_whether_litter_liv_veg</th>
                  <th>gra_ef_value</th>
                  <th>gra_ef_units</th>
                  <th>gra_equation</th>
                  <th>gra_lower_bound</th>
                  <th>gra_upper_bound</th>
                  <th>gra_notes</th>

                  <th>res_ipcc_1996</th>
                  <th>res_ipcc_2006</th>
                  <th>res_type_emiss_fact</th>
                  <th>res_type_crop</th>
                  <th>res_crop_area</th>
                  <th>res_crop_yield</th>
                  <th>res_crop_seasson</th>
                  <th>res_residue_desc</th>
                  <th>res_ef_value</th>
                  <th>res_ef_units</th>
                  <th>res_equation</th>
                  <th>res_lower_bound</th>
                  <th>res_upper_bound</th>
                  <th>res_notes</th>

                  <th>bio_ipcc_1996</th>
                  <th>bio_ipcc_2006</th>
                  <th>bio_gas</th>
                  <th>bio_type_emiss_fact</th>
                  <th>bio_type_forest</th>
                  <th>bio_forest_age</th>
                  <th>bio_manag_pact_applied</th>
                  <th>bio_ef_value</th>
                  <th>bio_ef_units</th>
                  <th>bio_equation</th>
                  <th>bio_lower_bound</th>
                  <th>bio_upper_bound</th>
                  <th>bio_notes</th>
                  
                  <th>Contact information</th>
                  <th>Journal citation</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!--<button type="button" class="btn btn-primary">Save changes</button>-->
          </div>
        </div>
      </div>
    </div>
    <div id="fullviewDiv" title="All fields" class="samples-table" style="display:none">

    </div>
  </section>
  <?php
  get_footer();
  ?>

