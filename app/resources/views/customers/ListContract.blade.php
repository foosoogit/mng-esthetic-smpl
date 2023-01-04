@extends('layouts.appCustomer')
@section('content')
<style type="text/css">
	text,textarea{border: 1px solid #aaa;}
</style>
<script src="{{  asset('/js/CreateContracts.js') }}" defer></script>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<button class="bg-blue-500 text-white rounded px-3 py-1" type="button" onclick="location.href='../../ShowMenuCustomerManagement'">メニュー</button>
				<button class="bg-blue-500 text-white rounded px-3 py-1" type="button" onclick="location.href='{{$GoBackPlace}}'">戻る</button>
				<div class="font-semibold text-2xl text-slate-600">[契約リスト]</div>
					<form method="GET" action="/customers/ShowInpContract/{{$UserSerial}}">
						@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" disabled="disabled">物品販売</button>
						</p>
					</form>	

					<form method="GET" action="/customers/ShowInpContract/{{$UserSerial}}">
						@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit">新規契約登録（サブスク）</button>
						</p>
					</form>	
					<form method="GET" action="/customers/ShowCustomersList">
						@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" disabled="disabled">検索</button>
						<input type="text" name="kensakuKey" value="{{ old('name') }}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" >
						</p>
					</form>	
				<div>
					
					@unless($UserSerial==="all")
						顧客番号：　{{$UserSerial}}　　契約者：{{optional($userinf)->name_sei}}  &nbsp; {{optional($userinf)->name_mei}}
					@endunless					
					
					<table class="table-auto" border-solid>
						<thead>
							<tr>
								<th class="border px-4 py-2">契約番号<br>(修正)</th>
								<th class="border px-4 py-2">最終来店日<br>(支払い・施術来店記録入力)</th>
								@if($UserSerial=="all")
									<th class="border px-4 py-2">顧客番号<br>（新規作成)</th>
									<th class="border px-4 py-2">氏名</th>
								@endif
								<th class="border px-4 py-2">契約日</th>
								<th class="border px-4 py-2">契約期間</th>
								<th class="border px-4 py-2">契約金額</th>
								<th class="border px-4 py-2">残金</th>
								<th class="border px-4 py-2">支払い方法</th>
								<th class="border px-4 py-2">支払い回数</th>
								<th class="border px-4 py-2">削除</th>
							</tr>
						</thead>
					<tbody>
						@foreach ($Contracts as $dContracts)
							<tr>
							<td class="border px-4 py-2"><form action="/customers/ShowSyuseiContract/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf<input name="syusei_Btn" type="submit" value="{{$dContracts->serial_keiyaku}}"></form></td>
							<td class="border px-4 py-2"><form action="/customers/ShowInpRecordVisitPayment/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf
								@if($dContracts->date_latest_visit==Null)
									<input name="Record_Btn" type="submit" value="なし">
								@else
									<input name="Record_Btn" type="submit" value="{{$dContracts->date_latest_visit}}">
								@endif
							</form></td>
							@if($UserSerial=="all")
								<td class="border px-4 py-2"><form action="/customers/ShowInpContract/{{$dContracts->serial_user}}" method="GET">@csrf<input name="syusei_Btn" type="submit" value="{{ $dContracts->serial_user}}"></form></td>
								<td class="border px-4 py-2">{{$dContracts->name_sei}} &nbsp; {{$dContracts->name_mei}}</td>
							@endif
								<td class="border px-4 py-2">{{ $dContracts->keiyaku_bi}}</td>
								<td class="border px-4 py-2">{{ $dContracts->keiyaku_kikan_start}}-{{ $dContracts->keiyaku_kikan_end}}</td>
								<td class="border px-4 py-2" style="text-align: right;">{{ $dContracts->keiyaku_kingaku}}</td>
								<td class="border px-4 py-2" style="text-align: right;">{{ $dContracts->Keiyaku_Zankin}}</td>
								<td class="border px-4 py-2">{{ $dContracts->how_to_pay}}</td>
								<td class="border px-4 py-2">{{ $dContracts->how_many_pay_genkin}}</td>
								<td class="border px-4 py-2">
								<form action="/customers/deleteContract/{{$dContracts->serial_keiyaku}}/{{$UserSerial}}" method="GET">
									@csrf
									<input name="delete_btn" type="submit" value="削除" onclick="return delArert('{{ $dContracts->serial_user}} {{ $dContracts->name_sei}} {{ $dContracts->name_mei}}');" >
								</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			{{--{{ $Contracts->links() }}--}}
			{{$Contracts->appends(request()->query())->links()}}
			</div>
		</div>
	</div>
</div>
@endsection