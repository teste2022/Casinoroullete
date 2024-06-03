<html lang="en">
	<head>
		<meta charset="UTF-8">

		<title>playwinnergame</title>
		<meta property="og:title" content="playwinnergame" />
		<meta property="og:type" content="Gambling Website" />
		<meta property="og:url" content="/" />
		<meta name="description" content="Play with Your Friends and Win Skins!">
		<meta name="keywords" content="counter,strike,csgo,sentinel,csgo sentinel,sentinel.com,sentinelcsgo,roulette,skins,referral,earn,points,bet,win,shop,buy,sell,gun,knife,knives,best,most,platform,marketplace,high,roller,stake,social,gambling,gamble,affiliate">

		<meta name="csrf-token" content="{{ Session::token() }}" />
		<meta name="language" content="en" />
		<meta name="websocket" content=":8443" />
		
		<meta name="logged" content="@if (Auth::check()){{1}}@else{{0}}@endif" />
		<meta name="id" content="@if (Auth::check()){{Auth::user()->id}}@endif" />
		<meta name="username" content="@if (Auth::check()){{Auth::user()->username}}@endif"/>
		<meta name="avatar" content="@if (Auth::check()){{Auth::user()->avatar}}@endif"/>
		<meta name="token" content="@if (Auth::check()){{Auth::user()->token}}@endif"/>
		<meta name="tradeURL" content="@if (Auth::check() && Auth::user()->tradeurl){{Auth::user()->tradeurl}}@endif"/>
		<meta name="time" content="@if (Auth::check()){{Auth::user()->token_time}}@endif"/>

		<meta name="viewport" content="width=1400, initial-scale=1">
		<meta name="google-site-verification" content="1X4JxaLG_AM6F9u410Q6K4XL9HuqJjntjN3k8dmJ53E" />

		<link rel="icon" type="image/ico" href="/favicon.ico" />
