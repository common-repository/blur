<?php 
/*
*	Plugin Name: BLuR
*	Description: This simple plugin attaches a filter to your website, that removes the blue light from your visitors browser. It attaches different filter for the different states of the day to prevent your readers eyes beign hurted by the "cold" blue light.
*	Version: 1.0
*	Author: GeroNikolov
*	Author URI: http://blogy.co?GeroNikolov
*	License: GPLv2
*/

// Add BLR filter CSS
function blr_add_css() {
	if ( is_singular( "post" ) ) { 
		echo "
		<style>
		#blr-filter {
		    width: 100%;
		    height: 100%;
		    top: 0;
		    left: 0;
		    z-index: 99999;
		    position: fixed;
		    pointer-events: none;
		}
		#blr-filter.noon { background: rgba(255, 229, 206, 0.15); }
		#blr-filter.evening { background: rgba(255, 181, 105, 0.15); }
		#blr-filter.night { background: rgba(255, 157, 60, 0.15); }
		</style>
		";
	}
}

// Add BLR filter
function blr_add_filter() { 
	if ( is_singular( "post" ) ) {
		echo "<div id='blr-filter'></div>";
	}
}

// Add BLR script
function blr_add_script() {
	echo '
	<script>
	date_ = new Date().toLocaleTimeString().replace(/([\d]+:[\d]{2})(:[\d]{2})(.*)/, "$1$3");
	hour_ = ConvertTimeformat( "24", date_ );

	if ( hour_ >= 12 && hour_ < 16 ) { jQuery( "#blr-filter" ).addClass( "noon" ); }
	else if ( hour_ >= 16 && hour_ < 20 ) { jQuery( "#blr-filter" ).addClass( "evening" ); }
	else if ( hour_ >= 20 && hour_ < 24 && hour_ != 0 ) { jQuery( "#blr-filter" ).addClass( "night" ); }

	function ConvertTimeformat(format, str) {
	    var time = str;
	    var hours = Number(time.match(/^(\d+)/)[1]);
	    var AMPM = time.match(/\s(.*)$/)[1];
	    if (AMPM == "PM" && hours < 12) hours = hours + 12;
	    if (AMPM == "AM" && hours == 12) hours = hours - 12;
	    var sHours = hours.toString();
	    if (hours < 10) sHours = "0" + sHours;

	    return sHours;
	}
	</script>
	';
}

// Attach the BLR filter
add_action( 'wp_footer', "blr_add_css" );
add_action( 'wp_footer', "blr_add_filter" );
add_action( 'wp_footer', "blr_add_script" );
?>