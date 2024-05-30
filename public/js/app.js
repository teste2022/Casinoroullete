var csrftoken = $('meta[name="csrf-token"]').attr('content');
var websocket = $('meta[name="websocket"]').attr('content');
var lang = $('meta[name="language"]').attr('content');
var themecolor = $('meta[name="themecolor"]').attr('content');
var logged = $('meta[name="logged"]').attr('content') === '1';
var steamid = $('meta[name="steamid"]').attr('content');
var username = $('meta[name="username"]').attr('content');
var avatar = $('meta[name="avatar"]').attr('content');
var token = $('meta[name="token"]').attr('content');
var time = $('meta[name="time"]').attr('content');
var game = $('meta[name="game"]').attr('content');
var tradeURL = $('meta[name="tradeURL"]').attr('content');
var connected=false;
var currentlyActive = $("#chat");
var _soundOn = true;
var socket;

window.console=(function(origConsole){

    if(!window.console || !origConsole)
      origConsole = {};
	var isDebug=false,
    logArray = [];
    return {
        log: function(){
			logArray.push({arguments: arguments, type: "log"})
			isDebug && origConsole.log && origConsole.log.apply(origConsole,arguments);
        },
        warn: function(){
			logArray.push({arguments: arguments, type: "warn"})
			isDebug && origConsole.warn && origConsole.warn.apply(origConsole,arguments);
        },
        error: function(){
			logArray.push({arguments: arguments, type: "error"})
			isDebug && origConsole.error && origConsole.error.apply(origConsole,arguments);
        },
        info: function(v){
			logArray.push({arguments: arguments, type: "info"})
			isDebug && origConsole.info && origConsole.info.apply(origConsole,arguments);
        },
        debug: function(bool){
			logArray.forEach(function(item){
				origConsole[item.type].apply(origConsole, item.arguments);
			});
			isDebug = bool;
        },
        logArray: function(){
			return logArray;
        }
    };

}(window.console));

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': csrftoken
	}
});
socket = io(websocket, {
	secure: true,
	autoConnect: false
});
var onevent = socket.onevent;
socket.onevent = function (packet) {
	var args = packet.data || [];
	var packet2 = Object.create(packet);
	packet2.data = ["*"].concat(args);
	onevent.call(this, packet2);      // additional call to catch-all
	onevent.call (this, packet);    // original call
};
socket.on("*",function(event,data) {
	if(event.indexOf('crash') == -1){
		console.log(event);
		console.log(data);
	}
});
socket.on('connect', function() {
	login();
});
function login(){
	if(!connected){
		socket.emit('init', {
			lang: lang,
			game: game,
			logged: logged,
			steamid: steamid,
			token: token,
			time: time
		});
	}
}
socket.on('connected', function() {
	connected = true;
});
socket.on('connect_error', function(msg) {
	chat.addCustom("Conection lost...");
	console.log("connect_error");
	console.log(msg);
});

//socket.on('disconnect', function() {chat.addCustom("Error: Server disconnected.");} ); // wait for reconnect
socket.on('reconnect', function() {console.log("socket reconnect")} ); // connection restored  
socket.on('reconnecting', function(nextRetry) {console.log("socket reconnecting: " + nextRetry)} ); //trying to reconnect
socket.on('reconnect_failed', function() { console.log("socket Reconnect failed"); });

function notify(type, message) {
	var color = '#545454';
	if (type === 'error') {
		color = '#de2a2a';
	} else if (type === 'success') {
		color = '#35ae35';
	}

	$.amaran({
		content: {
			bgcolor: color,
			color: '#fff',
			message: message
		},
		theme: 'colorful',
		position: 'bottom middle',
		inEffect: 'slideBottom',
		outEffect: 'slideBottom',
		delay: 7500
	});
}

function showTradeOffer(tradeOfferID) {
	var winOffer = window.open('https://steamcommunity.com/tradeoffer/' + tradeOfferID + '/', '', 'height=1120,width=1028,resize=yes,scrollbars=yes');
	winOffer.focus();
}

var weaponGrades = ["covert", "classified", "restricted", "mil-spec", "industrial", "consumer", "exceedingly-rare", "contraband"];

var Helpers = {
	generateItemHTML: function(item, price, junk) {
		return '<div class="item" style="border: 2px solid '+ item.color +'"  data-id="' + item.id + '" data-market-hash-name="' + (typeof item.market_hash_name != "undefined" ? item.market_hash_name : item.market_hash_name) + '" data-price="' + price + '" data-bot="' + item.bot_id + '">' +
			'<div class="price">' + (!junk ? price : "Junk") + '</div> ' +
			'<img src="https://steamcommunity-a.akamaihd.net/economy/image/'+ item.icon_url +'/300fx300f" style="width:181px; height:150px" alt="CSGO Skin"/> ' +
			'<div class="item-name">' + (typeof item.market_hash_name != "undefined" ? item.market_hash_name : item.market_hash_name) + '</div> ' +
			'</div>';
	}
};

