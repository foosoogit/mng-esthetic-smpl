@extends('layouts.staff')
@section('content')
<div>
<script src="{{  asset('/js/DailyReport.js') }}" defer></script>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <section>
	<div class="containor">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card" align="center">
				<button class="bg-blue-500 text-white rounded px-3 py-1" type="button" onclick="location.href='../ShowMenuCustomerManagement'">メニューに戻る</button><br>
				@if($from_place=="monthly_rep")
					<form method="POST" action="/workers/ShowMonthlyReport">@csrf
						<input name="year_month_day" type="hidden" value="{{$today}}"/>
						<button type="submit" name="target_date" class="bg-blue-500 text-white rounded px-3 py-1">月報に戻る</button>
					</form>
				@endif
				<livewire:select-branch-manage>
				<div class="font-semibold text-2xl text-slate-600">[日報]</div>
					<div class="card-header">
						<h3><form action="/workers/ShowDailyReport" method="POST" name="getTargetDate_fm" id="getTargetDate_fm">@csrf<input name="target_date" id="target_date" type="date" onchange="getTargetdata(this);" value="{{$today}}"/></form></h3>
					</div>
					合計：{{number_format((int)$total)}}円
					{{--
					<button type="button" name="SerchBtn" id="SerchBtn" wire:click="search()">検索</button>
					<input type="text" name="kensakukey_txt" id="kensakukey_txt" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model.defer="kensakukey">
					<button type="button" wire:click="searchClear() onclick="document.getElementById('kensakukey_txt').value=''">解除</button> 
					--}}
					<div class="card-body">
					<table class="table-auto" border-solid>
						<thead>
							<tr>
								<th class="border px-4 py-2">No.
									{{--								
									<button type="button" wire:click="sort('serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
								</th>
								<th class="border px-4 py-2">氏名
									{{--
									<button type="button" wire:click="sort('name_sei-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('name_sei-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
								</th>
								<th class="border px-4 py-2">施術内容
									{{--
										<button type="button" wire:click="sort('name_sei-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
										<button type="button" wire:click="sort('name_sei-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
								<th class="border px-4 py-2">ｸﾚｼﾞｯﾄ・ﾛｰﾝ<br>契約数・金額(税込）
									{{--
									<button type="button" wire:click="sort('name_sei_kana-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('name_sei_kana-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
								<th class="border px-4 py-2">月額（現金分割）<br>契約数・金額(税込）
									{{--									
									<button type="button" wire:click="sort(User_Zankin-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('User_Zankin-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
								<th class="border px-4 py-2">現金売上（一括支払い）<br>契約数・金額(税込）
									{{--
									<button type="button" wire:click="sort('birth_year-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('birth_year-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
									<th class="border px-4 py-2">現金売上合計<br>契約数・金額(税込）
									{{--
									<button type="button" wire:click="sort('birth_year-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('birth_year-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>

								<th class="border px-4 py-2">施術合計<br>金額(税込）
									{{--
									<button type="button" wire:click="sort('phone-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('phone-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
							</tr>
						</thead>
					<tbody>
						@foreach ($PaymentHistories as $PaymentHistory)
							<tr>
								<td class="border px-4 py-2">{{ $PaymentHistory->serial_user}}<br></td>
								<td class="border px-4 py-2">
									<form method="POST" action="/customers/ShowCustomersList_livewire_from_top_menu">@csrf
										<button type="submit" name="btn_serial" value="{{$PaymentHistory->serial_user}}">{{ $PaymentHistory->name_sei}}&nbsp;{{ $PaymentHistory->name_mei}}</button>
										<input name="target_day" type="hidden" value="{{$today}}"/>
									</form>
								</td>
								<td class="border px-4 py-2">&nbsp;</td>
								<td class="border px-4 py-2" style="text-align: right;">
									@if($PaymentHistory->Card_Amount!=="")
										{{ number_format($PaymentHistory->Card_Amount)}}
									@endif
								</td>
								<td class="border px-4 py-2" style="text-align: right;">
									@if($PaymentHistory->Cash_Split!=="")
											{{ number_format($PaymentHistory->Cash_Split)}}
									@endif
								</td>
								<td class="border px-4 py-2" style="text-align: right;">
									@if($PaymentHistory->Cash_Amount!=="")
											{{ number_format($PaymentHistory->Cash_Amount)}}
									@endif
								</td>
								<td class="border px-4 py-2" style="text-align: right;">
									@if($PaymentHistory->Cash_Total!=="" )
											{{ number_format($PaymentHistory->CashTotal)}}
									@endif
								</td>
								<td class="border px-4 py-2" style="text-align: right;">
								@if($PaymentHistory->amount_payment!=="")
									{{$PaymentHistory->amount_payment}}
								@endif
								</td>
							</tr>
						@endforeach
						<tr>
								<td class="border px-4 py-2" colspan="3" style="text-align: right;">合計</td>
								<td class="border px-4 py-2" style="text-align: right;">
									@if($Sum['card']!=="")
										{{ number_format($Sum['card'])}}
									@endif
								</td>
								<td class="border px-4 py-2" style="text-align: right;">
									@if($Sum['CashSplit']!=="")
										{{ number_format($Sum['CashSplit'])}}
									@endif
								</td>
								<td class="border px-4 py-2" style="text-align: right;">
									@if($Sum['cash']!=="")
										{{ number_format($Sum['cash'])}}
									@endif
								</td>
								<td class="border px-4 py-2" style="text-align: right;">
									@if($Sum['total_cash']!=="")
										{!! number_format($Sum['total_cash'])!!}
									@endif
								</td>

								<td class="border px-4 py-2" style="text-align: right;">{{ number_format($Sum['total'])}}
								</td>
							</tr>

					</tbody>
				</table>
				{{--{!!$users->appends(request()->query())->links('pagination::bootstrap-4')!!}--}}
				{{ $PaymentHistories->links() }}
				施術小計：{{$subtotal_treatment}}
				<br>
				・物品販売
				<form method="GET" action="/worker/ShowInputSalesGoods/new">@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" name="CustomerListCreateBtn" value="CustomerList">新規物品売上登録</button>
						</p>
					</form>	
				<table class="table-auto" border-solid>
						<thead>
							<tr>
								<th class="border px-4 py-2">氏名<br>修正
									{{--								
									<button type="button" wire:click="sort('serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
								</th>
								<th class="border px-4 py-2">商品型番
									{{--
									<button type="button" wire:click="sort('name_sei-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('name_sei-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
								</th>
								<th class="border px-4 py-2">商品名
									{{--
									<button type="button" wire:click="sort('name_sei-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('name_sei-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
								</th>
								<th class="border px-4 py-2">カード(税込)
									{{--
										<button type="button" wire:click="sort('name_sei-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
										<button type="button" wire:click="sort('name_sei-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
								<th class="border px-4 py-2">現金(税込)
									{{--
									<button type="button" wire:click="sort('name_sei_kana-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('name_sei_kana-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
								<th class="border px-4 py-2">合計
									{{--									
									<button type="button" wire:click="sort(User_Zankin-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('User_Zankin-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
								<th class="border px-4 py-2">削除
									{{--
									<button type="button" wire:click="sort('phone-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('phone-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									--}}
									</th>
							</tr>
						</thead>
					<tbody>
						@foreach ($SalesRecords as $SalesRecord)
							<tr>
								<td class="border px-4 py-2">
									<form action="/worker/ShowInputSalesGoods/{{$SalesRecord->serial_sales}}" method="GET">@csrf
										<input name="Salse_Btn" type="submit" value="{{ $SalesRecord->name_sei}}&nbsp;{{ $SalesRecord->name_mei}}">
									</form>
								</td>
								<td class="border px-4 py-2">{{ $SalesRecord->model_number}}</td>
								<td class="border px-4 py-2">{{ $SalesRecord->good_name}}</td>
								<td class="border px-4 py-2" style="text-align: right;">{{ $SalesRecord->Cash_Amount }}</td>
								<td class="border px-4 py-2" style="text-align: right;">{{ $SalesRecord->Card_Amount }}</td>
								<td class="border px-4 py-2" style="text-align: right;">{{ $SalesRecord->Total_Amount }}</td>
								<td class="border px-4 py-2" style="text-align: right;">
								<form action="/customers/deleteSalseGood/{{$SalesRecord->serial_sales}}" method="GET">@csrf
									<input name="delete_btn" type="submit" value="削除" onclick="return delArert('販売日：{!!$SalesRecord->date_sale!!}__氏名：{!!$SalesRecord->name_sei!!}{!!$SalesRecord->name_mei!!}__商品名:{!!$SalesRecord->good_name!!}__型番:{!!$SalesRecord->model_number!!}');">
								</form></td>
							</tr>
						@endforeach
						
					</tbody>
				</table>
{{ $SalesRecords->links() }}
物品小計：{{$subtotal_good}}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
@endsection