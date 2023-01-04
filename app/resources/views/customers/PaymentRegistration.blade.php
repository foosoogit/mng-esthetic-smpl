@extends('layouts.appCustomer')
@section('content')
<script type="text/javascript" src="{{ asset('/js/PaymentRegistration.js') }}"></script>
<style type="text/css">
input{border: 1px solid #aaa;}
table td {border: 1px solid #aaa;}
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
				<a href="../../../ShowMenuCustomerManagement" class="btn bg-blue-500  rounded px-3 py-2">メニュー</a>
				<a href="{{$GoBackToPlace}}" class="btn bg-blue-500  rounded px-3 py-2">戻る</a>
				<a href="/customers/ShowSyuseiContract/{{$targetContract->serial_keiyaku}}/{{$targetContract->serial_user}}" class="btn bg-blue-500 rounded px-3 py-2">契約書</a>
		<div class="card-header">顧客</div>
		<p>氏名：{{ optional($targetUser)->name_sei }}&nbsp;{{ optional($targetUser)->name_mei }}</p>
			<p>契約日: {{$targetContract->keiyaku_bi}}</p>
			<p>契約内容: {{$KeiyakuNaiyou}}</p>
			<p>契約期間: {{$targetContract->keiyaku_kikan_start}}～{{$targetContract->keiyaku_kikan_end}}</p>
			<p>契約金額: {{$targetContract->keiyaku_kingaku}}</p>
			<form action="{{ route('recordVisitPaymentHistory.post') }}" method="POST">
			@csrf
				<table style="width: 100%">
				<tr>
					<td colspan="12">支払い記録（支払い回数：{{$paymentCount}}回）</td>
				</tr>
				<tr>
					<td style="text-align: center;{!!$set_gray_pay_array[0]!!}"}>1ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[1]!!}"}>2ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[2]!!}"}>3ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[3]!!}"}>4ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[4]!!}"}>5ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[5]!!}"}>6ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[6]!!}"}>7ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[7]!!}"}>8ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[8]!!}"}>9ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[9]!!}"}>10ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[10]!!}"}>11ヶ月目</td>
					<td style="text-align: center;{!!$set_gray_pay_array[11]!!}"}>12ヶ月目</td>
				</tr>
				
				<tr>
					<td><input name="PaymentAmount[]" type="text"  style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[0]!!}" value="{{optional($PaymentAmountArray)[0]}}" {{$payment_disabeled[0]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%; {!!$set_background_gray_pay_array[1]!!}" value="{{optional($PaymentAmountArray)[1]}}" {{$payment_disabeled[1]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[2]!!}" value="{{optional($PaymentAmountArray)[2]}}"  {{$payment_disabeled[2]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[3]!!}" value="{{optional($PaymentAmountArray)[3]}}"  {{$payment_disabeled[3]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[4]!!}" value="{{optional($PaymentAmountArray)[4]}}"  {{$payment_disabeled[4]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[5]!!}" value="{{optional($PaymentAmountArray)[5]}}"  {{$payment_disabeled[5]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[6]!!} " value="{{optional($PaymentAmountArray)[6]}}" {{$payment_disabeled[6]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[7]!!}" value="{{optional($PaymentAmountArray)[7]}}"  {{$payment_disabeled[7]}}/></td>
					<td><input name="PaymentAmount[]" type="text"style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[8]!!} "  value="{{optional($PaymentAmountArray)[8]}}" {{$payment_disabeled[8]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[9]!!}" value="{{optional($PaymentAmountArray)[9]}}"  {{$payment_disabeled[9]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%; {!!$set_background_gray_pay_array[10]!!}" value="{{optional($PaymentAmountArray)[10]}}" {{$payment_disabeled[10]}}/></td>
					<td><input name="PaymentAmount[]" type="text" style="text-align: right;width: 100%;{!!$set_background_gray_pay_array[11]!!}" value="{{optional($PaymentAmountArray)[11]}}" {{$payment_disabeled[11]}}/></td>
				</tr>
				<tr>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[0]}}"  style="{!!$set_gray_pay_array[0]!!}" {{$payment_disabeled[0]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[1]}}" style="{!!$set_gray_pay_array[1]!!}" {{$payment_disabeled[1]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[2]}}" style="{!!$set_gray_pay_array[2]!!}" {{$payment_disabeled[2]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[3]}}" style="{!!$set_gray_pay_array[3]!!}" {{$payment_disabeled[3]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[4]}}" style="{!!$set_gray_pay_array[4]!!}" {{$payment_disabeled[4]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[5]}}" style="{!!$set_gray_pay_array[5]!!}" {{$payment_disabeled[5]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[6]}}" style="{!!$set_gray_pay_array[6]!!}" {{$payment_disabeled[6]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[7]}}" style="{!!$set_gray_pay_array[7]!!}" {{$payment_disabeled[7]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[8]}}" style="{!!$set_gray_pay_array[8]!!}" {{$payment_disabeled[8]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[9]}}" style="{!!$set_gray_pay_array[9]!!}" {{$payment_disabeled[9]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[10]}}" style="{!!$set_gray_pay_array[10]!!}" {{$payment_disabeled[10]}}/></td>
					<td><input name="PaymentDate[]" type="date" value="{{optional($PaymentDateArray)[11]}}" style="{!!$set_gray_pay_array[11]!!}" {{$payment_disabeled[11]}}/></td>
				</tr>
				<tr>
					<td style="{!!$set_gray_pay_array[0]!!}">
					<label style="{!!$set_gray_pay_array[0]!!}"><input name="HowToPay[0]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[0])[0]!!}  {{$payment_disabeled[0]}}/>カード</label>
					<br><label style="{!!$set_gray_pay_array[0]!!}"><input name="HowToPay[0]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[0])[1]!!}  {{$payment_disabeled[0]}}/>PayPay</label>

					<br><label style="{!!$set_gray_pay_array[0]!!}"><input name="HowToPay[0]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[0])[2]!!} {{$payment_disabeled[0]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[0]!!}"><input name="HowToPay[0]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[0])[3]!!} {{$payment_disabeled[0]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[1]!!}">
					<label style="{!!$set_gray_pay_array[1]!!}"><input name="HowToPay[1]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[1])[0]!!} {{$payment_disabeled[1]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[1]!!}"><input name="HowToPay[1]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[1])[1]!!} {{$payment_disabeled[1]}}/>PayPay</label>

					
					<br><label style="{!!$set_gray_pay_array[1]!!}"><input name="HowToPay[1]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[1])[2]!!} {{$payment_disabeled[1]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[1]!!}"><input name="HowToPay[1]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[1])[3]!!} {{$payment_disabeled[1]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[2]!!}">
					<label style="{!!$set_gray_pay_array[2]!!}"><input name="HowToPay[2]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[2])[0]!!} {{$payment_disabeled[2]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[2]!!}"><input name="HowToPay[2]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[2])[1]!!} {{$payment_disabeled[2]}}/>PayPay</label>

					<br><label style="{!!$set_gray_pay_array[2]!!}"><input name="HowToPay[2]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[2])[2]!!} {{$payment_disabeled[2]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[2]!!}"><input name="HowToPay[2]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[2])[3]!!} {{$payment_disabeled[2]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[3]!!}">
					<label style="{!!$set_gray_pay_array[3]!!}"><input name="HowToPay[3]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[3])[0]!!} {{$payment_disabeled[3]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[3]!!}"><input name="HowToPay[3]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[3])[1]!!} {{$payment_disabeled[3]}}/>PayPay</label>
					
					<br><label style="{!!$set_gray_pay_array[3]!!}"><input name="HowToPay[3]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[3])[2]!!} {{$payment_disabeled[3]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[3]!!}"><input name="HowToPay[3]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[3])[3]!!} {{$payment_disabeled[3]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[4]!!}">
					<label style="{!!$set_gray_pay_array[4]!!}"><input name="HowToPay[4]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[4])[0]!!} {{$payment_disabeled[4]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[4]!!}"><input name="HowToPay[4]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[4])[1]!!} {{$payment_disabeled[4]}}/>PayPay</label>
					
					<br><label style="{!!$set_gray_pay_array[4]!!}"><input name="HowToPay[4]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[4])[2]!!} {{$payment_disabeled[4]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[4]!!}"><input name="HowToPay[4]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[4])[3]!!} {{$payment_disabeled[4]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[5]!!}">
					<label style="{!!$set_gray_pay_array[5]!!}"><input name="HowToPay[5]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[5])[0]!!} {{$payment_disabeled[5]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[5]!!}"><input name="HowToPay[5]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[5])[1]!!} {{$payment_disabeled[5]}}/>PayPay</label>
			
					<br><label style="{!!$set_gray_pay_array[5]!!}"><input name="HowToPay[5]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[5])[2]!!} {{$payment_disabeled[5]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[5]!!}"><input name="HowToPay[5]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[5])[3]!!} {{$payment_disabeled[5]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[6]!!}">
					<label style="{!!$set_gray_pay_array[6]!!}"><input name="HowToPay[6]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[6])[0]!!} {{$payment_disabeled[6]}}/>カード</label>

					<br><label style="{!!$set_gray_pay_array[6]!!}"><input name="HowToPay[6]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[6])[1]!!} {{$payment_disabeled[6]}}/>PayPay</label>
					
					<br><label style="{!!$set_gray_pay_array[6]!!}"><input name="HowToPay[6]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[6])[2]!!} {{$payment_disabeled[6]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[6]!!}"><input name="HowToPay[6]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[6])[3]!!} {{$payment_disabeled[6]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[7]!!}">
					<label style="{!!$set_gray_pay_array[7]!!}"><input name="HowToPay[7]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[7])[0]!!} {{$payment_disabeled[7]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[7]!!}"><input name="HowToPay[7]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[7])[1]!!} {{$payment_disabeled[7]}}/>PayPay</label>
					
					<br><label style="{!!$set_gray_pay_array[7]!!}"><input name="HowToPay[7]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[7])[2]!!} {{$payment_disabeled[7]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[7]!!}"><input name="HowToPay[7]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[7])[3]!!} {{$payment_disabeled[7]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[8]!!}">
					<label style="{!!$set_gray_pay_array[8]!!}"><input name="HowToPay[8]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[8])[0]!!} {{$payment_disabeled[8]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[8]!!}"><input name="HowToPay[8]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[8])[1]!!} {{$payment_disabeled[8]}}/>PayPay</label>

					<br><label style="{!!$set_gray_pay_array[8]!!}"><input name="HowToPay[8]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[8])[2]!!} {{$payment_disabeled[8]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[8]!!}"><input name="HowToPay[8]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[8])[3]!!} {{$payment_disabeled[8]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[9]!!}">
					<label style="{!!$set_gray_pay_array[9]!!}"><input name="HowToPay[9]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[9])[0]!!} {{$payment_disabeled[9]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[9]!!}"><input name="HowToPay[9]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[9])[1]!!} {{$payment_disabeled[9]}}/>PayPay</label>
					
					<br><label style="{!!$set_gray_pay_array[9]!!}"><input name="HowToPay[9]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[9])[2]!!} {{$payment_disabeled[9]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[9]!!}"><input name="HowToPay[9]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[9])[3]!!} {{$payment_disabeled[9]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[10]!!}">
					<label style="{!!$set_gray_pay_array[10]!!}"><input name="HowToPay[10]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[10])[0]!!} {{$payment_disabeled[10]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[10]!!}"><input name="HowToPay[10]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[10])[1]!!} {{$payment_disabeled[10]}}/>PayPay</label>

					<br><label style="{!!$set_gray_pay_array[10]!!}"><input name="HowToPay[10]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[10])[2]!!} {{$payment_disabeled[10]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[10]!!}"><input name="HowToPay[10]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[10])[3]!!} {{$payment_disabeled[10]}}/>支払い不履行</label>
					</td>
					
					<td style="{!!$set_gray_pay_array[11]!!}">
					<label style="{!!$set_gray_pay_array[11]!!}"><input name="HowToPay[11]" type="radio" value="card" onclick="radioDeselection(this, 1)" {!!optional($HowToPayCheckedArray[11])[0]!!} {{$payment_disabeled[11]}}/>カード</label>
					
					<br><label style="{!!$set_gray_pay_array[11]!!}"><input name="HowToPay[11]" type="radio" value="paypay" onclick="radioDeselection(this, 2)" {!!optional($HowToPayCheckedArray[11])[1]!!} {{$payment_disabeled[11]}}/>PayPay</label>

					<br><label style="{!!$set_gray_pay_array[11]!!}"><input name="HowToPay[11]" type="radio" value="cash" onclick="radioDeselection(this, 3)" {!!optional($HowToPayCheckedArray[11])[2]!!} {{$payment_disabeled[11]}}/>現金</label>
					
					<br><label style="{!!$set_gray_pay_array[11]!!}"><input name="HowToPay[11]" type="radio" value="default" onclick="radioDeselection(this, 4)" {!!optional($HowToPayCheckedArray[11])[3]!!} {{$payment_disabeled[11]}}/>支払い不履行</label>
					</td>
				</tr>
				</table>
				<br>
				<table style="width: 100%">
					<tr>
						<td colspan="8">施術記録(契約施術回数：{{$sejyutukaisu->treatments_num}}回)</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[0]!!} style="height: 22px">1回</td>
						<td {!!$set_gray_array[1]!!} style="height: 22px">2回</td>
						<td {!!$set_gray_array[2]!!} style="height: 22px">3回</td>
						<td {!!$set_gray_array[3]!!} style="height: 22px">4回</td>
						<td {!!$set_gray_array[4]!!} style="height: 22px">5回</td>
						<td {!!$set_gray_array[5]!!} style="height: 22px">6回</td>
						<td {!!$set_gray_array[6]!!} style="height: 22px">7回</td>
						<td {!!$set_gray_array[7]!!} style="height: 22px">8回</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[0]!!}>
						<input name="visitDate[]" id="visitDateId[0]" type="date" value="{{optional($VisitDateArray)[0]}}" {!!$set_gray_array[0]!!} {{$visit_disabeled[0]}}/></td>
						<td {!!$set_gray_array[1]!!}>
						<input name="visitDate[]" id="visitDateId[1]" type="date" value="{{optional($VisitDateArray)[1]}}" {!!$set_gray_array[1]!!} {{$visit_disabeled[1]}}/></td>
						<td {!!$set_gray_array[2]!!}>
						<input name="visitDate[]" id="visitDateId[2]" type="date" value="{{optional($VisitDateArray)[2]}}" {!!$set_gray_array[2]!!} {{$visit_disabeled[2]}}/></td>
						<td {!!$set_gray_array[3]!!}>
						<input name="visitDate[]" id="visitDateId[3]" type="date" value="{{optional($VisitDateArray)[3]}}" {!!$set_gray_array[3]!!} {{$visit_disabeled[3]}}/></td>
						<td {!!$set_gray_array[4]!!}>
						<input name="visitDate[]" id="visitDateId[4]" type="date" value="{{optional($VisitDateArray)[4]}}" {!!$set_gray_array[4]!!} {{$visit_disabeled[4]}}/></td>
						<td {!!$set_gray_array[5]!!}>
						<input name="visitDate[]" id="visitDateId[5]" type="date" value="{{optional($VisitDateArray)[5]}}" {!!$set_gray_array[5]!!} {{$visit_disabeled[5]}}/></td>
						<td {!!$set_gray_array[6]!!}>
						<input name="visitDate[]" id="visitDateId[6]" type="date" value="{{optional($VisitDateArray)[6]}}" {!!$set_gray_array[6]!!} {{$visit_disabeled[6]}}/></td>
						<td {!!$set_gray_array[7]!!}>
						<input name="visitDate[]" id="visitDateId[7]" type="date" value="{{optional($VisitDateArray)[7]}}" {!!$set_gray_array[7]!!} {{$visit_disabeled[7]}}/></td>
					</tr>
					<tr>
						<td {!!$set_gray_array[0]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[0]!!}</select><br>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[0]}}" {!!$set_gray_array[0]!!} {{$visit_disabeled[0]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[1]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[1]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[1]}}" {!!$set_gray_array[1]!!} {{$visit_disabeled[1]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[2]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[2]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[2]}}" {!!$set_gray_array[2]!!} {{$visit_disabeled[2]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[3]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[3]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[3]}}" {!!$set_gray_array[3]!!} {{$visit_disabeled[3]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[4]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[4]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[4]}}" {!!$set_gray_array[4]!!} {{$visit_disabeled[4]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[5]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[5]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[5]}}" {!!$set_gray_array[5]!!} {{$visit_disabeled[5]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[6]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[6]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[6]}}" {!!$set_gray_array[6]!!} {{$visit_disabeled[6]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[7]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[7]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[7]}}" {!!$set_gray_array[7]!!} {{$visit_disabeled[7]}} placeholder="施術内容"/>--}}
						</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[10]!!} colspan="8">&nbsp;</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[8]!!} style="height: 22px">9回</td>
						<td {!!$set_gray_array[9]!!} style="height: 22px">10回</td>
						<td {!!$set_gray_array[10]!!}>11回</td>
						<td {!!$set_gray_array[11]!!}>12回</td>
						<td {!!$set_gray_array[12]!!}>13回</td>
						<td {!!$set_gray_array[13]!!}>14回</td>
						<td {!!$set_gray_array[14]!!}>15回</td>
						<td {!!$set_gray_array[15]!!}>16回</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[8]!!}>
						<input name="visitDate[]" id="visitDateId[8]" type="date" value="{{optional($VisitDateArray)[8]}}" {!!$set_gray_array[8]!!} {{$visit_disabeled[8]}}/></td>
						<td {!!$set_gray_array[9]!!}>
						<input name="visitDate[]" id="visitDateId[9]" type="date" value="{{optional($VisitDateArray)[9]}}" {!!$set_gray_array[9]!!} {{$visit_disabeled[9]}}/></td>
						<td {!!$set_gray_array[10]!!}>
						<input name="visitDate[]" id="visitDateId[10]" type="date" value="{{optional($VisitDateArray)[10]}}" {!!$set_gray_array[10]!!} {{$visit_disabeled[10]}}/></td>
						<td {!!$set_gray_array[11]!!}>
						<input name="visitDate[]" id="visitDateId[11]" type="date" value="{{optional($VisitDateArray)[11]}}" {!!$set_gray_array[11]!!} {{$visit_disabeled[11]}}/></td>
						<td {!!$set_gray_array[12]!!}>
						<input name="visitDate[]" id="visitDateId[12]" type="date" value="{{optional($VisitDateArray)[12]}}" {!!$set_gray_array[12]!!} {{$visit_disabeled[12]}}/></td>
						<td {!!$set_gray_array[13]!!}>
						<input name="visitDate[]" id="visitDateId[13]" type="date" value="{{optional($VisitDateArray)[13]}}" {!!$set_gray_array[13]!!} {{$visit_disabeled[13]}}/></td>
						<td {!!$set_gray_array[14]!!}>
						<input name="visitDate[]" id="visitDateId[14]" type="date" value="{{optional($VisitDateArray)[14]}}" {!!$set_gray_array[14]!!} {{$visit_disabeled[14]}}/></td>
						<td {!!$set_gray_array[15]!!}>
						<input name="visitDate[]" id="visitDateId[15]" type="date" value="{{optional($VisitDateArray)[15]}}" {!!$set_gray_array[15]!!} {{$visit_disabeled[15]}}/></td>
					</tr>
					<tr>
						<td {!!$set_gray_array[8]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[8]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[8]}}" {!!$set_gray_array[8]!!} {{$visit_disabeled[8]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[9]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[9]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[9]}}" {!!$set_gray_array[9]!!} {{$visit_disabeled[9]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[10]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[10]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[10]}}" {!!$set_gray_array[10]!!} {{$visit_disabeled[10]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[11]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[11]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[11]}}" {!!$set_gray_array[11]!!} {{$visit_disabeled[11]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[12]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[12]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[12]}}" {!!$set_gray_array[12]!!} {{$visit_disabeled[12]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[13]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[13]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[13]}}" {!!$set_gray_array[13]!!} {{$visit_disabeled[13]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[14]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[14]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[14]}}" {!!$set_gray_array[14]!!} {{$visit_disabeled[14]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[15]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[15]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[15]}}" {!!$set_gray_array[15]!!} {{$visit_disabeled[15]}} placeholder="施術内容"/>--}}
						</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[10]!!} colspan="8">&nbsp;</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[16]!!}>17回</td>
						<td {!!$set_gray_array[17]!!}>18回</td>
						<td {!!$set_gray_array[18]!!}>19回</td>
						<td {!!$set_gray_array[19]!!}>20回</td>
						<td {!!$set_gray_array[20]!!}>21回</td>
						<td {!!$set_gray_array[21]!!}>22回</td>
						<td {!!$set_gray_array[22]!!}>23回</td>
						<td {!!$set_gray_array[23]!!}>24回</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[16]!!}>
						<input name="visitDate[]" id="visitDateId[16]" type="date" value="{{optional($VisitDateArray)[16]}}"  {!!$set_gray_array[16]!!} {{$visit_disabeled[16]}}/></td>
						<td {!!$set_gray_array[17]!!}>
						<input name="visitDate[]" id="visitDateId[17]" type="date" value="{{optional($VisitDateArray)[17]}}"  {!!$set_gray_array[16]!!} {{$visit_disabeled[17]}}/></td>
						<td {!!$set_gray_array[18]!!}>
						<input name="visitDate[]" id="visitDateId[18]" type="date" value="{{optional($VisitDateArray)[18]}}"  {!!$set_gray_array[16]!!} {{$visit_disabeled[18]}}/></td>
						<td {!!$set_gray_array[19]!!}>
						<input name="visitDate[]" id="visitDateId[19]" type="date" value="{{optional($VisitDateArray)[19]}}"  {!!$set_gray_array[16]!!} {{$visit_disabeled[19]}}/></td>
						<td {!!$set_gray_array[20]!!}>
						<input name="visitDate[]" id="visitDateId[20]" type="date" value="{{optional($VisitDateArray)[20]}}" {!!$set_gray_array[20]!!} {{$visit_disabeled[20]}}/></td>
						<td {!!$set_gray_array[21]!!}>
						<input name="visitDate[]" id="visitDateId[21]" type="date" value="{{optional($VisitDateArray)[21]}}" {!!$set_gray_array[21]!!} {{$visit_disabeled[21]}}/></td>
						<td {!!$set_gray_array[22]!!}>
						<input name="visitDate[]" id="visitDateId[22]" type="date" value="{{optional($VisitDateArray)[22]}}" {!!$set_gray_array[22]!!} {{$visit_disabeled[22]}}/></td>
						<td {!!$set_gray_array[23]!!}>
						<input name="visitDate[]" id="visitDateId[23]" type="date" value="{{optional($VisitDateArray)[23]}}" {!!$set_gray_array[23]!!} {{$visit_disabeled[23]}}/></td>
					</tr>
					<tr>
						<td {!!$set_gray_array[16]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[16]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[16]}}" {!!$set_gray_array[16]!!} {{$visit_disabeled[16]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[17]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[17]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[17]}}" {!!$set_gray_array[17]!!} {{$visit_disabeled[17]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[18]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[18]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[18]}}" {!!$set_gray_array[18]!!} {{$visit_disabeled[18]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[19]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[19]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[19]}}" {!!$set_gray_array[19]!!} {{$visit_disabeled[19]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[20]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[20]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[20]}}" {!!$set_gray_array[20]!!} {{$visit_disabeled[20]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[21]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[21]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[21]}}" {!!$set_gray_array[21]!!} {{$visit_disabeled[21]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[22]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[22]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[22]}}" {!!$set_gray_array[22]!!} {{$visit_disabeled[22]}} placeholder="施術内容"/>--}}
						</td>
						<td {!!$set_gray_array[23]!!}>
						<select name="TreatmentDetailsSelect[]" style="width:200px">{!!$TreatmentDetailsSelectArray[23]!!}</select>
						{{--<input name="TreatmentDetails[]" type="Text" value="{{optional($TreatmentDetailsArray)[23]}}" {!!$set_gray_array[23]!!} {{$visit_disabeled[23]}} placeholder="施術内容"/>--}}
						</td>
					</tr>
					<tr>
						<td {!!$set_gray_array[20]!!} colspan="8" style="height: 9px"></td>
					</tr>


					<tr>
						<td>メモ</td>
						<td colspan="7">
						<textarea cols="20" name="TextArea1" rows="2" disabled="disabled"></textarea></td>
					</tr>
				</table>
				<script>
					@if ($errors->any())
						alert("{{ implode('\n', $errors->all()) }}");
					@elseif (session()->has('success'))
						alert("{{ session()->get('success') }}");
					@endif
				</script>
				
				@if(optional($targetContract)->cancel===null)
					<p style="text-align: center"><button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" name="KeiyakuSerialBtn" id="KeiyakuSerialBtn" onclick="return payment_manage();">　　登　録　　</button></p>
				@else
					<p style="text-align: center"><button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" name="KeiyakuSerialBtn" id="KeiyakuSerialBtn" onclick="return canceled_message();" style="background-color:gray">　　登　録　　</button></p>
				@endif
				</form>
                        <p>郵便番号：{{ $targetUser->postal }}</p>
                        <p>住所：{{ $targetUser->address }}</p>
                        <p>メール：{{ $targetUser->email }}</p>
                        <p>生年月日：{{ $targetUser->birthdate }}</p>
                        <p>電話番号：{{$targetUser->phone }}</p>
                {{--
                 <button class="bg-blue-500 text-white rounded px-3 py-2" type="submit" formaction="../ShowInpContract/{{$targetUser->serial_user}}">新規契約</button>
                <button class="bg-blue-500 text-white rounded px-3 py-2" type="submit" formaction="../ShowVisitHistory/{{$targetUser->serial_user}}">施術記録</button> 
                <button class="bg-blue-500 text-white rounded px-3 py-2" type="submit" formaction="../ShowContractHistory/{{$targetUser->serial_user}}">契約履歴</button>
                --}}

            
        </div>
    </div>
@endsection