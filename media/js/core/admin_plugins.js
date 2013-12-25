$(document).ready(function() {
	$('*[title]').hover(
		function(){
			$(this).tooltip({'placement':'bottom'});
			$(this).tooltip('show')
		},
		function(){
			$(this).tooltip('hide')
		}
	);
});