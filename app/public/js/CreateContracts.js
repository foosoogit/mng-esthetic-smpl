function getTodayForTypeDate() {
    var today = new Date();
    today.setDate(today.getDate());
    var yyyy = today.getFullYear();
    var mm = ("0"+(today.getMonth()+1)).slice(-2);
    var dd = ("0"+today.getDate()).slice(-2);
    return yyyy+'-'+mm+'-'+dd;
}

function validate(){
	var ContractsDate=document.getElementById("ContractsDate").value;
	var ContractsDateStart=document.getElementById("ContractsDateStart").value;
	var inpTotalAmount=document.getElementById("inpTotalAmount").value;
	var ContractNaiyo=document.getElementById("ContractNaiyo0").value;
	var TreatmentsTimes=document.getElementById("TreatmentsTimes_slct").value;
	var how_pay_Rdio_obj=document.getElementsByName("HowPayRdio");
	var how_pay="";

	console.log( how_pay_Rdio_obj.length);
	for (let i = 0; i < how_pay_Rdio_obj.length; i++) {
		if (how_pay_Rdio_obj[i].checked) {
			how_pay = how_pay_Rdio_obj[i].value;
			break;
		}
	}

	if(ContractsDate==""){
		alert("契約締結日を入力してください。");
		return false;
	}else if(ContractsDateStart==""){
		alert("開始契約期間を入力してください。");
		return false;
	}else if(inpTotalAmount==""){
		alert("契約金（チェック用入力）を入力してください。");
		return false;
	}else if(ContractNaiyo==""){
		alert("契約内容明細は1つ以上入力してください。");
		return false;
	}else if(TreatmentsTimes==0){
		alert("施術回数を選択して下さい。");
		return false;
	}else if(how_pay==""){
		alert("支払い方法を選択して下さい。");
		return false;
	}
}

function cancel_validate(){
	console.log(document.getElementById("KaiyakuDate").value);
	if(document.getElementById("KaiyakuDate").value==""){
		alert("解約日を入力してください。");
		return false;
	}else{
		let pass = window.prompt('パスワードの入力');
		if(pass=='0927'){
			return true;
		}else{
			alert("パスワードが違います。");
			return false;
		}
	}
	return true;
}

function modosu_cancel(){
	//console.log(document.getElementById("KaiyakuDate").value);
	let pass = window.prompt('パスワードの入力');
	if(pass=='0927'){
		return true;
	}else{
		alert("パスワードが違います。");
		return false;
	}
}

function canceled_message(){
	//console.log(document.getElementById("KaiyakuDate").value);
	alert("契約が解約されてます。保存できません。");
	return false;
}

function ContractNaiyoSlctManage(obj){
	//console.log(obj.value);
	//alert(obj.id);
	//alert(obj.value);
	//ContractNaiyo[0]
	var num = obj.id.replace(/[^0-9]/g, '');
	//alert(num);
	var objId='ContractNaiyo'+num;
	document.getElementById(objId).value=obj.value;
}

