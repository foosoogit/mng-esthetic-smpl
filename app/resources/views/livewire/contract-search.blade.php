
<div>
@extends('layouts.staff')
@section('content')
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div><button type="button" wire:click="ct">change</button></div>
    <div><button type="button" wire:keydown="ct" class="btn btn-primary">change2</button></div>
{{$title}}
@endsection
</div>

