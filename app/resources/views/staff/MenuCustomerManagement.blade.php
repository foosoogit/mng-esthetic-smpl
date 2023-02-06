@extends('layouts.appCustomer')
@section('content')
<script src="{{  asset('/js/MenuCustomerManagement.js') }}" defer></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <ul>
                    	@canany('viewAny', Auth::guard('staff')->user())
                            <li><a href="/users">社員一覧</a></li>
						@endcanany
                        <li><p>
						<form method="GET" action="/customers/UserList">
						{{--<form method="GET" action="/customers/ShowCustomersList_livewire">--}}@csrf
							<button class="btn btn-primary" type="submit" >顧客一覧</button>&nbsp;修正・新規登録・契約
						</form>
						{{--
							<form method="GET" action="/ShowUserList">@csrf
							<button class="bg-blue-500 text-black rounded px-3 py-1" type="submit" >顧客一覧Test</button>&nbsp;修正・新規登録・契約
						</form>
						<form method="GET" action="/customers/livewire_test">@csrf
							<button class="bg-blue-500 text-black rounded px-3 py-1" type="submit" >livewire Test</button>&nbsp;修正・新規登録・契約
						</form>
						--}}
						支払い不履行者<br>
					<span style="color:red;">
					<form method="POST" action="/customers/ShowCustomersList_livewire_from_top_menu">@csrf
						{!!$default_customers!!}
					</form>
					{{--
					@foreach ($DefaultUsersInf as $DefaultUserInf)
    					&nbsp;・{{ $DefaultUserInf->name_sei }}&nbsp;{{ $DefaultUserInf->name_mei }}
					@endforeach
					--}}
					</span><br>
							最終支払いから一ヶ月以上支払いしていない顧客（現金契約者のみ・契約支払い未完了）<br>
					{{--<form method="POST" action="/customers/ShowCustomersList_livewire_from_top_menu">@csrf--}}
					<form method="GET">@csrf
						{!!$not_coming_customers!!}
					</form>
					{{--
					@csrf
					@foreach ($not_coming_customers as $not_coming_customer)
    						&nbsp;・{!! $not_coming_customer !!}
					@endforeach
					--}}
				</li>
				<br>
				@if (auth('staff')->user()->serial_staff==='A_0001')
				{{--<li><p><button class="bg-blue-500 text-black rounded px-3 py-1" type="submit" formaction="/customers/ShowCustomersList_livewire">顧客一覧 livewire</button>&emsp;修正・新規登録・契約</p></li><br> --}}
				@endif
				<li><form method="GET" action="/customers/ShowInputCustomer">@csrf<button class="btn btn-primary" type="submit" value="fromMenu" name="insertCustomerFromMenu">顧客新規登録</button>
				</form></li><br>
                             <li><p><form method="GET" action="/customers/ShowContractList/all">@csrf<button class="btn btn-primary" type="submit">契約一覧</button>&nbsp;修正・新規登録・契約</form></p></li><br>
				<li><p><form method="GET" action="/workers/ShowDailyReport">@csrf<button class="btn btn-primary" type="submit">日報</button></form></p></li><br>
				<li><form method="POST" action="/workers/ShowMonthlyReport">@csrf<p><button class="btn btn-primary" type="submit">月報</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> <select name="month"><option  value="0" >選択</option>{!!$html_month_slct!!}</select></p></form></li><br>
				<li><form method="POST" action="/workers/ShowContractsReport">@csrf<p><button class="btn btn-primary" type="submit">契約金額集計</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> <select name="month"><option  value="0" >選択</option>{!!$html_month_slct!!}</select></p></form></li><br>
				{{--@if (auth('teacher')->user()->serial_teacher==='A_0001')--}}
				<li><form method="POST" action="/workers/ShowYearlyReport">@csrf<p><button class="btn btn-primary" type="submit">年報</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> &nbsp;決算月<select name="kesan_month" onchange="save_kessan_month(this);"><option  value="0" >選択</option>{!!$htm_kesanMonth!!}</select>&emsp;契約達成率、前年度比等</p></form></li><br>
				{{--@endif--}}

				<li><p><form method="GET" action="/workers/ShowTreatmentContents">@csrf<button class="btn btn-primary" type="submit">施術登録</button></form></p></li><br>
				<li><p><form method="GET" action="/workers/ShowGoodsList">@csrf<button class="btn btn-primary" type="submit">商品登録</button></form></p></li><br>
				<li><p><form method="GET" action="/workers/ShowBranchList">@csrf<button class="btn btn-primary" type="submit">支店登録</button></form></p></li><br>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection