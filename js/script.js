/* Author: 
	MMC der VGSR 
	- Laurens Offereins
*/

// Media Queries for JS
if ( Modernizr.mq("screen and (max-width:480px)") ){
	require(["script-mobile"]); // Get mobile JS
} else {
	require(["script-main"]);
}