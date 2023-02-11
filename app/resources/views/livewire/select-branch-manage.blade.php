<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    {!!$htm_branch_cbox!!}
    {{ $T }}
    {{--<input type="hidden" name="target_branch">--}}
    <br>
    <form method="GET" action="/customers/UserList">@csrf
        <button class="btn btn-primary" type="submit" >顧客一覧</button>&nbsp;修正・新規登録・契約
    </form><br>
    <form method="POST" action="/customers/UserList">@csrf
        <span class="danraku" style="line-height: 200%;">
        [支払い不履行者]
        <p><span style="color:red;">{!!$default_customers!!}</span></p>
    </form>
        [最終支払いから一ヶ月以上支払いしていない顧客（現金契約者のみ・契約支払い未完了）]
        <form method="GET">@csrf{!!$not_coming_customers!!}</form>
    </span>
</div>
