<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="containor">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card" align="center">
				<button class="bg-blue-500 text-white rounded px-3 py-1" type="button" onclick="location.href='../ShowMenuCustomerManagement'">メニュー戻る</button>
				<div class="font-semibold text-2xl text-slate-600">[月報]</div>
					<form method="GET" action="/customers/ShowInputCustomer">@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" name="CustomerListCreateBtn" value="CustomerList">新規顧客登録</button>
						</p>
					</form>	
					<div class="card-header">
					<form method="POST" action="/staff/MonthlyRep" name="ChangeTargetMonth_fm" id="ChangeTargetMonth_fm">@csrf
						<div class="col-auto">{!!$htm_branch_cbox!!}</div>{{$tst}}<h3>売上単価・現金比率<select name="year" onchange="ChangeTargetMonth();">{!!$html_year_slct!!}</select> <select name="month" onchange="ChangeTargetMonth();"><option  value="0" >選択</option>{!!$html_month_slct!!}</select></h3>
					</form>
					</div>
					<div class="card-body">
					{!! $RaitenReason !!}
					<form method="POST" action="/workers/ShowDailyReport_from_monthly_report">@csrf
					{!! $monthly_report_table !!}
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
