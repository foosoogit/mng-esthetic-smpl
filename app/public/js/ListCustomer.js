//alert('js');
function ClearSerch(){
	//alert('ClearSerch');
	document.getElementById("kensakukey_txt").value="";
}

function delArert(targetUser){
	//alert('delArert');
	ary = targetUser.split(' ');
	var res=window.confirm( '登録番号: ' + ary[0]+'\n'+ ary[1]+' '+ary[2]+'さんのデータを削除します。よろしいですか？');
	if(res){
		return true;
	}else{
		return false;
	}
}