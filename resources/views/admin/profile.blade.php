@extends('layouts.app')
@section('content')
                <div class="my-profile">
        <div class="user-info">
            <img class="avatar" src="{{$user->avatar}}">
            <div class="nick">{{$user->username}}</div>
        </div>
        <div class="box">
            <div class="group-input">
                <input type="text" id="trade-url" placeholder="User hasn't entered trade url" value="@if ($user->tradeurl){{'https://steamcommunity.com/tradeoffer/new/?partner='.(substr($user->steamid,7) - 7960265728).'&token='.$user->tradeurl}}@endif" readonly>
            </div>
        </div>
        <div class="box">
            <label for="steam-id">{{$user->username}}'s Steam Id</label>
            <div class="group-input">
                <input type="text" id="steam-id" readonly value="{{$user->steamid}}"> <button id="steam-id-copy">COPY</button>
            </div>
        </div>
        <div class="box">
            <label for="steam-id">{{$user->username}}'s Steam Id</label>
            <div class="group-input">
				<button id="mute-user">{{ $user->muted == 0 ? "Mute" : "Unmute" }}</button>
				<button id="ban-user">{{ $user->banned == 0 ? "Ban" : "Unban" }}</button>
				<button id="withdraw-ban-user">{{ $user->banned == 0 ? "Withdraw Ban" : "Allow Withdraw" }}</button>
				<button id="transfer-ban-user">{{ $user->banned == 0 ? "Transfer Ban" : "Allow Transfer" }}</button>
				<button id="deposit-ban-user">{{ $user->banned == 0 ? "Deposit Ban" : "Allow Deposit" }}</button>
            </div>
        </div>
        <div class="stats">
            <div class="stats-won">
                <div class="label">won</div>
                <div class="value">{{$user->total_won}}</div>
            </div>
            <div class="stats-lost">
                <div class="label">lost</div>
                <div class="value">{{$user->total_lose}}</div>
            </div>
            <div class="stats-profit">
                <div class="label">profit</div>
                <div class="value">{{($user->total_won)-($user->total_lose)}}</div>
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
	<script>var profile_steamid = "{{$user->steamid}}";</script>
    <script type="text/javascript" src="/js/adminprofile.js"></script>
@endsection