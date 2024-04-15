<?php
/**
 * Import page template
 *
 * @package Milos
 * @subpackage Chriss
 */

?>
<div class="wrap" >
	<h2>Import Live data</h2>
	<p>Data will be imported from <code><?php echo LIVE_SITE_URL; ?></code> website.</p>
	<div id="import-messages" ></div>
	<p><input type="button" class="button button-primary" value="Start Importing" id="start-import" /></p>
</div>
<script>
jQuery(function($){

	const $start_import_button = $('#start-import');
	const posts_per_request = 25;
	let posts_processed = 0;
	const media_per_request = 20;
	let media_processed = 0;
	let acf_processed = 0;
	let data;

	$start_import_button.on('click', function(){

		$start_import_button.prop('disabled', true).hide();

		$(window).on('beforeunload', on_before_upload );

		$('#import-messages').empty().append('Exporting data from <?php echo LIVE_SITE_URL; ?>.');

		$.getJSON( '<?php echo LIVE_SITE_URL; ?>?export', function( response ){
			
			data = response;

			console.log( response );

			$('#import-messages').append( `<br>Found ${data.media.length} images and ${data.posts.length} posts.` );

			start_processing_posts();

		});
	});


	function on_before_upload(){
		return "If you leave the page, import won't be finished.";
	};

	function start_processing_posts() {

		posts_processed = 0;
		
		$('#import-messages').append( '<br>Starting importing posts.' );
		$('#import-messages').append( `<br>Processed <span id="import-count-posts" >0</span>/${data.posts.length} posts.` );

		process_posts();
	}

	function process_posts() {

		const posts_to_import = data.posts.slice( posts_processed, posts_processed + posts_per_request );

		const post_data = {
			action: 'import_posts',
			posts: JSON.stringify( posts_to_import ),
		};

		$.post( ajaxurl, post_data, function( response ){

			if( response && response.message ) {
				alert( response.message );
			}

			posts_processed += posts_to_import.length;

			$('#import-count-posts').html( posts_processed );

			if( posts_processed < data.posts.length ) {
				process_posts();
			}
			else {
				$('#import-messages').append( `<br>Successfully imported ${posts_processed} posts.` );
				start_processing_media();
			}

		});
	}

	function start_processing_media() {

		media_processed = 0;
		
		$('#import-messages').append( '<br>Starting importing media.' );
		$('#import-messages').append( `<br>Processed <span id="import-count-media" >0</span>/${data.media.length} media items.` );

		process_media();
	}

	function process_media() {

		const media_to_import = data.media.slice( media_processed, media_processed + media_per_request );

		const post_data = {
			action: 'import_media',
			media: JSON.stringify( media_to_import ),
		};

		$.ajax({
			url: ajaxurl, 
			method: 'POST',
			data: post_data, 
			success: function( response ){

				if( response && response.message ) {
					alert( response.message );
				}

				media_processed += media_to_import.length;

				$('#import-count-media').html( media_processed );

				if( media_processed < data.media.length ) {
					process_media();
				}
				else {
					$('#import-messages').append( `<br>Successfully imported ${media_processed} media items.` );
					fix_post_parents();
				}
			},
			error: function() {
				process_media();
			}
		});
	}

	function fix_post_parents() {

		$('#import-messages').append( '<br>Fixing post parents ( converting old IDs to new IDs ).' );

		const post_ids = [];

		$.each(data.media, function(index, media){

			if( media.post.post_parent ) {
				post_ids.push( media.post.ID );
			}

		});

		$.each(data.posts, function(index, post){

			if( post.source.post_parent ) {
				post_ids.push( post.source.post.ID );
			}

		});

		const post_data = {
			action: 'import_fix_parent_ids',
			post_ids: JSON.stringify( post_ids ),
		};

		$.post( ajaxurl, post_data, function( response ){
			$('#import-messages').append( '<br>Successfully fixed post parents ( converting old IDs to new IDs ).' );
			start_processing_acf();
		});
	}

	function start_processing_acf() {

		acf_processed = 0;

		$('#import-messages').append( '<br>Processing ACF data.' );
		$('#import-messages').append( `<br>Processed ACF data for <span id="import-count-acf" >0</span>/${data.posts.length} posts.` );

		process_acf();
	}

	function process_acf() {

		const post_ids = [];

		$.each(data.posts.slice( acf_processed, acf_processed + posts_per_request ), function(index, post){

			post_ids.push( post.source.post.ID );

		});

		const post_data = {
			action: 'import_convert_acf',
			post_ids: JSON.stringify( post_ids ),
		};

		$.post( ajaxurl, post_data, function( response ){

			acf_processed += post_ids.length;

			$('#import-count-acf').html( acf_processed );

			if( acf_processed < data.posts.length ) {
				process_acf();
			}
			else {
				$('#import-messages').append( '<br>Successfully processed acf data.' );
				$start_import_button.prop('disabled', false);
				$(window).off('beforeunload', on_before_upload );
			}

		});
	}

});
</script>
