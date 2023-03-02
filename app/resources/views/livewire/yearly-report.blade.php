<div>
   <section>
	<div class="containor">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card" align="center">
                <div class="row justify-content-center">
				<div class="col-auto"><button class="btn btn-primary active" type="button" onclick="location.href='../ShowMenuCustomerManagement'">戻る</button></div>
                </div>
				<div class="font-semibold text-2xl text-slate-600">[契約金額集計]</div>
					<div class="card-body">
						<table class="border px-4 py-2">
							<tr>
								<td class="border px-4 py-2">&nbsp;</td>
								<td colspan="9" class="border px-4 py-2">2022年度</td>
								<td colspan="3" class="border px-4 py-2">2021年度</td>
								<td colspan="3" class="border px-4 py-2">2020年度</td>
							</tr>
							{!! $yearly_report_table !!}
						</table>
    				</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
