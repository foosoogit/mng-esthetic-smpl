@extends('layouts.appCustomer')
@section('content')
	<script type="text/javascript" src="{{ asset('/js/MenuCustomerManagement.js') }}"></script>
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
						{{--<p>{!!$htm_branch_cbox!!}</p>--}}
						{{--<form wire:submit.prevent="select_branch">@csrf--}}
						<p><livewire:select-branch-manage></p>
						{{--<input type="hidden" value="hidden" name="hdn" wire:model="post.hdn">
						</form>
						<form method="GET" action="/customers/UserList">@csrf
							<button class="btn btn-primary" type="submit" >顧客一覧</button>&nbsp;修正・新規登録・契約
						</form>
						支払い不履行者<br>
						<span style="color:red;">
							<form method="POST" action="/customers/ShowCustomersList_livewire_from_top_menu">@csrf
								{!!$default_customers!!}
							</form>
							<form method="POST" action="/customers/UserList">@csrf
								<livewire:menu-customer>
							</form>
						</span><br>
						最終支払いから一ヶ月以上支払いしていない顧客（現金契約者のみ・契約支払い未完了）<br>
						<form method="GET">@csrf
							{!!$not_coming_customers!!}
						</form><br>
						--}}
						<form method="GET" action="/customers/ShowInputCustomer">@csrf<button class="btn btn-primary" type="submit" value="fromMenu" name="insertCustomerFromMenu">顧客新規登録</button>
						</form><br>
                        <p><form method="GET" action="/customers/ShowContractList/all">@csrf<button class="btn btn-primary" type="submit">契約一覧</button>&nbsp;修正・新規登録・契約</form></p><br>
						<p><form method="GET" action="/workers/ShowDailyReport">@csrf<button class="btn btn-primary" type="submit">日報</button></form></p><br>
						<form method="POST" action="/workers/ShowMonthlyReport">@csrf<p><button class="btn btn-primary" type="submit">月報</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> <select name="month"><option  value="0" >選択</option>{!!$html_month_slct!!}</select></p></form><br>
						<form method="POST" action="/workers/ShowContractsReport">@csrf<p><button class="btn btn-primary" type="submit">契約金額集計</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> <select name="month"><option  value="0" >選択</option>{!!$html_month_slct!!}</select></p></form><br>
						<form method="POST" action="/workers/ShowYearlyReport">@csrf<p><button class="btn btn-primary" type="submit">年報</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> &nbsp;決算月<select name="kesan_month" onchange="save_kessan_month(this);"><option  value="0" >選択</option>{!!$htm_kesanMonth!!}</select>&emsp;契約達成率、前年度比等</p></form><br>
						<p><form method="GET" action="/workers/ShowTreatmentContents">@csrf<button class="btn btn-primary" type="submit">施術登録</button></form></p><br>
						<p><form method="GET" action="/workers/ShowGoodsList">@csrf<button class="btn btn-primary" type="submit">商品登録</button></form></p><br>
						<p><form method="GET" action="/workers/ShowBranchList">@csrf<button class="btn btn-primary" type="submit">支店登録</button></form></p><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection