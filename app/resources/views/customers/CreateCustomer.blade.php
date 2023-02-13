@extends('layouts.appCustomer')
@section('content')
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('/js/CreateCustomer.js') }}"></script>
<script  type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
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
					<div class="col-auto"><button class="btn btn-primary" type="button" onclick="location.href='{{$GoBackPlace}}'">戻る</button></div>
                    <form action="/customers/insertCustomer" method="POST" class="h-adr">
                    @csrf
                    <span class="p-country-name" style="display:none;">Japan</span>
			@if (optional($target_user)->serial_user<>null)
				<div class="card-header py-3">顧客データ修正</div>
				<p  style="text-indent:20px" class="py-1.5">顧客番号<input type="text" name="serial_user" value="{{optional($target_user)->serial_user}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" ></p>
			@else
				<div class="font-semibold text-2xl text-slate-600">[顧客新規登録]</div><br>
				<span class="auto-style1">*</span><span class="font-semibold text-1xl text-slate-600">:必須項目</span>
			@endif
			<span class="auto-style1">*</span>入会日<input name="AdmissionDate" id="AdmissionDate" type="date" value="{{optional($target_user)->admission_date}}"/>
			{!! $html_branch_rdo !!}
			<p class="py-3">氏名</p><p style="text-indent:20px" class="py-1.5">
			<span class="auto-style1">*</span>姓<input type="text" name="name_sei" id="name_sei" value="{{optional($target_user)->name_sei}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" ></p>
                        <p style="text-indent:20px" class="py-1.5">
						<span class="auto-style1">*</span>名<input type="text" name="name_mei" id="name_mei" value="{{optional($target_user)->name_mei}}" class="bg-white-500 text-black rounded px-3 py-1" tabindex="2" ></p>
                        <p style="text-indent:20px" class="py-1.5">
						<span class="auto-style1">*</span>セイ<input type="text" name="name_sei_kana"  id="name_sei_kana" value="{{ optional($target_user)->name_sei_kana  }}" class="bg-white-500 text-black rounded px-3 py-1" tabindex="3" ></p>
						<p style="text-indent:20px" class="py-1.5">
						<span class="auto-style1">*</span>メイ<input type="text" name="name_mei_kana"id="name_mei_kana" value="{{ optional($target_user)->name_mei_kana }}" class="bg-white-500 text-black rounded px-3 py-1" tabindex="4" ></p>
						<span class="auto-style1">*</span>性別&nbsp;&nbsp;
							<div class="form-check form-check-inline">
								<input class="form-check-input" style="display: inline grid" name="GenderRdo" id="GenderMan" type="radio" value="man"  {{ optional($GenderRdo)['man'] }}/>
								<label class="form-check-label" for="GenderMan">男</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" style="display: inline grid" name="GenderRdo" id="GenderWoman" type="radio" value="woman" {{optional($GenderRdo)['woman']}}/>
								<label class="form-check-label" for="GenderWoman">女</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" style="display: inline grid" name="GenderRdo" id="GenderFree" type="radio" value="free" {{optional($GenderRdo)['free']}}/>
								<label class="form-check-label" for="GenderFree">フリー</label>
							</div>
						<p class="py-3">生年月日<p style="text-indent:20px">
						<select name="birt_year_slct" class="bg-white-500 text-black rounded px-3 py-1" tabindex="5">{!! $html_birth_year_slct !!}</select> 年
						<select name="birth_month_slct" class="bg-white-500 text-black rounded px-3 py-1" tabindex="6">
						<option value="01" {{optional($selectedManth)[1]}}>1</option>
						<option value="02" {{optional($selectedManth)[2]}}>2</option>
						<option value="03" {{optional($selectedManth)[3]}}>3</option>
						<option value="04" {{optional($selectedManth)[4]}}>4</option>
						<option value="05" {{optional($selectedManth)[5]}}>5</option>
						<option value="06" {{optional($selectedManth)[6]}}>6</option>
						<option value="07" {{optional($selectedManth)[7]}}>7</option>
						<option value="08" {{optional($selectedManth)[8]}}>8</option>
						<option value="09" {{optional($selectedManth)[9]}}>9</option>
						<option value="10" {{optional($selectedManth)[10]}}>10</option>
						<option value="11" {{optional($selectedManth)[11]}}>11</option>
						<option value="12" {{optional($selectedManth)[12]}}>12</option>
						</select>月
						<select name="birth_day_slct" class="bg-white-500 text-black rounded px-3 py-1" tabindex="7">
						<option value="01" {{optional($selectedDay)[1]}}>1</option>
						<option value="02" {{optional($selectedDay)[2]}}>2</option>
						<option value="03" {{optional($selectedDay)[3]}}>3</option>
						<option value="04" {{optional($selectedDay)[4]}}>4</option>
						<option value="05" {{optional($selectedDay)[5]}}>5</option>
						<option value="06" {{optional($selectedDay)[6]}}>6</option>
						<option value="07" {{optional($selectedDay)[7]}}>7</option>
						<option value="08" {{optional($selectedDay)[8]}}>8</option>
						<option value="09" {{optional($selectedDay)[9]}}>9</option>
						<option value="10" {{optional($selectedDay)[10]}}>10</option>
						<option value="11" {{optional($selectedDay)[11]}}>11</option>
						<option value="12" {{optional($selectedDay)[12]}}>12</option>
						<option value="13" {{optional($selectedDay)[13]}}>13</option>
						<option value="14" {{optional($selectedDay)[14]}}>14</option>
						<option value="15" {{optional($selectedDay)[15]}}>15</option>
						<option value="16" {{optional($selectedDay)[16]}}>16</option>
						<option value="17" {{optional($selectedDay)[17]}}>17</option>
						<option value="18" {{optional($selectedDay)[18]}}>18</option>
						<option value="19" {{optional($selectedDay)[19]}}>19</option>
						<option value="20" {{optional($selectedDay)[20]}}>20</option>
						<option value="21" {{optional($selectedDay)[21]}}>21</option>
						<option value="22" {{optional($selectedDay)[22]}}>22</option>
						<option value="23" {{optional($selectedDay)[23]}}>23</option>
						<option value="24" {{optional($selectedDay)[24]}}>24</option>
						<option value="25" {{optional($selectedDay)[25]}}>25</option>
						<option value="26" {{optional($selectedDay)[26]}}>26</option>
						<option value="27" {{optional($selectedDay)[27]}}>27</option>
						<option value="28" {{optional($selectedDay)[28]}}>28</option>
						<option value="29" {{optional($selectedDay)[29]}}>29</option>
						<option value="30" {{optional($selectedDay)[30]}}>30</option>
						<option value="31" {{optional($selectedDay)[31]}}>31</option>
						</select>日
						<p class="py-3">住所</p>
						<p style="text-indent:20px">〒<input type="text" name="postal" class="p-postal-code bg-white-500 text-black rounded px-3 py-1" size="8" maxlength="8" value="{{optional($target_user)->postal}}" tabindex="8"></p>
                        <p style="text-indent:20px">
						<select class="p-region-id bg-white-500 text-black rounded px-3 py-1" name="region" tabindex="9">
						<option value="">--</option>
						<option value="1" {{optional($selectedRegion)[1]}}>北海道</option>
						<option value="2" {{optional($selectedRegion)[2]}}>青森県</option>
						<option value="3" {{optional($selectedRegion)[3]}}>岩手県</option>
						<option value="4" {{optional($selectedRegion)[4]}}>宮城県</option>
						<option value="5" {{optional($selectedRegion)[5]}}>秋田県</option>
						<option value="6" {{optional($selectedRegion)[6]}}>山形県</option>
						<option value="7" {{optional($selectedRegion)[7]}}>福島県</option>
						<option value="8" {{optional($selectedRegion)[8]}}>茨城県</option>
						<option value="9" {{optional($selectedRegion)[9]}}>栃木県</option>
						<option value="10" {{optional($selectedRegion)[10]}}>群馬県</option>
						<option value="11" {{optional($selectedRegion)[11]}}>埼玉県</option>
						<option value="12" {{optional($selectedRegion)[12]}}>千葉県</option>
						<option value="13" {{optional($selectedRegion)[13]}}>東京都</option>
						<option value="14" {{optional($selectedRegion)[14]}}>神奈川県</option>
						<option value="15" {{optional($selectedRegion)[15]}}>新潟県</option>
						<option value="16" {{optional($selectedRegion)[16]}}>富山県</option>
						<option value="17" {{optional($selectedRegion)[17]}}>石川県</option>
						<option value="18" {{optional($selectedRegion)[18]}}>福井県</option>
						<option value="19" {{optional($selectedRegion)[19]}}>山梨県</option>
						<option value="20" {{optional($selectedRegion)[20]}}>長野県</option>
						<option value="21" {{optional($selectedRegion)[21]}}>岐阜県</option>
						<option value="22" {{optional($selectedRegion)[22]}}>静岡県</option>
						<option value="23" {{optional($selectedRegion)[23]}}>愛知県</option>
						<option value="24" {{optional($selectedRegion)[24]}}>三重県</option>
						<option value="25" {{optional($selectedRegion)[25]}}>滋賀県</option>
						<option value="26" {{optional($selectedRegion)[26]}}>京都府</option>
						<option value="27" {{optional($selectedRegion)[27]}}>大阪府</option>
						<option value="28" {{optional($selectedRegion)[28]}}>兵庫県</option>
						<option value="29" {{optional($selectedRegion)[29]}}>奈良県</option>
						<option value="30" {{optional($selectedRegion)[30]}}>和歌山県</option>
						<option value="31" {{optional($selectedRegion)[31]}}>鳥取県</option>
						<option value="32" {{optional($selectedRegion)[32]}}>島根県</option>
						<option value="33" {{optional($selectedRegion)[33]}}>岡山県</option>
						<option value="34" {{optional($selectedRegion)[34]}}>広島県</option>
						<option value="35" {{optional($selectedRegion)[35]}}>山口県</option>
						<option value="36" {{optional($selectedRegion)[36]}}>徳島県</option>
						<option value="37" {{optional($selectedRegion)[37]}}>香川県</option>
						<option value="38" {{optional($selectedRegion)[38]}}>愛媛県</option>
						<option value="39" {{optional($selectedRegion)[39]}}>高知県</option>
						<option value="40" {{optional($selectedRegion)[40]}}>福岡県</option>
						<option value="41" {{optional($selectedRegion)[41]}}>佐賀県</option>
						<option value="42" {{optional($selectedRegion)[42]}}>長崎県</option>
						<option value="43" {{optional($selectedRegion)[43]}}>熊本県</option>
						<option value="44" {{optional($selectedRegion)[44]}}>大分県</option>
						<option value="45" {{optional($selectedRegion)[45]}}>宮崎県</option>
						<option value="46" {{optional($selectedRegion)[46]}}>鹿児島県</option>
						<option value="47" {{optional($selectedRegion)[47]}}>沖縄県</option>
						</select></p>
						<input type="text" name="locality" class="p-locality p-street-address p-extended-address bg-white-500 text-black rounded px-3 py-1" value="{{ optional($target_user)->address_locality }}" tabindex="10"/><br>
						<p style="text-indent:20px">番地<input type="text" name="address_banti_txt" value="{{optional($target_user)->address_banti}}" class="bg-white-500 text-black rounded px-3 py-1" tabindex="11"></p>
                        <p class="py-3">メール</p>
						<p style="text-indent:20px">
						<input type="text" name="email" value="{{optional($target_user)->email}}" class="bg-white-500 text-black rounded px-3 py-2 bg-white-500 text-black rounded px-3 py-1" tabindex="12"></p>
                        <p class="py-3">電話番号</p>
						<p style="text-indent:20px"><span class="auto-style1">*</span>
						<input type="text" name="phone" id="phone" value="{{ optional($target_user)->phone }}" class="bg-white-500 text-black rounded px-3 py-2 bg-white-500 text-black rounded px-3 py-1" tabindex="13"></p>
                         何を見て当サロンに来られましたか？<br>
			{!!$html_reason_coming!!}
                        <p style="text-align: center"><button class="btn btn-primary" type="submit" id="SubmitBtn" value="{{$btnDisp}}" onclick="return validate();">{{$btnDisp}}</button></p>
					</form>
			<input name="TorokuMessageFlg" id="TorokuMessageFlg" type="hidden" value="{{$saveFlg}}"/>		
                </div>
            </div>
        </div>
    </div>
@endsection