@extends('layouts.appCustomer')
@section('content')
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('/js/CreateCustomer.js') }}"></script>
<script  type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<script>
	@if ($errors->any())
		alert("{{ implode('\n', $errors->all()) }}");
	@elseif (session()->has('success'))
		alert("{{ session()->get('success') }}");
	@endif
</script>
<style type="text/css">
input,textarea{
	border: 1px solid #aaa;
}
.auto-style1 {
	color: #FF0000;
}
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
					<div class="row justify-content-center">
						<div class="col-auto"><button class="btn btn-primary active" type="button" onclick="location.href='{{$GoBackPlace}}'">戻る</button></div>
					</div>
					<form action="/workers/saveTreatmentContent" method="POST" class="h-adr">
	                    @csrf
	                    <span class="p-country-name" style="display:none;">Japan</span>
						<div class="font-semibold text-1xl text-slate-600"">[商品{{$btnDisp}}]</div>
						<span class="auto-style1">*</span><span class="py-1.5">必須項目</span>
						<p  style="text-indent:20px" class="py-1.5">施術番号<input type="text" name="serial_TreatmentContent" value="{{$targetTreatmentContentSerial}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" readonly></p>
						<p style="text-indent:20px" class="py-1.5">施術名<span class="auto-style1">*</span><input type="text" name="TreatmentContent_name" id="TreatmentContent_name" value="{{optional($TreatmentContentInf)->name_treatment_contents}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" ></p>
						
						<p style="text-indent:20px" class="py-1.5">施術名かな<span class="auto-style1">*</span><input type="text" name="TreatmentContent_name_kana" id="TreatmentContent_name_kana" value="{{optional($TreatmentContentInf)->name_treatment_contents_kana}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" ></p>


						<p style="text-indent:20px" class="py-1.5">施術内容説明<textarea cols="20" name="TreatmentContent_details" id="TreatmentContent_details" rows="2">{{ optional($TreatmentContentInf)->treatment_details }}</textarea></p>
						メモ<textarea cols="20" name="memo" id="memo" rows="2">{{ optional($TreatmentContentInf)->memo }}</textarea>
						&nbsp;<p style="text-align: center"><button class="btn btn-primary active" type="submit" id="SubmitBtn" value="{{$btnDisp}}" onclick="return validate();">{{$btnDisp}}</button></p>
					</form>
					<input name="TorokuMessageFlg" id="TorokuMessageFlg" type="hidden" value="{{$saveFlg}}"/>		
                </div>
            </div>
        </div>
    </div>
@endsection