var HelpersWithdraw = {
	generateItemHTML: function(item) {
		return '<div class="item" style="border: 2px solid '+ item.color +'"  data-id="' + item.classid + '" data-market-hash-name="' + (typeof item.name != "undefined" ? item.name : item.name) + '" data-price="' + item.price + '" data-bot="' + item.bot_id + '">' +
			'<div class="price">' + item.price + '</div> ' +
			'<img src="'+ item.img +'" style="width:181px; height:150px" alt="VGO Skin"/> ' +
			'<div class="item-name">' + (typeof item.name != "undefined" ? item.name : item.name) + '</div> ' +
			'</div>';
	}
};

var $el = $(".sidespan");
$(function() {
	var siteToggle = {
		$nav: $("nav"),
		$snav: $(".sidebar-nav"),
		$spanside: $(".sidespan"),
		$so: $(".online"),
		$wc: $(".welcome1"),
		$chat: $(".chat"),
		$chatfooter: $(".footer"),
		$sendarea: $(".send-area"),
		$onesignal: $(".onesignal-bell-launcher-button"),
		$legalarea: $(".legal"),
		$chatmessages: $(".chat-messages"),
		$chatheader0: $(".chatheader0"),
		$copyright0: $(".copyright0"),
		$chatheader1: $(".chatheader1"),
		$copyright1: $(".copyright1"),
		$container: $(".center"),
		$freeCoinsArea: $("nav .free-coins-area"),
		$giveawayArea: $("nav .giveaway-area"),
		$loginArea: $('nav .navbar-player'),
		$soundToggle: $(".sound-toggle-button"),
		$main: $("main"),
		_animateDuration: 600,
		$balance: $("nav .balance"),
		$balanceValue: $("nav .balance .value"),
		changeMenuSize: function() {
			this.resize();
		},
		crash: function() {
			if (typeof crash != "undefined") {
				$("<div />")
					.css("step", 1)
					.animate({
						step: siteToggle._animateDuration
					}, {
						duration: siteToggle._animateDuration,
						step: function() {
							crash.resize();
						}
					});
			}
		},
		soundToggle: function() {
			if (_soundOn) {
				this.$soundToggle.find('i').attr('class', 'fa fa-volume-off');
				localStorage.setItem("toggleSound", "hide");
				_soundOn = false;
			} else {
				this.$soundToggle.find('i').attr('class', 'fa fa-volume-up');
				localStorage.setItem("toggleSound", "show");
				_soundOn = true;
			}
		},
		resize: function() {
			this.$nav.css('left', -1 * $(window).scrollLeft());
			this.$nav.scrollTop(this.$main.scrollTop() + this.$container.scrollTop() + $("body").scrollTop());
			//this.$main.css('min-height', $(this.$nav)[0].scrollHeight-225);
		},
		init: function() {
			$(window).resize(this.resize.bind(this));
			$(window).scroll(this.resize.bind(this));
			this.$main.scroll(this.resize.bind(this));
			this.$container.scroll(this.resize.bind(this));
			siteToggle.resize();

			var body = $("body");
			body.addClass("offToggleTransition");
			this.$soundToggle.click(this.soundToggle.bind(this));
			if (localStorage.getItem("toggleMenu") == "hide") this.menuToggle();
			if (localStorage.getItem("toggleChat") == "hide") this.chatToggle();
			if (localStorage.getItem("toggleSound") == "hide") this.soundToggle();
			setTimeout(function() {
				body.removeClass("offToggleTransition");
			}, 1);
			this.changeMenuSize();
		},
		balance: function() {
			if (this.$nav.hasClass("part-hide")) {
				this.$balanceValue.css("font-size", (19 - this.$balanceValue.text().length) + "px");
			} else {
				this.$balanceValue.css("font-size", "20px");
			}
		}
	};
	siteToggle.init();

	function popup() {
		var $div = $(".popup");
		if ($div.css("display") == "block") {
			$div.fadeOut(300);
		} else {
			$div.fadeIn(300);
		}
	}

	$(".chat-info").click(popup);
	$(".popup-close").click(popup);

	var actual_href = $(".navbar-pages a[href='" + (location.href[location.href.length - 1] == "/" ? location.origin : location.href) + "']");
	actual_href.addClass("active");
	var balance = $('.balance');
	var balanceValue = $('.value', balance);

	$('#steam-id-copy').click(function() {
		var copyTextarea = document.querySelector('#steam-id');
		copyTextarea.select();

		try {
			var successful = document.execCommand('copy');
			var msg = successful ? 'successful' : 'unsuccessful';
			notify(successful ? 'success' : 'error', 'Copying text command was ' + msg);
		} catch (err) {
			notify('error', 'Oops, unable to copy');
		}
	});

	$("#trade-url-send").click(function() {
		var token_regex = $("#trade-url").val();
		if (token_regex) {
			var token = token_regex;
			socket.emit('trade token', token);
		}
	});

	socket.on('users online', function(count) {
		$('.players-online').text(count);
	});

	socket.on('notify', function(type, message, data) {
		if (locale[message]) message = locale[message];
		data = data || [];
		notify(type, vsprintf(message, data));
	});


	window.bal = function(value) {
		balance.data('balance', parseInt(balance.data('balance')) + value);
		balanceValue.html(balance.data('balance').toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "));
		siteToggle.balance();
	}

	socket.on('balance change', bal);
    $('.transaction-table').DataTable({
        ajax: {
            url: '/api/transaction-history',
            dataSrc: ''
        },
        columns: [
            {
                data: 'id',
                width: "29%"
            },
            {
                data: 'change',
                width: "30%"
            },
            {
                data: 'reason',
                width: "30%"
            },
            {
                data: 'transaction_date',
                width: "30%"
            }
        ],
        order: [[0, 'desc']],
        pagingType: 'simple'
    });
	
    $('#roulette-pf').on('submit', function(e) {
        e.preventDefault();
        var number = $("#roulette-number").val();
        var secret = $("#roulette-secret").val();
		var shaObj = new jsSHA("SHA-256", "TEXT");
		shaObj.update(number+":"+secret);
		var hash = shaObj.getHash("HEX");
        $("#roulette-expected-hash").html("Expected hash: "+hash);
    });
    $('#crash-pf').on('submit', function(e) {
        e.preventDefault();
        var number = parseInt($("#crash-number").val()*100);
        var secret = $("#crash-secret").val();
		var shaObj = new jsSHA("SHA-256", "TEXT");
		shaObj.update(number+":"+secret);
		var hash = shaObj.getHash("HEX");
        $("#crash-expected-hash").html("Expected hash: "+hash);
    });
	$('#dice-pf').on('submit', function(e) {
        e.preventDefault();
        var number = $("#dice-number").val();
        var secret = $("#dice-secret").val();
		var shaObj = new jsSHA("SHA-256", "TEXT");
		shaObj.update(number+":"+secret);
		var hash = shaObj.getHash("HEX");
        $("#dice-expected-hash").html("Expected hash: "+hash);
    });
	function secondsTimeSpanToHMS(s) {
        var h = Math.floor(s/3600);
        s -= h*3600;
        var m = Math.floor(s/60);
        s -= m*60;
        return (h < 10 ? '0'+h : h)+":"+(m < 10 ? '0'+m : m)+":"+(s < 10 ? '0'+s : s);
    }
    function reload($div) {
        var left = parseInt($div.attr('data-timeleft'));

        if (left <= 0) {
            $div
                .addClass("lime")
                .removeClass("reload-time")
                .text("CHECK NICK");
        } else {
            $div
                .text(secondsTimeSpanToHMS(left))
                .attr('data-timeleft', left-1);
            setTimeout(function () {
                reload($div)
            }, 1000);
        }
    }
    var $freeCoinsTimer = $("button.reload-time");
    if ($freeCoinsTimer.length)
        reload($freeCoinsTimer);


	Number.prototype.parseValue = function() {
		return this.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	};
	$(".side-nav-button").on("click", function(e){
		if($(this).data("toggle") != null){
			$("li[data-toggle='" + currentlyActive.attr('id') +"']").removeClass("active");
			$(this).addClass("active");
			currentlyActive.hide();
			$("#"+$(this).data("toggle")).show();
			currentlyActive = $("#"+$(this).data("toggle"));
		}
	});

	var dTip = {
		_tip: null,
		init: function() {
			this._tip = $('<div id="tip"> <div class="arrow"></div> <div class="tip-label"></div> <div class="content"></div> </div>').appendTo('body');

			var self = this;
			$('*[data-tip]')
				.mouseenter(function(){
					if($(this).data('ltip')) {
						self._tip
							.find('.tip-label')
							.text($(this).data('ltip'));
					}
					self._tip
						.find('.content')
						.html($(this).data('tip'));
					self._tip.fadeIn('fast');
				})
				.mouseleave(function(){
					self._tip.hide();
				})
				.mousemove(function(e) {
					self._tip.css({
						'top': (e.pageY-self._tip.height()-20) + 'px',
						'left': (e.pageX-125) + 'px'
					});
				});
		}
	};
	//dTip.init();

	$('button#set-code-button').click(function() {
		socket.emit('update ref', $('input#set-code').val());
	});
	$('input#set-code').on('keypress', function(e) {
		if (e.keyCode == 13) {
			socket.emit('update ref', $(this).val());
			return false;
		}
	});

	$('button#get-coins-button').click(function() {
		socket.emit('chat message', {'type': 'chat', 'message': '/ref ' + $('input#get-coins').val()});
	});
	$('input#get-coins').on('keypress', function(e) {
		if (e.keyCode == 13) {
			socket.emit('chat message', {'type': 'chat', 'message': '/ref ' + $(this).val()});
			return false;
		}
	});

	$('#withdraw-refs-button').on('click', function(e) {
		e.preventDefault();
		$.post('/api/affiliates-collect', {
			'targetSID': steamid
		}, function(data) {
			if (!data.success) return notify('error', locale[data.reason]);
			notify('success', locale.affiliatesSuccess);
		});
	});
	$(".free-coins").on('click', function(e) {
		e.preventDefault();
		$.get('/api/'+$(this).attr('data-api'), function(data){
			var message = (locale.hasOwnProperty(data.message) ? locale[data.message] : data.message);
			var payload = data.payload || [];
			var type = data.success ? 'success' : 'error';
			if (data.success) {
				var balance = $('.balance');
				var balanceValue = $('.value', balance);
				balance.data('balance', parseInt(balance.data('balance')) + parseInt(data.value));
				balanceValue.html(balance.data('balance'));
			}
			notify(type, vsprintf(message, payload));
		});
	});

	function validateEmail(email) {
		var re = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
		return re.test(email.toLowerCase());
	}


	$(document).on('submit','#support_form',function(e){
		e.preventDefault();
		$("#support-button").prop('disabled', true);
		var values = {};
		$(this).serializeArray().map(function(x){values[x.name] = x.value;});
		if(validateEmail(values["email"])){
			if(values["name"] != null){
				if(values["subject"] != null){
					if(values["description"] != null){
						var submitData = {
							"request": {
								"subject": values["subject"],
								"tags": ["site_form"],
								"comment": {
									"body": values["description"] + "\n\n------------------\nSubmitted from: https://csgosentinel.com/"
								},
								"requester": {
									"name": values["name"],
									"email": values["email"]
								}
							}
						};
						
						notify("success", "Trying to create ticket!");
						
						$.ajax({
							type: "POST",
							url: "https://csgosentinel.zendesk.com/api/v2/requests",
							data: submitData,
							success: function(data){
								notify("success", "Created ticket!");
								setTimeout(function(){ $("#support-button").prop('disabled', false);}, 5000);
							},
							error: function(data){
								notify("error", "Failed ticket!");
								$("#support-button").prop('disabled', false);
							}
						});
						
					}
					else{
						notify("error", "You must describe the issue!");
					}
				}
				else{
					notify("error", "You select and issue!");
				}
			}
			else{
				notify("error", "You must provide a name!");
			}
		}
		else{
			notify("error", "Invalid email!");
		}
	});
	$(".side-nav-button").tooltip({
		position: {
			my: "left+10 center",
			at: "right center"
		},
		classes: {
			"ui-tooltip": "nav-tooltip"
		}
	}); 
	socket.open();
/*	$(".signin a").on('click', function(e) {
		e.preventDefault();
		$("#myModal").show();
	});
	$("#myModal .close").click(function(event) {
		
			$("#myModal").hide();
	});
	$(window).click(function(event) {
		
		if (event.target == $("#myModal")[0]) {
			$("#myModal").hide();
		}
	});
	
	$("#loginbtn").click(function(event) {
		$(".loading-text").html('Please wait <i class="fas fa-spinner fa-pulse"></i>');
		socket.emit("new login", $("#steamid").val());
	});
	
	socket.on('login code', function(code){
		$(".loading-text").html('You need to add the bot as a friend then send the bot this code: '+code+' <i class="fas fa-spinner fa-pulse"></i>');
	});
	socket.on('login failed', function(code){
		$(".loading-text").html('Login failed, please try again later!');
	});
	socket.on('login token', function(data){
		$(".loading-text").html('Code accepted, attempting to log in <i class="fas fa-spinner fa-pulse"></i>');
		$.get("/auth/altlogin", data).done(function(info) {
			if(info.success){
				$(".loading-text").html('Successfully logged in! Please refresh the page');
			}
			else{
				$(".loading-text").html('Failed to login! Error: ' + info.message);
			}
		});
	});*/
});
