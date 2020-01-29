<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ccafs
 */
?>

		 	</div><!-- #content -->
		 	 <div class="back-to-top"><a href="#top">back to top</a></div>
		 </div><!-- #page -->

	</div><!-- /.main-wrap -->

	<div class="footer-wrap">
		<div class="pre-footer partner-logos ">
			<div class="container">
			 	<ul>
			 		<li><a href="http://cifor.org/"><img src="<?php echo get_template_directory_uri(); ?>/images/CIFOR_logo_small.png" class="img-responsive" alt="CIFOR" /></a></li>
			 		<li><a href="http://ciat.cgiar.org/"><img src="<?php echo get_template_directory_uri(); ?>/images/CIAT.png" class="img-responsive" alt="CIAT"/></a></li>
			 		<li><a href="http://www.icrisat.org/"><img src="<?php echo get_template_directory_uri(); ?>/images/ICRISAT.png" class="img-responsive" alt="ICRISAT"/></a></li>
			 		<li><a href="http://iita.org/"><img src="<?php echo get_template_directory_uri(); ?>/images/IITA.png" class="img-responsive" alt="IITA"/></a></li>
			 		<li><a href="http://ilri.org/"><img src="<?php echo get_template_directory_uri(); ?>/images/ILRI.png" class="img-responsive" alt="ILRI"/></a></li>
			 		<li><a href="http://cimmyt.org/"><img src="<?php echo get_template_directory_uri(); ?>/images/CimmyT.png" class="img-responsive" alt="CIMMYT"/></a></li>
			 		<li><a href="http://irri.org/"><img src="<?php echo get_template_directory_uri(); ?>/images/IRRI-logo-sm.png" class="img-responsive" alt="IRRI"/></a></li>
			 		<li><a href="http://www.icraf.org/"><img src="<?php echo get_template_directory_uri(); ?>/images/ICRAF_logo-new-sm.png" class="img-responsive" alt="WAC"/></a></li>
			 	</ul>
			</div><!-- /container -->
		</div><!-- /partner-logos -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">
				<div class="row clearfix">
					<div class="col-sm-4 footer-logos">
						<div class="footer-col-wrap">
							<a href="http://ccafs.cgiar.org/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/CCAFS_White.png" class="img-responsive" alt="CIFOR" /></a></a>
						</div>
					</div>

					<div class="col-sm-4 footer-address">
						<div class="footer-col-wrap">
						<p>
							CCAFS Low Emissions Agriculture<br />
							Gund Institute for Ecological Economics<br />
							University of Vermont<br />
							210 Colchester Ave<br />
							Burlington, Vermont 05405 USA</p>
						</div>
					</div>

					<div class="col-sm-4 footer-contact-info">
						<div class="footer-col-wrap last">
						    <div class="clearfix"><img src="<?php echo get_template_directory_uri(); ?>/images/Envelope.png" class="pull-left footer-icon" alt="email"/><a href="mailto:c.costajr@cgiar.org" class="footer-email pull-left">Costa Junior, Ciniro (CIAT-CCAFS)</a></div>

						    <div class="clearfix"><img src="<?php echo get_template_directory_uri(); ?>/images/Phone.png" class="pull-left footer-icon phone" alt="phone"/><span class="footer-phone pull-left">+55 19 98179 0722</span></div>
					    </div>
					</div>

				</div><!-- /row -->
			</div><!-- /container -->

		</footer><!-- #colophon -->

	</div><!-- /footer-wrap -->
<?php wp_footer(); ?>

</body>
</html>
