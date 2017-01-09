<!-- The container is used to define the width of the slideshow -->
<div class="container" style="display: none;">
	<div id="slides">
		<img src="img/example-slide-1.jpg" alt="Photo by: Missy S">
	</div>
</div>
<!-- SlidesJS Required: Link to jQuery -->
<script src="<?php echo URL_RES; ?>js/jquery-1.9.1.min.js"></script>
<!-- SlidesJS Required: Link to jquery.slides.js -->
<script src="<?php echo URL_RES; ?>js/jquery.slides.min.js"></script>
<!-- SlidesJS Required: Initialize SlidesJS with a jQuery doc ready -->
<script>
	$(function() {
		$('#slides').slidesjs({
			width: 940,
			height: 528
		});
	});
</script>
<!-- End SlidesJS Required -->