/*
jQuery(document).ready(function($){
	alert("TEST");

	$("#ContractFm").validate({
		rules : {
			ContractsDate: {required: true},
			ContractsDateStart: {	required:true},
			inpTotalAmount: {required:true}
		},
		messages: {
			ContractsDate: {required: "This field is required.<BR>"},
			ContractsDateStart: {	required: "This field is required.<BR>"},
			inpTotalAmount: {valueNotEquals: "Please select an item!"}
		},
		errorPlacement: function(error, element) {
		
			if (element.is(':date')) {
				//alert("TEST");
				if(element.attr("name")=='ContractsDate'){
					error.appendTo($('#title_rbtn_for_error'));
					//error.appendTo(element.parent());
				}else if(element.attr("name")=='ContractsDateStart'){
					error.appendTo($('#pi_ci_rbtn_for_error'));
					//error.appendTo(element.parent());
				}else if(element.attr("name")=='project_rdo'){
					error.appendTo($('#project_rdo_for_error'));
					//error.appendTo(element.parent());
				}else if(element.attr("name")=='category_alos2_rdo'){
					error.appendTo($('#category_alos2_rdo_for_error'));
					//error.appendTo(element.parent());
				}else if(element.attr("name")=='presentation_rbtn'){
					error.appendTo($('#presentation_rbtn_for_error'));
					//error.appendTo(element.parent());
				}else if(element.attr("name")=='presentation_style_rbtn'){
					error.appendTo($('#presentation_style_rbtn_for_error'));
					//error.appendTo(element.parent());
				}else if(element.attr("name")=='invitation_letter_rbtn'){
					error.appendTo($('#invitation_letter_rbtn_for_error'));
					//error.appendTo(element.parent());
				}else{
					error.insertAfter(element);
				}
			}else if(element.attr("name")=="presentation_title_tarea"){
				error.appendTo($('#presentation_title_tarea_for_error'));
			}else if(element.attr("name")=="abstract_tarea"){
				error.appendTo($('#abstract_tarea_for_error'));
			}else{
				error.insertAfter(element);
			}
			
		}
	});
});
*/	
function HowPayRdioManage(){
	var today = new Date();
	var HowPay=document.getElementsByName("HowPayRdio").value;
	console.log(document.getElementById("HowPayRdio_genkin").checked);
	if(document.getElementById("HowPayRdio_genkin").checked==true){
		document.getElementById("HowManyPaySlct").disabled=false;
		document.getElementById("DateFirstPay").disabled=false;
		document.getElementById("DateFirstPay").value=getTodayForTypeDate();
		document.getElementById("DateSecondtPay").disabled=false;

		document.getElementById("CardCompanyNameSlct").selectedIndex=0;
		document.getElementById("CardCompanyNameSlct").disabled=true;

		document.getElementById("HowmanyCard_OneTime").checked=false;
		document.getElementById("HowmanyCard_OneTime").disabled=true;

		document.getElementById("DatePayCardOneDay").disabled=true;
		document.getElementById("DatePayCardOneDay").value="yyyy/mm/dd";
		
		document.getElementById("HowmanyCard_Bunkatsu").checked=false;
		document.getElementById("HowmanyCard_Bunkatsu").disabled=true;
		document.getElementById("HowManyPayCardSlct").selectedIndex=0;
		document.getElementById("HowManyPayCardSlct").disabled=true;
	}else{
		document.getElementById("HowManyPaySlct").selectedIndex=0;
		document.getElementById("HowManyPaySlct").disabled=true;

		document.getElementById("DateFirstPay").disabled=true;
		document.getElementById("DateFirstPay").value="yyyy/mm/dd";
		document.getElementById("AmountPaidFirst").value="";
		document.getElementById("AmountPaidSecond").value="";
		document.getElementById("DateSecondtPay").disabled=true;

		document.getElementById("CardCompanyNameSlct").disabled=false;
		document.getElementById("CardCompanyNameSlct").selectedIndex=0;

		document.getElementById("HowmanyCard_OneTime").disabled=false;
		
		document.getElementById("DatePayCardOneDay").disabled=false;
		document.getElementById("DatePayCardOneDay").value=getTodayForTypeDate();
		
		document.getElementById("HowmanyCard_Bunkatsu").disabled=false;
		document.getElementById("HowManyPayCardSlct").disabled=false;
		if(document.getElementById("HowmanyCard_OneTime").checked==true){
			document.getElementById("DatePayCardOneDay").disabled=false;
			document.getElementById("DatePayCardOneDay").value=getTodayForTypeDate();
			
			document.getElementById("HowManyPayCardSlct").disabled=true;
			document.getElementById("HowManyPayCardSlct").selectedIndex=0;
		}else{
			document.getElementById("DatePayCardOneDay").disabled=true;
			document.getElementById("DatePayCardOneDay").value="yyyy/mm/dd";			
			document.getElementById("HowManyPayCardSlct").disabled=false;
		}
	}
	
	if(HowPay=="現金"){
		var ElementsCount = document.getElementById(getTodayForTypeDate()).elements.length;
		for( i=0 ; i<ElementsCount ; i++ ) {
			document.getElementById("HowmanyCard").elements[i].checked = false;
		}
		
		document.getElementById("DateFirstPay").value=today;
	}
	document.getElementById("TotalAmount").value=total;
	ck_total_amount();
	/*
	if(inpTotalAmount!==total){
		alert("契約金合計金額が合いません。確認してください。");
	}
	*/
}

function removeComma(number) {
    var removed = number.replace(/,/g, '');
    return parseInt(removed, 10);
}

function addComma(obj) {
	//alert(obj.value);
	var NoComma=removeComma(obj.value)
	//alert(NoComma);	
	if(isNaN(NoComma)){
		obj.value='';
	}else{
		var money=Number(removeComma(obj.value));
	    //alert(removeComma(obj.value));
	    moneyComma=NoComma.toLocaleString();
	    //alert(moneyComma);
	    obj.value=moneyComma;
    }
}

document.getElementById('submit').onclick = function() {
    var radio = document.querySelector('input[type=radio][name=language]:checked');
    radio.checked = false;
}

function total_amount(){
	//alert("Test");
	var KeiyakuNum=document.getElementsByName("KeiyakuNumSlct[]");
	var AmountPerNum=document.getElementsByName("AmountPerNum[]");
	var subTotalAmount=document.getElementsByName("subTotalAmount[]");
	var ContractNaiyo=document.getElementsByName("ContractNaiyo[]");
	var total=0;

	for(i=0;i<5;i++){
		//alert(ContractNaiyo[i].value);	
		if(ContractNaiyo[i].value==""){break;}
		subtotal_cal=Number(removeComma(KeiyakuNum[i].value))*Number(removeComma(AmountPerNum[i].value));
		total=total+subtotal_cal;
		subTotalAmount[i].value=subtotal_cal.toLocaleString();
	}
	document.getElementById("TotalAmount").value=total.toLocaleString();
}

function ck_total_amount(){
	//console.log(ContractNaiyo[1].value);
	/*
	var total=document.getElementById("TotalAmount").value;
	var inpTotalAmount=document.getElementById("inpTotalAmount").value;
	if(inpTotalAmount!==total &&total!=="" ){
		alert("契約金合計金額が合いません。確認してください。");
	}
	*/
}


function delArert(targetUser){
	ary = targetUser.split(' ');
	var res=window.confirm( '登録番号: ' + ary[0]+'\n'+ ary[1]+' '+ary[2]+'さんのデータを削除します。よろしいですか？');
	if(res){
		return true;
	}else{
		return false;
	}
}

