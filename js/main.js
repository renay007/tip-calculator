$(document).ready(function(){
	toggle_box();
	$('input[type="radio"]').on('click', function() {
		toggle_box();
	});
});
function toggle_box(){
	if($('#custom_percent').prop('checked'))
		$('#custom_box').show();
	else
		$('#custom_box').hide();
}

