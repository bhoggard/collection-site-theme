<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
<br>
<br>

				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-10 col-sm-offset-1'>
<?php
					$exh_res = $t_item->getRelatedItems('ca_objects', ['returnAs' => 'searchResult']);
					if($exh_res && $exh_res->numHits()){
?>
						<div class="jcarousel-wrapper">
							<!-- Carousel -->
							<div id="exhibit-carousel" class="jcarousel">
								<ul>
<?php
								while($exh_res->nextHit()){
									if($vs_media = $exh_res->getWithTemplate('<l>^ca_object_representations.media.large</l>', array("checkAccess" => $va_access_values))){
										print "<li class='exhibit-slide'><div class='frontSlide exhibit-img'>".$vs_media;
										$vs_caption = $exh_res->getWithTemplate("<l>^ca_objects.preferred_labels.name</l><br>^ca_objects.exhibitCaption");
										if($vs_caption){
											print "<div class='frontSlideCaption'>".$vs_caption."</div>";
										}
										print "</div></li>";
										$vb_item_output = true;
									}
								}
?>
								</ul>
						</div><!-- end jcarousel -->
<?php
						if($vb_item_output){
?>
							<!-- Prev/next controls -->
							<a href="#" class="jcarousel-control-prev exhibit-prev"><i class="fa fa-angle-left"></i></a>
							<a href="#" class="jcarousel-control-next exhibit-next"><i class="fa fa-angle-right"></i></a>
		
							<!-- Pagination -->
							<p id="exhibit-pagination" class="jcarousel-pagination">
							<!-- Pagination items will be generated in here -->
							</p>
<?php
						}
					}
?>
		</div><!-- end jcarousel-wrapper -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
		
				/*
				 Prev control initialization
				 */
				$('.jcarousel-control-prev')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '-=1'
					});
		
				/*
				 Next control initialization
				 */
				$('.jcarousel-control-next')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '+=1'
					});
		
				/*
				 Pagination initialization
				 */
				$('.jcarousel-pagination')
					.on('jcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('jcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination({
						// Options go here
					});
			});
		</script>

					{{{<ifdef code="ca_occurrences.description"><H6>About</H6>^ca_occurrences.description<br/></ifdef>}}}
					{{{<ifcount code="ca_objects" min="1" max="1"><div class='unit'><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.large</l><div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div></unit></div></ifcount>}}}

<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}					
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
