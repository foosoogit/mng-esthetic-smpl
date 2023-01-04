@extends('layouts.appCustomer')
@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Dashboard') }}</div>
				<div class="card-body">
					{!!$msg!!}
					<ul>
					<li><form method="GET" action="/customers/ShowInpContract/{{$targetSerial}}">@csrf
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit">続けて契約書を作成</button>
					</form></li><br>
					<li><form method="GET" action="/customers/ShowInputCustomer">@csrf
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit">新規顧客追加</button>
					</form></li><br>
					<li>
					{{--
					<form method="GET" action="../ShowMenuCustomerManagement">@csrf
					--}}
						<form method="GET" action="{{$GoToBackPlace}}">@csrf
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit">戻る</button>
					</form></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection