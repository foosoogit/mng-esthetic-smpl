function save_kessan_month(obj){
	var kesan_month=obj.value;
	//alert(kesan_month);

	$.ajax({
		url: "ajax_save_kessan_month",
		type: 'post',
		dataType: 'text', 
		scriptCharset: 'utf-8',
		frequency: 10,
		cache: false,
		data: {'kesan_month': kesan_month},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	}).done(function (data) {
		//alert(data);
	}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
		alert(XMLHttpRequest.status);
		alert(textStatus);
		alert(errorThrown);	
		alert('エラー');
	});

}