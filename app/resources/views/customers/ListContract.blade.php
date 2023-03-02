<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
	<script src="{{  asset('/js/CreateContracts.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Styles -->
    <style>
        input[type=radio] {
            display: none; /* ラジオボタンを非表示にする */
        }
        input[type="radio"]:checked + label {
            background: #31A9EE;/* マウス選択時の背景色を指定する */
            color: #ffffff; /* マウス選択時のフォント色を指定する */
        }
        .label:hover {
            background-color: #E2EDF9; /* マウスオーバー時の背景色を指定する */
        }
        .label {
            display: block; /* ブロックレベル要素化する */
            float: left; /* 要素の左寄せ・回り込を指定する */
            margin: 5px; /* ボックス外側の余白を指定する */
            width: 120px; /* ボックスの横幅を指定する */
            height: 35px; /* ボックスの高さを指定する */
            /*padding-top: -50px;*/
            padding-left: 5px; /* ボックス内左側の余白を指定する */
            padding-right: 5px; /* ボックス内御右側の余白を指定する */
            color: #b20000; /* フォントの色を指定 */
            text-align: center; /* テキストのセンタリングを指定する */
            line-height: 45px; /* 行の高さを指定する */
            cursor: pointer; /* マウスカーソルの形（リンクカーソル）を指定する */
            border: 2px solid #006DD9;/* ボックスの境界線を実線で指定する */
            border-radius: 5px; /* 角丸を指定する */
            /*font-size: larger;*/
            vertical-align:middle;
        }
    </style>
    @livewireStyles
</head>
<body>
<div class="container">
	<p><livewire:contract-search></p>
					{{--
					<form method="GET" action="/customers/ShowInpContract/{{$UserSerial}}">
						@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="btn btn-primary active" type="submit" disabled="disabled">物品販売</button>
						</p>
					</form>	
					
					
					<form method="GET" action="/customers/ShowInpContract/{{$UserSerial}}">
						@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="btn btn-primary active" type="submit">新規契約登録</button>
						</p>
					</form>	
					--}}
					{{--
					<form method="GET" action="/customers/ShowCustomersList">
						@csrf
						<p style="text-indent:20px" class="py-1.5">
						<button class="btn btn-primary active" type="submit" disabled="disabled">解除</button>
						<input type="text" name="kensakuKey" value="{{ old('name') }}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" >
						<button class="btn btn-primary active" type="submit" disabled="disabled">検索</button>
						</p>
					</form>	
					--}}
			
					{{--
					@unless($UserSerial==="all")
						顧客番号：　{{$UserSerial}}    契約者：{{optional($userinf)->name_sei}}  &nbsp; {{optional($userinf)->name_mei}}
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
				--}}
			

			{{--{{$Contracts->appends(request()->query())->links('pagination::bootstrap-4')}}--}}
</div>
@livewireScripts
</body>
</html>