<link href="https://use.fontawesome.com/releases/v5.0.2/css/all.css" rel="stylesheet">

		<script src="/js/jquery-1.8.3.js"></script>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
		<link rel="stylesheet" href="/css/jquery-ui.css">
		<link rel="stylesheet" href="/css/animate.css">
		<!--<link rel="stylesheet" href="/css/app.css"> -->
		<link rel="stylesheet" href="/css/main.css">
		<!-- NOTIF -->
		<link rel="manifest" href="/manifest.json">
		<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
		<script>
			var OneSignal = window.OneSignal || [];
			OneSignal.push(["init", {
				appId: "cc3fa379-a217-4676-8b1d-b0eb55a8e61f",
				safari_web_id: 'web.onesignal.auto.5f83a190-684a-4c4c-a875-2ee8aa7bf929',
				autoRegister: true,
				persistNotification: true,
				notifyButton: {
					enable: true /* Set to false to hide */,
					size: "medium",
					position: 'bottom-left', 
					offset: {
						bottom: '5px',
						left: '5px'
					},
					colors: { // Customize the colors of the main button and dialog popup button
						'circle.background': '#e7e308',
						'circle.foreground': 'white',
					},
					prenotify: true,
					showCredit: false
			  }
			}]);
		</script>
	</head>
	<body>
			<div class="page-content">
				<div class="top-navigation">
					<img src="/img/official.png" class="navbar-img">
					<div class="nav-top">
						<ul class="nav-top-list">

								<a href="/">
									<i class="iconcustom icon-roulette" aria-hidden="true"></i>
									Roulette
								</a>
							</li>
							
								<a href="/crash">
									<i class="fa fa-chart-line" aria-hidden="true"></i>
									Crash
								</a>
							</li>
					
								<a href="/dice">
									<i class="iconcustom icon-dice" aria-hidden="true"></i>
									Dice
								</a>
							</li>
						
								<a href="/user/deposit">
									Depósito
								</a>
							</li>
							
								<a href="/user/withdraw">
									Saque
								</a>
							</li>
						</ul>
					</div>
					@if (Auth::check())
					<!-- <div class="circle-button sound-toggle-button"><i class="fa fa-volume-up" aria-hidden="true"></i></div> -->
					<div class="account">
						<div class="avatar">
							<div class="balance" data-balance="{{Auth::user()->wallet}}">
								<i class="far fa-money-bill-alt" aria-hidden="true"></i>
								<span class="value">{{Auth::user()->wallet}}</span>
							</div>
							<div class="user-navbar">
								<div class="accountname">{{Auth::user()->username}}</div>
							</div>
							<img src="{{Auth::user()->avatar}}">
						</div>
						<a href="/auth/logout" class="sign-out-button"><i class="fa fa-power-off" aria-hidden="true"></i></a>
					</div>
					@else
					<div class="signin">
						<a href="/login">
							<img src="testando imagem">
						</a>
					</div>
					@endif
				</div>
				<div class="main-content">
					<nav class="navbar">
						<div id="sidebar-wrapper">
							<ul id="sidebar-nav sidebarshow" class="sidebar-nav sidebarshow">
								@if (Auth::check())
								<li class="side-nav-button active" data-toggle="chat" title="Chat">
									<a>
										<div class="icon icon-other">
											<i class="fa fa-comments" aria-hidden="true"></i>
										</div>
									</a>
								</li>
								<li class="side-nav-button" data-toggle="profile" title="Profile">
									<a>
										<div class="icon icon-other">
											<i class="fa fa-user" aria-hidden="true"></i>
										</div>
									</a>
								</li>
								<li class="side-nav-button" data-toggle="affiliates" title="Affiliates">
									<a>
										<div class="icon icon-other">
											<i class="far fa-chart-bar" aria-hidden="true"></i>
										</div>
									</a>
								</li>
								@endif
								<li class="side-nav-button" data-toggle="pf" title="Provably Fair">
									<a>
										<div class="icon icon-other">
											<i class="fa fa-balance-scale" aria-hidden="true"></i>
										</div>
									</a>
								</li>
								<li class="side-nav-button" data-toggle="faq" title="FAQ">
									<a>
										<div class="icon icon-other">
											<i class="far fa-question-circle" aria-hidden="true"></i>
										</div>
									</a>
								</li>
								<li class="side-nav-button" data-toggle="support" title="Support">
									<a>
										<div class="icon icon-other">
											<i class="fa fa-envelope" aria-hidden="true"></i>
										</div>
									</a>
								</li>
								<li class="side-nav-button" title="Twitter">
									<a target="_blank" href="#">
										<div class="icon icon-other">
											<i class="fab fa-twitter" aria-hidden="true"></i>
										</div>
									</a>
								</li>
								<li class="side-nav-button" title="Discord">
									<a target="_blank" href="#">
										<div class="icon icon-other">
											<i class="fab fa-discord" aria-hidden="true"></i>
										</div>
									</a>
								</li>
								<li class="side-nav-button" title="Steam">
									<a target="_blank" href="https://steamcommunity.com/groups/vgopunk/">
										<div class="icon icon-other">
											<i class="fab fa-steam" aria-hidden="true"></i>
										</div>
									</a>
								</li>

							</ul>


						</div>
					</nav>
					<div class="sidebar-content">
						<div class="chat" id="chat">
							<!--<div class="chat-top">
								<div class="online"><i class="fa fa-users online-users-icon" aria-hidden="true"></i><span class="online-text">Online Users:</span><span class="players-online"></span></div>
					
							</div>-->
							<div class="chat-messages">
							</div>
							@if (Auth::check())
							<div class="send-area">
								<div class="input-area">
									<input type="text" class="chat-input" placeholder="Your message..." pattern="[A-Za-z0-9_./!?,$+-= ]{1,75}" required>
									<div class="emots-button">
										<img src="/img/misc/emots-button.png">
									</div>
									<div class="emots"></div>
								</div>
							</div>
							@endif
						</div>
						@if (Auth::check())
						<div class="my-profile" id="profile" style="display: none;">
							<div class="user-info">
								<img class="avatar" src="{{Auth::user()->avatar}}">
								<div class="nick">Welcome, <span>{{Auth::user()->username}}</span></div>
							</div>
							<div class="box">
								<label for="trade-url">Trade Link<a target="_blank" href="https://trade.opskins.com/settings"> Find it Here </a></label>
								<div class="group-input">
									<input type="text" id="trade-url" placeholder="Enter Your trade URL" value="@if (Auth::check() && Auth::user()->tradeurl){{Auth::user()->tradeurl}}@endif"> <button id="trade-url-send"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
								</div>
							</div>
							<div class="box">
								<label for="id">Your</label>
								<div class="group-input">
									<input type="text" id="id" readonly value="{{Auth::user()->id}}"> <button id="id-copy"><i class="fa fa-clone" aria-hidden="true"></i></button>
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
						<div class="affiliates" id="affiliates" style="display: none;">
							<!--<div class="t-alert">Enter code <font color="#ffcc01"><b>SENTINEL</b></font> to get your free <b>100 coins</b> fast!</div>-->
							<div class="top">
								<div class="top-box">
									<div class="box">
										<label class="title">How it works</label>
										<p>
											Share your personal code and refer users!
											Earn a minimum of 1000 to cash in on your
											affiliates; gamble them? or withraw a skin!
										</p>
									</div>
								</div>
								<div class="top-box">
									<div class="box">
										<label class="title">Free Coins</label>
										<label for="get-coins">Use a code to get free 100 coins</label>
										<div class="group-input">
											@if (empty(Auth::user()->inviter))
											<input type="text" id="get-coins" placeholder="Enter Your Code...">
											@else
											<input type="text" id="get-coins" placeholder="Already used" disabled> @endif <button id="get-coins-button">✔</button>
										</div>
									</div>
									<div class="box">
										<label>Put <a class="lime">VGOPunk.com</a> in your name for 30 coins daily!</label>
										<div class="group-input">
											@if(Auth::user()->last_free_use + 86400 < time())
												<button data-api="free-coins" class="free-coins full-size lime">Check Your Nickname</button>
											@else
												<button data-api="free-coins" class="free-coins full-size reload-time" data-timeleft="{{(Auth::user()->last_free_use + 86400) - time()}}">You have to wait</button>
											@endif
										</div>
									</div>
									<div class="box">
										<label>Join our <a href="http" target="_blank">Steam Group</a> and set it to your primary group for 30 coins!</label>
										<div class="group-input">
											@if (Auth::user()->group_used == '0')
												<button data-api="group-join" class="free-coins group-join full-size lime">Check Steam Group</button>
											@else
												<button class="full-size" style="opacity:0.4;">Already Used</button>
											@endif
										</div>
									</div>
									<div class="box">
										<label class="title">Refferals</label>
										<label for="set-code">Create Code</label>
										<div class="group-input">
											<input type="text" id="set-code" placeholder="Enter a code..." value="{{Auth::user()->code}}"> <button id="set-code-button">✔</button>
										</div>
									</div>
								</div>
								<div class="top-box">
									<div class="box2">
										<div class="label">Total Reffered</div>
										<div class="value">{{$reffered}}</div>
									</div>
									<div class="box2 profit">
										<div class="label">Total Earned</div>
										<div class="value">@if($profit < 0) <span style="font-size: 20;">Press <font color="#ffcc01"><b>&nbsp;"GET"&nbsp;</b></font> to see your profit!</span> @else {{$profit}} @endif </div>
									</div>
									<button id="withdraw-refs-button">Withdraw</button>
								</div>
							</div>
							<div class="levels">
								<div class="medals">
									<div class="medal medal-bronze">
										<div class="medal-label">Bronze</div>
										<div class="medal-background"></div>
										<div class="medal-image"></div>
										<div class="medal-progress">0 - 50</div>
										<div class="medal-tip" data-tip="Get 5 coins for every person referred." data-ltip="Bronze"></div>
									</div>
									<div class="medal medal-silver">
										<div class="medal-label">Silver</div>
										<div class="medal-background"></div>
										<div class="medal-image"></div>
										<div class="medal-progress">51 - 250</div>
										<div class="medal-tip" data-tip="Get 6 coins for every person referred." data-ltip="Silver"></div>
									</div>
									<div class="medal medal-gold">
										<div class="medal-label">Gold</div>
										<div class="medal-background"></div>
										<div class="medal-image"></div>
										<div class="medal-progress">251 - 1500</div>
										<div class="medal-tip" data-tip="Get 7 coins for every person referred.<br>Get an ultra special name color on our chat." data-ltip="Gold"></div>
									</div>
									<div class="medal medal-diamond">
										<div class="medal-label">Diamond</div>
										<div class="medal-background"></div>
										<div class="medal-image"></div>
										<div class="medal-progress">1500+</div>
										<div class="medal-tip" data-tip="Get 10 coins for every person referred.<br>Get an ultra special name color on our chat." data-ltip="Diamond"></div>
									</div>
								</div>
							</div>
						</div>
						@endif
						<div class="faq" id="faq" style="display: none;">
							<div class="rules">
								<div class="header">
									Frequently Asked Questions
								</div>
								<div>
									<p><strong>Who we are?</strong></p>
									<p>We are one of the most advanced gambling websites to ever exist, and with the low comission rates we will soon be the best website out there.</p>
									<p>Our staff aren't just people that work here, we're a family. Owned by some of the most respected and reputable traders in the community, you can be sure that you're safe with us.</p>
									<p>You can place bets with those coins on the Roulette game and withdraw them back to skins at any time you want!</p>
									<p>Remember that these coins have no real world value.</p>
								</div>
								<div>
									<p><strong>How can I get coins?</strong></p>
									<p>You can deposit Counter-Strike: Global Offensive skins.</p>
									<p>A skin worth $1 on the Steam Marketplace should give you around 1000 coins.</p>
									<p>Another option is our affiliate system.</p>
								</div>
								<div>
									<p><strong>How do I deposit skins for coins?</strong></p>
									<p>To deposit, head over to your profile page. Make sure your trade link is properly set.</p>
									<p> Once you’ve done that, go to the Deposit page, select up to 20 items and then hit the deposit button.</p>
									<p>Coins from deposits appear on your account immediately although in rare circumstances it can take up to 30 minutes (if steam breaks the offer that is).</p>
								</div>
								<div>
									<p><strong>Why are some of my items missing from the deposit page?</strong></p>
									<p>You might need to refresh your inventory by clicking the “Refresh Inventory” button on the top right of the Deposit page.</p>
									<p>Remember that our minimum depositing value it’s $0.50 - Also some of the items with prices hard to determine are not accepted on the site. </p>
									<p> Please make sure you are using the Steam mobile authenticator for at least 7 days.</p>
								</div>
								<div>
									<p><strong>How do I withdraw my coins to skins?</strong></p>
									<p>Go to the Withdraw page, select up to 20 items and then hit the Withdraw button. </p>
									<p>If you happen to decline a trade offer, coins will be credited back to your account within 5 minutes.</p>
								</div>
								<div>
									<p><strong>Why can’t I withdraw?</strong></p>
									<p>If you want withdraw items, you must have deposited atleast $2.50
									Also, your 'Wager Amount' needs to be more than or equal to three quaters the amount your trying to withdraw, read more about the wager amount in the FAQ under 'What is Wager Amount?'.</p>
								</div>
								<div>
									<p><strong>Why is my withdraw delayed?</strong></p>
									<p>Following recent events, CSGOSentinel now uses a manual withdraw system to ensure the safety and integrity of our systems. Manual withdraws will take no longer than 5 minutes maximum to process and at the event of an unexpected delay with withdraw processing you can contact our support system or DM our twitter to check on the status of your withdraw.</p>
								</div>
								<div>
									<p><strong>What is Wager Amount?</strong></p>
									<p>This is how much you have wagered or in other words bet on our various games. This amount mirrors to the amount you are allowed to withdraw from our store.
									This has been added in our new system to ensure that our store does not get mistaken for a trade bot to trade.</p>
								</div>
								<div>
									<p><strong>How do I send coins to another player?</strong></p>
									<p>There are two ways to send coins, either right click someones name, select send then enter the ammount of coins you wish to send. </p>
									<p>Or you can use the chat command, /send &lt;steamid&gt; &lt;ammount&gt;. e.g. /send 76561198071550434 1000</p>
								</div>
							</div>
						</div>
						<div id="pf" class="pf" style="display: none;">
							<b>Please Note</b>
							<p>Provably fair is designed to ensure that the results are fair and cannot be changed. The way it tends to work, and works on Imperium, is by generating a salt and using this with the value used to determin the result. The generated hash is then sent to the client before any amount of money has been played.</p>
							<br>
							<b>Roulette</b>
							<p>This works by using the sha256 hash function on the winning number and the secret.<br>The hash is displayed before the game rolles and the secret is displayed after.<br>The code for this is `sha256(winningNumber + ":" + secret);`<br>You can try it below or do it manually.</p>
							<form id="roulette-pf">
								Number: <input type="text" id="roulette-number" class="pf-textbox" placeholder="Number..."><br>
								Secret: <input type="text" id="roulette-secret" class="pf-textbox" placeholder="Secret..."><br>
								<input type="submit" value="Submit">
							</form>
							<p id="roulette-expected-hash">Expected hash:</p>
							<b>Crash</b>
							<p>This works by using the sha256 hash function on the crashed at number and the secret.<br>The hash is displayed before the crash and the secret is displayed after.<br>The code for this is `sha256(crashat * 100 + ":" + secret);`<br>You can try it below or do it manually.</p>
							<form id="crash-pf">
								Roll: <input type="text" id="crash-number" class="pf-textbox" placeholder="Number..."><br>
								Secret: <input type="text" id="crash-secret" class="pf-textbox" placeholder="Secret..."><br>
								<input type="submit" value="Submit">
							</form>
							<p id="crash-expected-hash">Expected hash:</p>

							<b>Dice</b>
							<p>This works by using the sha256 hash function on the rolled number and the secret.<br>The hash is displayed before you roll and the secret is displayed after.<br>The code for this is `sha256(roll + ":" + secret);`<br>You can try it below or do it manually.</p>
							<form id="dice-pf">
								Roll: <input type="text" id="dice-number" class="pf-textbox" placeholder="Number..."><br>
								Secret: <input type="text" id="dice-secret" class="pf-textbox" placeholder="Secret..."><br>
								<input type="submit" id="support-button" value="Submit">
							</form>
							<p id="dice-expected-hash">Expected hash:</p>
						</div>
						<div class="support" id="support" style="display: none;">
							<p><strong>Support</strong></p>
							<form id="support_form">
								<label for="fname">Name</label>
								<input type="text" id="name" name="name" placeholder="Your name..">

								<label for="lname">Email</label>
								<input type="email" id="email" name="email" placeholder="Your email..">

								<label for="subject">Feature you are currently facing an issue with</label>
								<select id="subject" name="subject">
									<option value="roulette">Roulette</option>
									<option value="crash">Crash</option>
									<option value="dice">Dice</option>
									<option value="profile">Profile</option>
									<option value="refferals">Refferals</option>
									<option value="deposit">Deposit</option>
									<option value="store">Store</option>
									<option value="pf">Provably Fair</option>
									<option value="FAQ">FAQ</option>
									<option value="giveaway">Giveaway</option>
									<option value="sponsorship">Sponsorship</option>	
									<option value="other">Other</option>	
								</select>
								
								<label for="lname">Please describe the issue</label>
								<textarea id="description" name="description"></textarea>

								<button>Submit</button>
							</form>
						</div>
					</div>

					<div class="center">
						<div class="alert success">
							<strong>playwinnergame</strong>
						</div>
						<div class="main-wrapper">
							<main>
							  @yield('content')
							</main>
						</div>
					</div>
						
				</div>
			</div>
			
			<div id="myModal" class="modal">

			  
			  <div class="modal-content">
				<div class="modal-header">
				  <span class="close">&times;</span>
				  <h2>Login</h2>
				</div>
				<div class="modal-body">
					<p><b>Please add the bot first before trying to log in.</b> This system works by entering your steam64 id, you then add the bot, you will be asked to message a unique code to the bot, this will verify who you are and allow you to login. <a href="https://steamcommunity.com/id/TheGuardianCSGO">Bot Profile</a></p>
					<label>Please enter your steamid64: </label>
					<input type="text" id="steamid" placeholder="Enter your SteamID...">
					<button id="loginbtn">Login!</button>
					<div class="loading-text"></div>
				</div>
			  </div>

			</div>

			<script type="text/javascript" src="/js/js/socket.io.js"></script>
			<script type="text/javascript" src="/js/js/sha.js"></script>
			<script type="text/javascript" src="/js/app.js"></script>
			<script type="text/javascript" src="/js/js/jquery-3.2.1.min.js"></script>
			<script type="text/javascript" src="/js/js/jquery-ui.min.js"></script>
			<script type="text/javascript" src="/js/js/jquery.bez.min.js"></script>
			<script type="text/javascript" src="/js/js/jquery.flot.min.js"></script>
			<!-- <script type="text/javascript" src="/js/js/jquery.timeago.js"></script> -->
			<!-- <script type="text/javascript" src="/js/js/bootbox.min.js"></script> -->
			<script type="text/javascript" src="/js/js/buzz.min.js"></script>
			<script type="text/javascript" src="/js/js/contextmenu.js"></script>
			<script type="text/javascript" src="/js/js/datatables.min.js"></script>
			<!-- <script type="text/javascript" src="/js/js/jcanvas.min.js"></script> -->
			<!-- <script type="text/javascript" src="/js/js/odometer.min.js"></script> -->
			<!-- <script type="text/javascript" src="/js/js/sha.js"></script> -->
			<script type="text/javascript" src="/js/js/sprintf.min.js"></script>
			<script type="text/javascript" src="/js/js/jquery.amaran.min.js"></script>
			<script src="/js/lang/en.js"></script>
			<script src="/js/chat.js"></script>
			@if((Auth::check()) && (Auth::user()->rank == 'siteAdmin'))<script src="/js/adminchat.js"></script>
			@elseif((Auth::check()) && (Auth::user()->rank == 'siteMod'))<script src="/js/modchat.js"></script>
			@elseif((Auth::check()) && (Auth::user()->rank == 'root'))<script src="/js/rootchat.js"></script>
			@else<script src="/js/userchat.js"></script>
			@endif
			<script src="/js/HackTimerWorker.min.js"></script>
			<script src="/js/HackTimer.silent.min.js"></script>
			@yield('scripts')
	</body>
</html>
