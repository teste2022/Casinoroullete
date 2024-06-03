@extends('layouts.app')
@section('content')
<div class="affiliates">
	<div class="t-alert">Enter code <font color="#ffcc01"><b>SENTINEL</b></font> to get your free <b>100 coins</b> fast!</div>
	<div class="top">
		<div class="top-box">
			<div class="box">
				<label for="get-coins">Use a code to get free 100 coins</label>
				<div class="group-input">
					@if (empty(Auth::user()->inviter))
					<input type="text" id="get-coins" placeholder="Enter Your Code...">
					@else
					<input type="text" id="get-coins" placeholder="Already used" disabled> @endif <button id="get-coins-button">USE</button>
				</div>
			</div>
			<div class="box">
				<label for="set-code">Get your own code by pressing the <font color="#ffcc01"><b>"SET CODE"</b></font> button</label>
				<div class="group-input">
					<input type="text" id="set-code" placeholder="Enter a code..." value="{{Auth::user()->code}}"> <button id="set-code-button">SET CODE</button>
				</div>
			</div>
			<div class="box">
				<label>Put <a class="lime">CSGOSentinel.com</a> in your name for 30 coins daily!</label>
				<div class="group-input">
					@if(Auth::user()->last_free_use + 86400 < time())
						<button data-api="free-coins" class="free-coins full-size lime">Check Your Nickname</button>
					@else
						<button data-api="free-coins" class="free-coins full-size reload-time" data-timeleft="{{(Auth::user()->last_free_use + 86400) - time()}}">You have to wait</button>
					@endif
				</div>
			</div>
			<div class="box">
				<label>Join our <a href="https://steamcommunity.com/groups/csgosentinelofficial" target="_blank" style="color: #ffcc01;">Steam Group</a> and set it to your primary group for 30 coins!</label>
				<div class="group-input">
					@if (Auth::user()->group_used == '0')
						<button data-api="group-join" class="free-coins group-join full-size lime">Check Steam Group</button>
					@else
						<button class="full-size" style="opacity:0.4;">Already Used</button>
					@endif
				</div>
			</div>
		</div>
		<div class="top-box">
			<div class="box2">
				<div class="label">People you have referred:</div>
				<div class="value">{{$reffered}}</div>
			</div>
			<div class="box2">
				<div class="label">Referral profit:</div>
				<div class="value">@if($profit < 0) <span style="font-size: 20;">Press <font color="#ffcc01"><b>&nbsp;"GET"&nbsp;</b></font> to see your profit!</span> @else {{$profit}} @endif </div>
			</div>
			<button id="withdraw-refs-button">Withdraw</button>
		</div>
	</div>
	<div class="levels">
		<div class="label"></div>
		<div class="medals">
			<div class="medal medal-bronze">
				<div class="medal-label">Bronze</div>
				<div class="medal-background"></div>
				<div class="medal-image"></div>
				<div class="medal-line"></div>
				<div class="medal-progress">0 - 50</div>
				<div class="medal-tip" data-tip="Get 5 coins for every person referred." data-ltip="Bronze"></div>
			</div>
			<div class="medal medal-silver">
				<div class="medal-label">Silver</div>
				<div class="medal-background"></div>
				<div class="medal-image"></div>
				<div class="medal-line"></div>
				<div class="medal-progress">51 - 250</div>
				<div class="medal-tip" data-tip="Get 6 coins for every person referred." data-ltip="Silver"></div>
			</div>
			<div class="medal medal-gold">
				<div class="medal-label">Gold</div>
				<div class="medal-background"></div>
				<div class="medal-image"></div>
				<div class="medal-line"></div>
				<div class="medal-progress">251 - 1500</div>
				<div class="medal-tip" data-tip="Get 7 coins for every person referred.<br>Get an ultra special name color on our chat." data-ltip="Gold"></div>
			</div>
			<div class="medal medal-diamond">
				<div class="medal-label">Diamond</div>
				<div class="medal-background"></div>
				<div class="medal-image"></div>
				<div class="medal-line"></div>
				<div class="medal-progress">1500+</div>
				<div class="medal-tip" data-tip="Get 10 coins for every person referred.<br>Get an ultra special name color on our chat." data-ltip="Diamond"></div>
			</div>
		</div>
	</div>
</div>
   @endsection
		
@section('scripts')
<script type="text/javascript" src="/js/affiliates.js"></script>
@endsection