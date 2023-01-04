@extends('layouts.staff')
@section('content')
<div>
{{--
{{$title}}
<div><button type="button" wire:click="ct">change</button></div>
<div><button type="button" wire:keydown="ct" class="btn btn-primary">change2</button></div>
--}}
{{--<button wire:click="increment">+</button>
	<h1>{{ $count }}</h1> 
	--}}
	<script src="{{  asset('/js/ListCustomer.js') }}" defer></script>
<section>
	<div class="containor">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card" align="center">
				<button class="bg-blue-500 text-white rounded px-3 py-1" type="button" onclick="location.href='/menuStaff'">メニューに戻る</button>
				@if($from_place=="dayly_rep")
					<form method="POST" action="/workers/ShowDailyReport_from_customers_List">@csrf
						<input name="target_day" type="hidden" value="{{$target_day}}"/>
						<button type="submit" name="target_date" class="bg-blue-500 text-white rounded px-3 py-1" value="{{$target_day}}">日報に戻る</button>
					</form>
				@endif
				<div class="font-semibold text-2xl text-slate-600">[顧客リスト]</div>
					<form method="GET" action="/customers/ShowInputCustomer">@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" name="CustomerListCreateBtn" value="CustomerList">新規顧客登録</button>
						</p>
					</form>	
					<div class="card-header">
						<h3>顧客一覧</h3>
					</div>
					<button type="button" name="SerchBtn" id="SerchBtn" wire:click="search()">検索</button>
						<input type="text" name="kensakukey_txt" id="kensakukey_txt" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model.defer="kensakukey">
					<button type="button" wire:click="searchClear() onclick="document.getElementById('kensakukey_txt').value=''">解除</button> 
					<div class="card-body">
					<table class="table-auto" border-solid>
						<thead>
							<tr>
								<th class="border px-4 py-2">顧客データ修正<br>
									<div><button type="button" wire:click="sort('serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button></div>
									<button type="button" wire:click="sort('serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
								<th class="border px-4 py-2">契約</th>
								<th class="border px-4 py-2">氏名(カルテ)
									<button type="button" wire:click="sort('name_sei-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('name_sei-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
								<th class="border px-4 py-2">しめい
									<button type="button" wire:click="sort('name_sei_kana-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('name_sei_kana-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
								<th class="border px-4 py-2">残金
									<button type="button" wire:click="sort('zankin-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('zankin-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
									<br>(合計:<button type="button" name="zankinBtn" id="zankinBtn" wire:click="zankin_search()">{{number_format($totalZankin)}}</button>円)
								</th>
								<th class="border px-4 py-2">生年月日
									<button type="button" wire:click="sort('birth_year-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('birth_year-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
								<th class="border px-4 py-2">電話番号
									<button type="button" wire:click="sort('phone-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
									<button type="button" wire:click="sort('phone-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
								<th class="border px-4 py-2">削除</th>
							</tr>
						</thead>
					<tbody>
						@foreach ($users as $user)
							<tr>
								<td class="border px-4 py-2"><form action="ShowSyuseiCustomer" method="POST">@csrf<input name="syusei_Btn" type="submit" value="{{ $user->serial_user}}"></form>
</td>
								<td class="border px-4 py-2">
									<form action="/customers/ShowContractList/{{$user->serial_user}}" method="POST">@csrf<input name="keiyaku_Btn" type="submit" value="履歴・新規">
									<input name="page_num" type="hidden" value="{{$users->currentPage()}}"/>
									</form>
								</td>
								<td class="border px-4 py-2" {!! $user->default_color!!}>{{ $user->name_sei}}&nbsp;{{ $user->name_mei}}</td>
								<td class="border px-4 py-2">{{ $user->name_sei_kana}}&nbsp;{{ $user->name_mei_kana}}</td>
								<td class="border px-4 py-2" style="text-align: right;">{{ number_format($user->zankin)}}</td>
								<td class="border px-4 py-2">{{ $user->birth_year}}-{{ $user->birth_month}}-{{ $user->birth_day}}&nbsp;({{ $user->User_Age}})</td>
								<td class="border px-4 py-2">{{ $user->phone}}</td>
								<td class="border px-4 py-2">
								<form action="/customers/deleteCustomer/{{$user->serial_user}}" method="GET">
									@csrf
									<input name="delete_btn" type="submit" value="削除" onclick="return delArert('{{ $user->serial_user}} {{ $user->name_sei}} {{ $user->name_mei}}');" >
									@if (auth('staff')->user()->serial_staff==='A_0001')
										<input name="delete_btn" type="submit" value="完全削除" onclick="return delArert('{{ $user->serial_user}} {{ $user->name_sei}} {{ $user->name_mei}}');" >
									@endif
								</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				
				{{--{{$users->appends(request()->input())->render()}}--}}
				{{$users->appends(request()->query())->links('pagination::bootstrap-4')}}
				{{--{{ $users->links() }}--}}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
@endsection