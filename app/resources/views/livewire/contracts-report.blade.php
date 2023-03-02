<div>
<script src="{{  asset('/js/ContractsReport.js') }}" defer></script>
     <section>
	<div class="containor">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card" align="center">
                <div class="row justify-content-center">
				<div class="col-auto"><button class="btn btn-primary active" type="button" onclick="location.href='../ShowMenuCustomerManagement'">戻る</button></div>
                </div>
				<div class="font-semibold text-2xl text-slate-600">[契約金額集計]</div>
	
					<div class="card-header">
					<form method="POST" action="/workers/ShowContractsReport" name="ChangeTargetMonth_fm" id="ChangeTargetMonth_fm">@csrf
						<h3>売上単価・現金比率<select name="year" onchange="ChangeTargetMonth();">{!!$html_year_slct!!}</select> <select name="month" onchange="ChangeTargetMonth();"><option  value="0" >選択</option>{!!$html_month_slct!!}</select></h3>
					</form>契約金額合計：{{ number_format($ruikei_keiyaku_amount) }}円  契約人数合計：{{ $ruikei_contract_cnt }}<br> 目標金額{{ number_format((float) $TargetSales ) }}円  目標達成率{!!$rate!!}%

					</div>
					<div class="card-body">
					{!! $contract_report_table !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

</div>
