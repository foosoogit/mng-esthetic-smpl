<div>
    <section>
        <div class="containor">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card" align="center">
                        <div class="row justify-content-center">
                            <div class="col-auto"><button class="btn btn-primary active" type="button" onclick="location.href='/menuStaff'">メニューに戻る</button></div>
                            @if($GoBackPlace<>"")
                                <div class="col-auto"><button class="btn btn-primary active" type="button" onclick="location.href='{{ $GoBackPlace }}'">{{ $GoBackPlaceName }}</button></div>
                            @endif
                        </div>
                                {{--<div class="col-auto"><button class="btn btn-primary active" type="button" onclick="location.href='{{$GoBackPlace}}'">戻る</button></div>--}}
                            <div class="font-semibold text-2xl text-slate-600">[契約リスト]</div>
                            {{--
                            <div class="col-auto">
                                <form method="GET" action="/customers/ShowInputCustomer">@csrf
                                    <button class="btn btn-primary" type="submit" name="CustomerListCreateBtn" value="CustomerList">新規顧客登録</button>
                                </form>	
                            </div>
                            --}}
                        </div>
                        <div class="row justify-content-center align-middle">
                            <div class="col-auto">{!!$htm_branch_rdo!!}</div>
                            <div class="col-auto"><button type="button" wire:click="searchClear() onclick="document.getElementById('kensakukey_txt').value=''">解除</button></div> 
                            <div class="col-auto"><input type="text" name="kensakukey_txt" id="kensakukey_txt" class="form-control col-md-5" wire:model.defer="kensakukey"></div>
                            <div class="col-auto"><button type="button" name="SerchBtn" id="SerchBtn" wire:click="search()">検索</button></div>
                        </div>
                        @unless($UserSerial==="all")
                        <div class="row">
						顧客番号：　{{$UserSerial}}　　契約者：{{$userinf->name_sei}}  &nbsp; {{$userinf->name_mei}}
                        <div class="col-auto"><form method="GET" action="/customers/ShowInpContract/{{$UserSerial}}">
                            @csrf
                            <p style="text-indent:20px" class="py-1.5">
                            <button class="btn btn-primary active" type="submit">新規契約登録</button>
                            </p>
                        </form></div>
                    </div>
					@endunless
                        <div class="card-body">
                            <table class="table-auto" border-solid>
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">契約番号<br>(修正)</th>
                                        <th class="border px-4 py-2">最終来店日<br>(支払い・施術来店記録入力)</th>
                                        {{--  @if($UserSerial=="all")--}}
                                            <th class="border px-4 py-2">顧客番号<br>（新規契約作成)</th>
                                            <th class="border px-4 py-2">氏名</th>
                                        {{--@endif--}}
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
                                    @foreach ($contractQuery as $dContracts)
                                        <tr>
                                        <td class="border px-4 py-2"><form action="/customers/ShowSyuseiContract/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf<input name="contract_syusei_Btn" type="submit" value="{{$dContracts->serial_keiyaku}}"></form></td>
                                        <td class="border px-4 py-2"><form action="/customers/ShowInpRecordVisitPayment/{{$dContracts->serial_keiyaku}}/{{$dContracts->serial_user}}" method="GET">@csrf
                                            @if($dContracts->date_latest_visit==Null)
                                                <input name="Record_Btn" type="submit" value="なし">
                                            @else
                                                <input name="Record_Btn" type="submit" value="{{$dContracts->date_latest_visit}}">
                                            @endif
                                        </form></td>
                                        {{--@if($UserSerial=="all")--}}
                                            <td class="border px-4 py-2"><form action="/customers/ShowInpContract/{{$dContracts->serial_user}}" method="GET">@csrf<input name="syusei_Btn" type="submit" value="{{ $dContracts->serial_user}}"></form></td>
                                            <td class="border px-4 py-2">{{$dContracts->name_sei}} &nbsp; {{$dContracts->name_mei}}</td>
                                        {{--@endif--}}
                                            <td class="border px-4 py-2">{{ $dContracts->keiyaku_bi}}</td>
                                            <td class="border px-4 py-2">{{ $dContracts->keiyaku_kikan_start}}-{{ $dContracts->keiyaku_kikan_end}}</td>
                                            <td class="border px-4 py-2" style="text-align: right;">{{ $dContracts->keiyaku_kingaku}}</td>
                                            <td class="border px-4 py-2" style="text-align: right;">{{ $dContracts->Keiyaku_Zankin}}</td>
                                            <td class="border px-4 py-2">{{ $dContracts->how_to_pay}}</td>
                                            @if($dContracts->how_to_pay=="Credit Card")
                                                <td class="border px-4 py-2">{{ $dContracts->how_many_pay_card}}</td>
                                            @elseif($dContracts->how_to_pay=="現金")
                                                <td class="border px-4 py-2">{{ $dContracts->how_many_pay_genkin}}</td>
                                            @else
                                                <td class="border px-4 py-2">ERROR</td>
                                            @endif
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
                            {{$contractQuery->appends(request()->query())->links('pagination::bootstrap-4')}}
                            {{--{{$users->appends(request()->query())->links('pagination::bootstrap-4')}}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>