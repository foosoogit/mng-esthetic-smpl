function get_target_branch(){
	//alert(document.getElementsByName("target_branch").value);
	alert("target_branch3");
	document.getElementsByName("target_branch_hdn").value="get_target_branch";
	Livewire.emitTo('select-branch-manage', 'select_branch','get_target_branch');
	alert("target_branch4");
	//Livewire.emit(select_branch('emit'));
}

function branch_cbox_manage(obj){
	/*
	//alert("TEST2");
	branch_cbx_all
	var branch_cbox_obj = document.getElementsByName("branch_cbx");
	alert(branch_cbox_obj[0].checked);
	var all_ck_flg=true;
	
	if(obj==branch_cbox_obj[0]){
		if(branch_cbox_obj[0]){
			for (let i = 1; i < branch_cbox_obj.length; i++) {
				branch_cbox_obj[i].checked= true;
				}
			}
		}else{

	}
	if(branch_cbox_obj[0].checked==true){
		for (let i = 1; i < branch_cbox_obj.length; i++) {
				all_ck_flg=true;
			}
	}else{
		for (let i = 1; i < branch_cbox_obj.length; i++) {
			if(branch_cbox_obj[i].checked != true){
				all_ck_flg=false;
				branch_cbox_obj[0].checked=false;
				break;
			}
		}
		if(all_ck_flg==true){
			branch_cbox_obj[0].checked=true;
		}else{
			branch_cbox_obj[0].checked=false;
		}
	}
	*/
	/*
	if(obj==branch_cbox_obj[0]){
		if(branch_cbox_obj[0].checked == true){
			//alert("true2");
			alert(branch_cbox_obj.length);
			for (let i = 1; i < branch_cbox_obj.length; i++) {
				branch_cbox_obj[i].checked=true;
			}
		}else{
			var all_ck_flg=true;
			for (let i = 1; i < branch_cbox_obj.length; i++) {
				if(branch_cbox_obj[i].checked != true){
					all_ck_flg=false;
					break;
				}
			}
			if(all_ck_flg==true){
				branch_cbox_obj[0].checked=true;
			}
		}
	}
	alert("TEST1");
	*/
}

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