jQuery(document).ready(function() {
	$('.admin.projects input[name=name]').keyup(function() {
        var val_name = alias_correct($(this).val());
        $('.admin.projects input[name=alias]').val(val_name);
    });
	$('.admin.services input[name=name]').keyup(function() {
        var val_name = alias_correct($(this).val());
        $('.admin.services input[name=alias]').val(val_name);
    });
	
	
});


