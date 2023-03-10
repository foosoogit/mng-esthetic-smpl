window.onload = function(){
	var saveFlg=document.getElementById("TorokuMessageFlg").value;
	reason_coming_sonota_manage();
	if(saveFlgArray[0]=="true"){
		if(saveFlgArray[1]=="new"){
			alert('登録しました。');
		}else{
			alert('修正しました。');
		}
		document.getElementById("TorokuMessageFlg").value="false";
	}
}

function reason_coming_sonota_manage(){
	if(document.getElementById("reason_coming_cbx_sonota").checked==true){
		document.getElementById("reason_coming_txt").disabled=false;
	}else{
		document.getElementById("reason_coming_txt").disabled=true;
		document.getElementById("reason_coming_txt").value="";
	}
}

function validate(){
	var name_sei=document.getElementById("name_sei").value;
	var name_mei=document.getElementById("name_mei").value;
	var name_sei_kana=document.getElementById("name_sei_kana").value;
	var name_mei_kana=document.getElementById("name_mei_kana").value;
	
	var GenderRdo=document.getElementsByName("GenderRdo");
	var BranchRdo=document.getElementsByName("branch_rdo");
	var PhoneCnt=0;
	var NameCnt=0;
	//alert($('#AdmissionDate').val());

	strBrch="";
	for (let i = 0; i < BranchRdo.length; i++) {
		if (BranchRdo[i].checked) {
			strBrch = BranchRdo[i].value;
			break;
		}
	}

	strGndr="";
	for (let i = 0; i < GenderRdo.length; i++) {
		if (GenderRdo[i].checked) {
			strGndr = GenderRdo[i].value;
			break;
		}
	}

	if(strBrch==""){
		alert("「店舗」を選択してください。");
		return false;
	}else if(name_sei==""){
		alert("「姓」を入力してください。");
		return false;
	}else if(name_mei==""){
		alert("「名」を入力してください。");
		return false;
	}else if(name_sei_kana==""){
		alert("「セイ」を入力してください。");
		return false;
	}else if(name_mei_kana==""){
		alert("「メイ」を入力してください。");
		return false;
	}else if(strGndr==""){
		alert("「性別」を選択して下さい。");
		return false;
	}else if($('#phone').val()==""){
		alert("電話番号を入力して下さい。");
		return false;
	}else if($('#AdmissionDate').val()==""){
		alert("入会日を入力して下さい。");
		return false;
	}else if($('#branch_rdo').val()==""){
		alert("登録店舗を選択してください。");
		return false;
	}else{
		//alert($('#phone').val());
		//ax_check_phone_duplication(mladdress);
		$.ajax({
			//url: "{{ route('/ajax_check_phone_duplication') }}",
			url: '/ajax_check_phone_duplication',
			type: 'post', // getかpostを指定(デフォルトは前者)
			dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
			scriptCharset: 'utf-8',
			frequency: 10,
			cache: false,
			async : false,
			data: {'phone': $('#phone').val(),'name_sei': $('#name_sei').val(),'name_mei': $('#name_mei').val()},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}).done(function (data) {
			var json = JSON.stringify(data);
			var dt = JSON.parse(json);
			PhoneCnt=dt['Phone'];
			NameCnt=dt['Name'];
			/*
			if(data>0){
				alert("入力した電話番号はすでに登録されています。確認して下さい。");
				return false;
			}
			*/
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status);
			alert(textStatus);
			alert(errorThrown);	
			alert('エラー');
		});
		var manage_type=document.getElementById("SubmitBtn").value;
		var manage_flg=manage_type.indexOf('修');
		if(manage_flg==-1){
			if(Number(PhoneCnt)>0){
				alert("入力した電話番号はすでに登録されています。確認して下さい。");
				return false;
			}else if(Number(NameCnt)>0){
				if(!window.confirm("入力した氏名はすでに登録されています。このデータを登録しますか？")){
					return false;	
				}
			}
		}
		//return false;
	}
	document.getElementById("TorokuMessageFlg").value="true,syusei";
}