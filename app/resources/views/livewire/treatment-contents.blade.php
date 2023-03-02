<div>
    <section>
        <div class="containor">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card" align="center">
                        <div class="row justify-content-center">
                            <div class="col-auto"><button class="btn btn-primary active" type="button" onclick="location.href='../ShowMenuCustomerManagement'">メニューに戻る</button></div>
                            <div class="col-auto"><button class="btn btn-primary active" type="button" onclick="history.back(-1);return false">戻る</button></div>
                        </div>
                    {{--<button class="btn btn-primary active" type="button" onclick="location.href='/customers/ShowSyuseiContract/{{session('ContractSerial')}}/{{session('UserSerial')}}'">戻る</button>--}}
                    <div class="font-semibold text-2xl text-slate-600">[施術登録]</div>
                        <form method="GET" action="/workers/ShowSyuseiTreatmentContent/new">@csrf
                            <p style="text-indent:20px" class="py-1.5">
                            <button class="btn btn-primary active" type="submit" name="GoodCreateBtn" value="CustomerList">施術新規登録</button>
                            </p>
                        </form>	
                        <div class="card-header">
                            <h3>商品一覧</h3>
                        </div>
                        {{--
                        <button type="button" name="SerchBtn" id="SerchBtn" wire:click="search()">検索</button>
                        <input type="text" name="kensakukey_txt" id="kensakukey_txt" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model.defer="kensakukey">
                        <button type="button" wire:click="searchClear() onclick="document.getElementById('kensakukey_txt').value=''">解除</button> 
                        --}}
                        <div class="card-body">
                        <table class="table-auto" border-solid>
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">施術番号(修正)
                                        {{--								
                                        <button type="button" wire:click="sort('serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                    </th>
                                    <th class="border px-4 py-2">施術名
                                        {{--
                                        <button type="button" wire:click="sort('name_sei-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('name_sei-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                    </th>
                                    <th class="border px-4 py-2">施術名 かな
                                        {{--
                                        <button type="button" wire:click="sort('name_sei-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('name_sei-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                    </th>
    
                                    <th class="border px-4 py-2">施術内容
                                        {{--
                                            <button type="button" wire:click="sort('name_sei-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                            <button type="button" wire:click="sort('name_sei-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                        </th>
                                    <th class="border px-4 py-2">メモ
                                        {{--									
                                        <button type="button" wire:click="sort(User_Zankin-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('User_Zankin-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                        --}}
                                    </th>
                                    <th class="border px-4 py-2">削除
                                        {{--									
                                        <button type="button" wire:click="sort(User_Zankin-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('User_Zankin-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
    
                                        --}}
                                    </th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach ($treatment_contents as $treatment_content)
                                <tr>
                                    <td class="border px-4 py-2"><form action="/workers/ShowSyuseiTreatmentContent/{{ $treatment_content->serial_treatment_contents}}" method="GET">@csrf<input name="syusei_Btn" type="submit" value="{{ $treatment_content->serial_treatment_contents}}"></form>
    </td>
                                    <td class="border px-4 py-2">{{ $treatment_content->name_treatment_contents}}</td>
                                    <td class="border px-4 py-2">{{ $treatment_content->name_treatment_contents_kana}}</td>
                                    <td class="border px-4 py-2" style="text-align: left;">{{ $treatment_content->treatment_details }}</td>
                                    <td class="border px-4 py-2" style="text-align: left;">{{ $treatment_content->memo}}</td>
                                    <td class="border px-4 py-2" style="text-align: left;">
                                    <form action="/workers/deleteTreatmentContent/{{$treatment_content->serial_treatment_contents}}" method="GET">@csrf
                                        <input name="delete_btn" type="submit" value="削除" onclick="return delArert('施術番号：{{$treatment_content->serial_treatment_contents}} 施術名:{{$treatment_content->name_treatment_contents}}');">
                                    </form></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$treatment_contents->appends(request()->query())->links('pagination::bootstrap-4')}}
                    {{--{{ $treatment_contents->links() }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{  asset('/js/Common.js') }}" defer></script>
</div>