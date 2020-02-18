<?php

/* N2O Dashboard
 *
 * @package ccafs
 */

get_header(); ?>

	<div class="banner general">
			<div class="container header-wrapper">
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<h4 class="subheader"><?php echo CFS()->get('subheader'); ?></h4>
				</header><!-- .entry-header -->
			</div><!-- /header-wrapper -->

	</div><!-- /banner -->
	<div  class="content-area container">
		<div class="row">
			<div class="col-sm-12" id="primary">
				<main id="main" class="site-main" role="main">

						<?php while ( have_posts() ) : the_post(); ?>

							<!--?php get_template_part( 'template-parts/content', 'page' ); ?-->

							<div id="n2o-page-navigation">
								<ul>
									<li style="display:inline; padding-right: 30px"><a href="#n2o-dashboard">N2O Map</a></li>
									<li style="display:inline; padding-right: 30px"><a href="#n2o-funders">Funders</a></li>
									<li style="display:inline; padding-right: 30px"><a href="#n2o-data-collection">Data Collection Method</a></li>
								</ul>
							</div>

							<p>To view emission outputs, select the drop-down filters in a top to bottom order and choose the output you wish to see.</p>
							<p>All study locations in the database are represented in the map as clusters and as individual study locations as you zoom in. Detailed information about each study can be viewed by clicking the markers on the map.</p>
							<p>The mean, median and 95% confidence interval are derived from the studies filtered based on the selected inputs. The filtered study locations are reflected in the map as well.</p>
							<p>To reset filters, please click the 'Clear' button.</p>
							<p>To download data, please click the ‘Download’ button which saves the filtered data in a csv format.</p>
							<iframe id="n2o-dashboard" title="N2O Dashboard" src="https://samples-n2o.shinyapps.io/n2o-2020/" width="100%" height="800px" style="margin:40px 0"></iframe>

							<div id="n2o-funders">
								<h3>Funders</h3>
								<p>This database was created as a part of global N2O project supported by CGIAR research programs (CRPs) on Climate Change, Agriculture and Food Security (CCAFS).  CCAFS’ work is supported by CGIAR Fund Donors and through bilateral funding agreements. For details please visit <a href="https://ccafs.cgiar.org/donors">https://ccafs.cgiar.org/donors.</a></p>
								<ul class="row">
									<li style="width: 20%; padding:15px" class="col-md-6"><a href="https://www.cgiar.org/" target="_blank" style=""><img src="<?php echo get_bloginfo('template_url') ?>/images/n2o-logos/ccafs_new_logo_transp_rgb.png" alt""></a></li>
									<li style="width: 20%; padding:15px" class="col-md-6"><a href="https://www.cimmyt.org/" target="_blank" style=""><img src="<?php echo get_bloginfo('template_url') ?>/images/n2o-logos/CIMMYT.png" alt""></a></li>
									<li style="width: 20%; padding:15px" class="col-md-6"><a href="https://www.ed.ac.uk/" target="_blank" style=""><img src="<?php echo get_bloginfo('template_url') ?>/images/n2o-logos/ed_logo.png" alt""></a></li>
									<li style="width: 20%; padding:15px" class="col-md-6"><a href="https://www.abdn.ac.uk/" target="_blank" style=""><img src="<?php echo get_bloginfo('template_url') ?>/images/n2o-logos/UoA_Primary_Logo_RGB_2018.png" alt""></a></li>
									<li style="width: 20%; padding:15px" class="col-md-6"><a href="https://www.yara.com/" target="_blank" style=""><img src="<?php echo get_bloginfo('template_url') ?>/images/n2o-logos/knowledge_grows_for_a4.png" alt""></a></li>
								</ul>
							</div>

							<div id="n2o-data-collection">
								<h3>Data collection method</h3>
								<p>The target of our data collection was to compile an up-to-date database of as many field measurements of nitrous oxide (N2O) emissions from published experiments comparing unfertilized treatments with treatments fertilized with nitrogen (N) as possible. We used the database developed by Stehfest and Bouwman (2006) as a starting point but extended the number of descriptive parameter and measured N2O emission data as much as possible.</p>
								<p>The Stehfest and Bouwman (2006) dataset included 204 studies published until 2004. A literature search in the databases of “ISI-Web of Knowledge”, “Google Scholar” and “Scopus” for the keywords “nitrous oxide”, “N2O” in combination with “fertilizer”, “Nitrogen” and “fertilizer use” resulted in 1153 publications. Papers published up until the end of 2016 are included in the database. As a first selection step we excluded all studies that were performed under laboratory or glasshouse conditions (n=173) or were not reporting measured N2O data from field experiments (e.g. review articles or modelling approaches; n=343). All remaining 637 papers were analyzed regarding the following minimum requirements for inclusion in the final database: (1) the study includes N2O data from at least one unfertilized control and one fertilized treatment, and (2) the study reports the amount of N fertilizer applied and the cumulative N2O emission over the trial period. This final selection step reduced the number of usable studies to 272. We applied the same selection criteria to the papers collected by Stehfest and Bouwman (2006) which added another 69 suitable studies to the new database. In total, information from 341 scientific studies published between 1980 and 2016 were extracted to make the database. All papers were carefully reviewed to extract information on the year and location of the experiment, climate, weather and soil information, crop management information including fertilizer treatments, information about N2O emission measurement methods, crop yield and N2O emission. Experimental details, yield and emission values were extracted either directly from tables or from text, or were derived from graphs using Plot Digitizer software (<a href="https://sourceforge.net/p/plotdigitizer/wiki/Home/">https://sourceforge.net/p/plotdigitizer/wiki/Home/</a>). All the parameters in the dataset are described in detail for better clarity on data. Through this dashboard one can view and download N rate, N2O emission and N2O emission factor for different crops in various geographic regions, crop & fertilizer type and their management.  In addition to the minimum information that was mandatory for inclusion of data in the N2O database we have extracted a number of other parameter from the papers in order to inform the statistical analysis and enable the development of a generic model to estimate nitrous oxide emissions from fertilized croplands.</p>
								<p><strong>Reference:</strong></p>
								<p>Stehfest, E., Bouwman, L., 2006. N2O and NO emission from agricultural fields and soils under natural vegetation: summarizing available measurement data and modeling of global annual emissions. Nutr. Cycl. Agroecosystems 74, 207–228. <a href="https://doi.org/10.1007/s10705-006-9000-7">https://doi.org/10.1007/s10705-006-9000-7</a></p>
							</div>

						<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- /row -->

	</div><!-- /content-area -->

<?php get_footer(); ?>
