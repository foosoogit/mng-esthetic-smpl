<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <section>
        <div class="containor">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card" align="center">
                        <div class="row justify-content-center">
                            <div class="col-auto"><button class="btn btn-primary active" type="button" onclick="location.href='/menuStaff'">メニューに戻る</button></div>
                            <div class="col-auto">
                                <form method="GET" action="/workers/ShowBranchRegistration/new">@csrf
                                    <button class="btn btn-primary" type="submit" name="ShowBranchRegistrationBtn">新規支店登録</button>
                                </form>	
                            </div>
                        </div>
                        <div class="card-header">
                            <h3>支店一覧</h3>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto"><button type="button" wire:click="searchClear() onclick="document.getElementById('kensakukey_txt').value=''">解除</button></div>
                            <div class="col-auto"><input type="text" name="kensakukey_txt" id="kensakukey_txt" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" wire:model.defer="kensakukey"></div>
                            <div class="col-auto"><button type="button" name="SerchBtn" id="SerchBtn" wire:click="search()">検索</button></div>
                        </div>
                        <div class="card-body">
                        <table class="table-auto" border-solid>
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">支店データ修正<br>
                                        <button type="button" wire:click="sort('serial_user-ASC')"><img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('serial_user-Desc')"><img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
                                    <th class="border px-4 py-2">支店名
                                        <button type="button" wire:click="sort('name_sei-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('name_sei-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button></th>
                                    <th class="border px-4 py-2">住所
                                        <button type="button" wire:click="sort('name_sei_kana-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('name_sei_kana-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </th>
                                    <th class="border px-4 py-2">電話番号
                                        <button type="button" wire:click="sort('phone-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('phone-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </th>
                                    <th class="border px-4 py-2">メール
                                        <button type="button" wire:click="sort('mail-ASC')"> <img src="{{ asset('storage/images/sort_A_Z.png') }}" width="15px" /></button>
                                        <button type="button" wire:click="sort('maile-Desc')"> <img src="{{ asset('storage/images/sort_Z_A.png') }}" width="15px" /></button>
                                    </th>
                                    <th class="border px-4 py-2">削除</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Branches as $branch)
                                    <tr>
                                        <td class="border px-4 py-2">
                                            <form action="/workers/ShowBranchRegistration/{{ $branch->serial_branch}}" method="POST">@csrf<input name="syusei_Btn" type="submit" value="{{ $branch->serial_branch}}"></form>
                                        </td>
                                        <td class="border px-4 py-2">{{ $branch->name_branch}}</td>
                                        <td class="border px-4 py-2">〒{{ $branch->postal}}&nbsp;{{ $branch->address_branch}}</td>
                                        <td class="border px-4 py-2">{{ $branch->phone_branch}}</td>
                                        <td class="border px-4 py-2">{{ $branch->email}}</td>
                                        <td class="border px-4 py-2">
                                        <form action="/customers/deleteBranch/{{$branch->serial_branch}}" method="GET">
                                            @csrf
                                            <input name="delete_btn" type="submit" value="削除" onclick="return delArert('{{ $branch->serial_branch}} {{ $branch->BranchName}}');" disabled>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$Branches->appends(request()->query())->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
