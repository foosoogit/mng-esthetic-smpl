@extends('layouts.appCustomer')
@section('content')
<script type="text/javascript" src="{{ asset('/js/CreateContracts.js') }}"></script>
<style type="text/css">
.auto-style1 {margin-left: 40px;}
table td {border: 1px solid #aaa;}
input,textarea{border: 1px solid #aaa;}
.auto-style2 {
	color: #FF0000;
}
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
				<a href="../../../ShowMenuCustomerManagement" class="btn bg-blue-500 text-white rounded px-3 py-2">メニュー</a>
                <a href="/customers/ShowContractList/{{$targetUser->serial_user}}" class="btn bg-blue-500 text-white rounded px-3 py-2">戻る</a>
                <a href="/customers/ShowInpRecordVisitPayment/{{optional($targetContract)->serial_keiyaku}}/{{optional($targetContract)->serial_user}}" class="btn bg-blue-500 text-white rounded px-3 py-2">来店・支払い記録</a>@if (auth('staff')->user()->serial_staff==='A_0001') &nbsp;
				<a href="/workers/MakeContractPDF/{{optional($targetContract)->serial_keiyaku}}" class="btn bg-blue-500 text-white rounded px-3 py-2">契約書ダウンロード・印刷</a>@endif
				<form action="/workers/ContractCancellation/{{optional($targetContract)->serial_keiyaku}}/{{$targetUser->serial_user}}" method="POST" name="KaiyakuFm"  id="KaiyakuFm">@csrf<br>
				
				@if(optional($targetContract)->cancel===null)
					{{--<a href="/workers/ContractCancellation/{{optional($targetContract)->serial_keiyaku}}/{{$targetUser->serial_user}}" class="btn bg-blue-500 text-white rounded px-3 py-2">解約</a>--}}
					<input name="KaiyakuBtn" type="submit" value="解約"  class="btn bg-blue-500 text-white rounded px-3 py-1.5" onclick="return cancel_validate();"/>
					解約日<input name="KaiyakuDate" id="KaiyakuDate" type="date" value="{{optional($targetContract)->cancel}}"/>
				@else
					{{--<a href="/workers/ContractCancellation/{{optional($targetContract)->serial_keiyaku}}/{{$targetUser->serial_user}}" class="btn bg-blue-500 text-white rounded px-3 py-2">契約を復活</a>解約日：{{optional($targetContract)->cancel}}--}}
					<input name="KaiyakuModosuBtn" type="submit" value="契約を復活"  class="btn bg-blue-500 text-white rounded px-3 py-1.5" onclick="return modosu_cancel();"/>
解約日：{{optional($targetContract)->cancel}}
				
				@endif
				</form>
				<div class="card-header">契約登録</div>
<span class="auto-style2">*</span><span class="font-semibold text-1xl text-slate-600">:必須項目</span>                  
<form action="/customers/insertContract" method="POST" name="ContractFm"  id="ContractFm">@csrf<br>&nbsp;<p>顧客番号：<input type="text" name="serial_user" value="{{ $targetUser->serial_user}}"class="bg-white-500 text-black rounded px-3 py-2"></p>
                        <p>氏名：{{ $targetUser->name_sei }}&nbsp;{{ $targetUser->name_mei }}</p>
                        <p><span class="auto-style2">*</span>契約締結日：<input name="ContractsDate" id="ContractsDate" type="date" value="{{optional($targetContract)->keiyaku_bi}}"/>
                        <p>役務契約期間：<span class="auto-style2">*</span><input name="ContractsDateStart" id="ContractsDateStart" type="date"  value="{{optional($targetContract)->keiyaku_kikan_start}}"/> ～ <input name="ContractsDateEnd" type="date"  value="{{optional($targetContract)->keiyaku_kikan_end}}"/>
                      <p>契約番号：<input type="text" name="ContractSerial" value="{{$newKeiyakuSerial}}"class="bg-white-500 text-black rounded px-3 py-1">
                      @if(!(optional($targetContract)->cancel===null))
                      	解約済み
                      @endif
                      </p>
			<p>契約名：<input type="text" name="ContractName" value="{{ optional($targetContract)->keiyaku_name }}" class="bg-white-500 text-black rounded px-3 py-1"></p>
			<p>担当者：<input type="text" name="tantosya" value="{{ optional($targetContract)->tantosya }}" class="bg-white-500 text-black rounded px-3 py-1"></p>
			<p><span class="auto-style2">*</span>契約金（チェック用入力）：
			@if(isset($targetContract->keiyaku_kingaku))
				<input type="text" name="inpTotalAmount" id="inpTotalAmount" value="{{number_format($targetContract->keiyaku_kingaku)}}" class="bg-white-500 text-black rounded px-3 py-1" onkeyup="addComma(this)">
			@else
				<input type="text" name="inpTotalAmount" id="inpTotalAmount" value="" class="bg-white-500 text-black rounded px-3 py-1" onkeyup="addComma(this)">
			@endif
			</p>
			<p><span class="auto-style2">*</span>施術回数 {!!$TreatmentsTimes_slct!!}</p>
				<table style="width: 100%;border-collapse: collapse;border: 1px solid #aaa;" class="table-auto" border-solid border="1">
						<tr>
							<td>契約内容明細&nbsp;&nbsp;<input name="toroku_treatment_btn" type="button" class="bg-blue-500 text-white rounded px-3 py-1" value="施術内容登録" onclick="location.href='/workers/ShowTreatmentContents'"></td>
							<td>回数</td>
							<td>単価</td>
							<td>料金(税抜き)</td>
						</tr>
						<tr>
							<td style="height: 22px">
							<span class="auto-style2">*</span><select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[0]" onchange="ContractNaiyoSlctManage(this)">{!!$KeiyakuNaiyouSelectArray[0]!!}</select><input type="text" name="ContractNaiyo[]" id="ContractNaiyo0" value="{{optional($KeiyakuNaiyouArray)[0]}}" class="bg-white-500 text-black rounded px-3 py-1"></td>
							<td style="height: 22px">
							<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct1" onchange="total_amount();"><option value="0" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[0]!!}}</select></td>
							<td style="height: 22px">
							@if($KeiyakuTankaArray[0]=="")
								<input type="text" name="AmountPerNum[]" id="AmountPerNum1" value="" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@else
								<input type="text" name="AmountPerNum[]" id="AmountPerNum1" value="{{number_format($KeiyakuTankaArray[0])}}" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@endif
							</td>
							<td style="height: 22px">
							{{--KeiyakuPriceArray[0]={{$KeiyakuPriceArray[0]}}--}}
							@if($KeiyakuPriceArray[0]=="")
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount1" class="bg-white-500 text-black rounded px-3 py-1" value="" onchange="ck_total_amount()">
							@else
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount1" class="bg-white-500 text-black rounded px-3 py-1" value="{{$KeiyakuPriceArray[0]}}" onchange="ck_total_amount()">
							@endif
							
							
							
							
							</td>
						</tr>
						<tr>
							<td><select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[1]" onchange="ContractNaiyoSlctManage(this)">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
							<input type="text" name="ContractNaiyo[]" id="ContractNaiyo1" value="{{optional($KeiyakuNaiyouArray)[1]}}" class="bg-white-500 text-black rounded px-3 py-1"></td>
							<td>
							<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct2" onchange="total_amount();"><option value="0" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[1]!!}}</select></td>
							<td>
							@if($KeiyakuTankaArray[1]=="")
								<input type="text" name="AmountPerNum[]" id="AmountPerNum2" value="" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@else
								<input type="text" name="AmountPerNum[]" id="AmountPerNum2" value="{{number_format($KeiyakuTankaArray[1])}}" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@endif	
							</td>
							<td>
							@if($KeiyakuPriceArray[1]=="")
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount2" class="bg-white-500 text-black rounded px-3 py-1" value="" onchange="ck_total_amount()">
							@else
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount2" class="bg-white-500 text-black rounded px-3 py-1" value="{{$KeiyakuPriceArray[1]}}" onchange="ck_total_amount()">
							@endif
							</td>
						</tr>
						<tr>
							<td>
							<select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[2]" onchange="ContractNaiyoSlctManage(this)">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
							<input type="text" name="ContractNaiyo[]" id="ContractNaiyo2"  value="{{optional($KeiyakuNaiyouArray)[2]}}" class="bg-white-500 text-black rounded px-3 py-1"></td>
							<td>
							<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct3" onchange="total_amount();"><option value="0" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[2]!!}}</select></td>
							<td>
							@if($KeiyakuTankaArray[2]=="")
								<input type="text" name="AmountPerNum[]" id="AmountPerNum3" value="" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@else
								<input type="text" name="AmountPerNum[]" id="AmountPerNum3" value="{{optional($KeiyakuTankaArray)[2]}}" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@endif
							</td>
							<td>
							@if($KeiyakuPriceArray[2]=="")
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount3" class="bg-white-500 text-black rounded px-3 py-1" value="" onchange="ck_total_amount()">
							@else
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount3" class="bg-white-500 text-black rounded px-3 py-1" value="{{number_format($KeiyakuPriceArray[2])}}" onchange="ck_total_amount()">
							@endif</td>
						</tr>
						<tr>
							<td>
							<select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[3]" onchange="ContractNaiyoSlctManage(this)">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
							<input type="text" name="ContractNaiyo[]" id="ContractNaiyo3" value="{{optional($KeiyakuNaiyouArray)[3]}}" class="bg-white-500 text-black rounded px-3 py-1"></td>
							<td>
							<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct4" onchange="total_amount();"><option value="0" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[3]!!}}</select></td>
							<td>
							@if($KeiyakuTankaArray[3]=="")
								<input type="text" name="AmountPerNum[]" id="AmountPerNum4" value="" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@else
								<input type="text" name="AmountPerNum[]" id="AmountPerNum4" value="{{optional($KeiyakuTankaArray)[3]}}" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@endif
							</td>
							<td>
							@if($KeiyakuPriceArray[3]=="")
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount4" class="bg-white-500 text-black rounded px-3 py-1" value="" onchange="ck_total_amount()">
							@else
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount4" class="bg-white-500 text-black rounded px-3 py-1" value="{{number_format($KeiyakuPriceArray[3])}}" onchange="ck_total_amount()">
							@endif</td>
						</tr>
						<tr>
							<td>
							<select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[4]" onchange="ContractNaiyoSlctManage(this)">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
							<input type="text" name="ContractNaiyo[]" id="ContractNaiyo4" value="{{optional($KeiyakuNaiyouArray)[5]}}" class="bg-white-500 text-black rounded px-3 py-1"></td>
							<td>
							<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct5" onchange="total_amount();"><option value="0" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[4]!!}}</select></td>
							<td>
							@if($KeiyakuTankaArray[4]=="")
								<input type="text" name="AmountPerNum[]" id="AmountPerNum5" value="" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@else
								<input type="text" name="AmountPerNum[]" id="AmountPerNum5" value="{{optional($KeiyakuTankaArray)[4]}}" class="bg-white-500 text-black rounded px-3 py-1" onchange="total_amount()">
							@endif
							</td>
							<td>
							@if($KeiyakuPriceArray[4]=="")
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount5" class="bg-white-500 text-black rounded px-3 py-1" value="" onchange="ck_total_amount()">
							@else
								<input type="text" name="subTotalAmount[]"  id="subTotalAmount5" class="bg-white-500 text-black rounded px-3 py-1" value="{{number_format($KeiyakuPriceArray[4])}}" onchange="ck_total_amount()">
							@endif
							</td>
						</tr>
						<tr>
							<td colspan="3">契約金合計</td>
							<td>
							@if(isset($targetContract->keiyaku_kingaku_total))
								@if($targetContract->keiyaku_kingaku_total=="")
									<input type="text" name="TotalAmount" id="TotalAmount" class="bg-white-500 text-black rounded px-3 py-1" value="">
								@else
								<input type="text" name="TotalAmount" id="TotalAmount" class="bg-white-500 text-black rounded px-3 py-1" value="{{number_format($targetContract->keiyaku_kingaku_total)}}">
								@endif
							@else
								<input type="text" name="TotalAmount" id="TotalAmount" class="bg-white-500 text-black rounded px-3 py-1" value="">
							@endif
							</td>
						</tr>
					</table>
		<p><span class="auto-style2">*</span>お支払い方法・期間：</p>                      
		<p><label><input name="HowPayRdio" id="HowPayRdio_genkin" type="radio" onchange="HowPayRdioManage()" value="現金" {!!optional($HowToPay)['cash']!!}/>現金支払い</label>
		<select name="HowManyPaySlct" id="HowManyPaySlct">
		{!!optional($HowManyPay)['CashSlct']!!}
		{{--
		<option>1</option>
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
		<option>6</option>
		<option>7</option>
		<option>8</option>
		<option>9</option>
		<option>10</option>
		<option>11</option>
		<option>12</option>
		<option>13</option>
		<option>14</option>
		<option>15</option>
		<option>16</option>
		<option>17</option>
		<option>18</option>
		<option>19</option>
		<option>20</option>
		--}}
		</select>回</p>
		<p class="auto-style1">1回目：<input name="DateFirstPay" id="DateFirstPay" type="date" value="{{optional($targetContract)->date_first_pay_genkin}}"/>(<input type="text" name="AmountPaidFirst" id="AmountPaidFirst" class="bg-white-500 text-black rounded px-3 py-1" value="{{optional($targetContract)->amount_first_pay_cash}}">円)</p> 
		<p class="auto-style1">2回目：<input name="DateSecondtPay" id="DateSecondtPay" type="date" value="{{optional($targetContract)->date_second_pay_genkin}}"/>(<input type="text" name="AmountPaidSecond" id="AmountPaidSecond" class="bg-white-500 text-black rounded px-3 py-1" value="{{optional($targetContract)->amount_second_pay_cash}}">円)</p>
		<p><label><input name="HowPayRdio" id="HowPayRdio_card" type="radio" value="Credit Card" onchange="HowPayRdioManage()" {!!optional($HowToPay)['card']!!}/>クレジットカード　カード会社</label>
		<select name="CardCompanyNameSlct" id="CardCompanyNameSlct">
			<option value="未選択">選択してください</option>
			{!!$CardCompanySelect!!}
		</select></p>
		<p><label>
		<input name="HowmanyCard" id="HowmanyCard_OneTime" type="radio" value="一括" class="auto-style1" onchange="HowPayRdioManage()" {!!optional($HowManyPay)['one']!!}/>一括支払い：支払日<input name="DatePayCardOneDay" id="DatePayCardOneDay" type="date" value="{{optional($targetContract)->date_pay_card}}"/></p>
		</label><p><label>
		<input name="HowmanyCard" id="HowmanyCard_Bunkatsu" type="radio" value="分割" class="auto-style1" onchange="HowPayRdioManage()" {!!optional($HowManyPay)['bunkatu']!!} style="width: 20px"/>分割支払
		<select name="HowManyPayCardSlct" id="HowManyPayCardSlct" style="height: 19px">
		{!!$HowManyPay['CardSlct']!!}
		{{--
		<option>2</option>
		<option>3</option>
		<option>4</option>
		<option>5</option>
		<option>6</option>
		<option>7</option>
		<option>8</option>
		<option>9</option>
		<option>10</option>
		<option>11</option>
		<option>12</option>
		<option>13</option>
		<option>14</option>
		<option>15</option>
		<option>16</option>
		<option>17</option>
		<option>18</option>
		<option>19</option>
		<option>20</option>
		--}}
		</select>回払い</label></p>                      
		<p>メモ：<textarea cols="20" name="memo" id="memo" rows="2" class="bg-white-500 text-black rounded px-3 py-1">{{optional($targetContract)->remarks}}</textarea></p>
		<p style="text-align: center">
		@if(optional($targetContract)->cancel===null)
			<button  class="bg-blue-500 text-white rounded px-3 py-1" type="submit" type="submit" onclick="return validate();">　　登　録　　</button>
		@else
			<button  class="bg-blue-500 text-white rounded px-3 py-1" type="submit" type="submit" onclick="return canceled_message();" style="background-color:gray">　　登　録　　</button>
		@endif

		</p>
				</form>
				<script>
					@if ($errors->any())
						alert("{{ implode('\n', $errors->all()) }}");
					@elseif (session()->has('success'))
						alert("{{ session()->get('success') }}");
					@endif
				</script>

                </div>
            </div>
        </div>
    </div>
@endsection