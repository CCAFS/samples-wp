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
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/src/markerclusterer.js"></script>
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
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      </header><!-- .entry-header -->
    </div><!-- /header-wrapper -->

</div><!-- /banner -->

<div class="container">
  <section id="content" class="row">
    <div class="col-sm-8" id="primary">
      
        <div id="main-content">
      <!--</div>-->
      <!--<br>-->
      <!--<h3 id="map_title" name="map_title">Map view</h3>-->
          <div id="map-canvas"></div>
      
          <div id="results_soils" style="z-index: 1" class="samples-table">
        <!--<h3>Soils</h3>-->
            <table id='resulttable_soils' name='resulttable_soils' class="display compact cell-border statistic-ag">
                  <thead>
                <tr>
                  <th>Country</th>
                  <th>System</th>
                  <th>Type of EF</th>
                  <th>Value</th>
                  <th>Units</th>
                  <th>1996 IPCC source/sink code</th>
                  <th>P2006 IPCC source/sink code</th>
                </tr>
              </thead>
            </table>
            <a href="">View all fields</a>
          </div><!-- /#resulttable_soils -->
          <div id='downloadFile'>
            <h3>Download Data</h3>
            <a href='#' onClick='' title='Download Data for Excel'><img src='<?php echo get_template_directory_uri() ?>/img/excel.png'></a>
            <a href='#' onClick=''title='Download Data for CSV'><img src='<?php echo get_template_directory_uri() ?>/img/csv.png'></a>
            <!--<button class='pure-button pure-button-primary' type='button' name='viewall' id='viewall' onClick='viewAllFields()'>View all fields</button>-->
            <!--<button class='pure-button pure-button-primary' type='button' name='viewall' id='viewall' onClick='viewAllFieldsh()'>View all fields</button>-->
          </div><!-- /#downloadFile -->
      
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
  <div id="infos-detail" style="display: none">
  </div>
</section>
<?php
get_footer();
?>

