$(function(){
	$('.input-data').click(function(){
		$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
		// alert('asdf');
	});
	$('.viewButton').click(function(){
		$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
	$('.updateButton').click(function(){
		$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
});