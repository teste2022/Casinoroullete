@extends('layouts.app')
@section('content')
                <div class="my-profile">
        <div class="user-info">
            <img class="avatar" src="{{Auth::user()->avatar}}">
            <div class="nick">Welcome, <span>{{Auth::user()->username}}</span></div>
        </div>
        <div class="box">
            <label for="trade-url">Trade Link (<a target="_blank" href="https://trade.opskins.com/settings"> Find it HERE </a>)</label>
            <div class="group-input">
                <input type="text" id="trade-url" placeholder="Enter Your trade URL" value="@if (Auth::check() && Auth::user()->tradeurl){{Auth::user()->tradeurl}}@endif"> <button id="trade-url-send">UPDATE</button>
            </div>
        </div>
        <div class="box">
            <label for="steam-id">Your Steam Id</label>
            <div class="group-input">
                <input type="text" id="steam-id" readonly value="{{Auth::user()->steamid}}"> <button id="steam-id-copy">COPY</button>
            </div>
        </div>
        <div class="stats">
            <div class="stats-won">
                <div class="label">won</div>
                <div class="value">{{Auth::user()->total_won}}</div>
            </div>
            <div class="stats-lost">
                <div class="label">lost</div>
                <div class="value">{{Auth::user()->total_lose}}</div>
            </div>
            <div class="stats-profit">
                <div class="label">profit</div>
                <div class="value">{{(Auth::user()->total_won)-(Auth::user()->total_lose)}}</div>
            </div>
        </div>
        <div class="table">
            <table class="transaction-table display" style="width: 100%">
                <thead>
                <tr><th>ID</th><th>Change</th><th>Reason</th><th>Date</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
   @endsection
		
@section('scripts')
    <script type="text/javascript" src="/js/profile.js"></script>
@endsection