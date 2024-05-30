$(function() {
	"use strict";
	window.dice = ({

		states: ['before-roll', 'rolling', 'after-roll'],

		chance: 47.5,
		multiplier: 2,
		speed: 1000,

		_settings: {
			minBet: 10,
			maxBet: 100000,
			resultTimeout: 750,
			rotationTime: 750
		},

		$betAmount: $('#bet-amount'),
		$multiplier: $('#multiplier'),
		$winChance: $('#win-chance'),
		$slider: $('.range-value'),
		$profit: $('.dice .profit .value'),
		$rollValue: $('.roll-value'),
		$betButton: $('#bet-button'),
		$rolled: $('#bet-button').find('.rolled'),
		$rolledtext: $('#bet-button').find('.rolling-text'),
		$type: $('#bet-button').find('.type'),
		$gameHistoryArea: $('.game-history-area'),
		$myBets: $('.game-history.my-bets'),
		$allBets: $('.game-history.all-bets'),
		$highRollers: $('.game-history.high-rollers'),
		$hashValue: $('.hash-value'),
		$previousRound: $('.previous-round'),
		$lightingButton: $('.game-type .button[data-value="lighting"]'),
		$automaticButton: $('.game-type .button[data-value="automatic"]'),
		$typeSelection: $('.type-selection'),

		waiting: true,
		result: null,

		calculateProfit: function() {
			this.profit = (this.betAmount * this.multiplier / 100) - this.betAmount;
		},

		calculateWinChance: function() {
			var winChance = (100 / (this.multiplier / 100)) * (1 - 0.04);
			if (parseInt(winChance * 100, 10) === parseInt(this.winChance, 10)) return;
			this.winChance = winChance * 100;
		},

		calculateMultiplier: function() {
			var multiplier = (100 / (this.winChance / 100)) * (1 - 0.04);
			if (parseInt(multiplier * 100, 10) === parseInt(this.multiplier * 100, 10)) return;
			this.multiplier = multiplier * 100;
		},

		changeState: function(newState) {
			if (!dice.states.includes(newState)) return;

			dice.states.forEach(function(state) {
				if (state === newState) {
					dice.$betButton.addClass('state-' + state);
				} else {
					dice.$betButton.removeClass('state-' + state);
				}
			});

			clearTimeout(dice.stateSwitchTimeout);

			if (newState === 'after-roll') {
				dice.stateSwitchTimeout = setTimeout(dice.changeState, 10000, 'before-roll');
			}
		},
		generateGameHTML: function(game) {
			var html = '';
			html += '<tr>';
			html += '  <td class="player"><img src="' + game.user.avatar + '"> ' + game.user.username + '</td>';
			html += '  <td>' + parseFloat(game.multiplier).toFixed(2) + '</td>';
			html += '  <td>' + game.value + '</td>';
			html += '  <td>' + (game.type === 1 ? 'Above' : 'Under') + ' ' + parseFloat(game.limit / 100).toFixed(2) + '</td>';
			html += '  <td>' + parseFloat(game.roll / 100).toFixed(2) + '</td>';
			html += '  <td class="' + (game.profit < 0 ? 'lose' : 'win') + '">' + parseInt(game.profit, 10) + '</td>';
			html += '</tr>';

			return html;
		},

		addGameHTMLTo: function(gameHTML, target) {
			switch (target) {
				case 'my':
					$(gameHTML).hide().prependTo(this.$myBets).fadeIn(500);
					if (this.$myBets.children().length > 20) this.$myBets.children().last().remove();
					break;
				case 'all':
					$(gameHTML).hide().prependTo(this.$allBets).fadeIn(500);
					if (this.$allBets.children().length > 20) this.$allBets.children().last().remove();
					break;
				case 'high':
					$(gameHTML).hide().prependTo(this.$highRollers).fadeIn(500);
					if (this.$highRollers.children().length > 20) this.$highRollers.children().last().remove();
					break;
			}
		},

		addGame: function(game) {
			var gameHTML = this.generateGameHTML(game);
			this.addGameHTMLTo(gameHTML, 'all');
			if (game.user.id === steamid) this.addGameHTMLTo(gameHTML, 'my');
			if (game.value >= 10000) this.addGameHTMLTo(gameHTML, 'high');
		},
		roll_col: function(col, anim, num){
			$('#numbers-'+col).attr('class','numbers');
			$('#numbers-'+col).addClass('roll-'+anim+'-'+num);
		},
		reset_col: function reset_col(col, num){
			$('#numbers-'+col).attr('class','numbers');
			$('#numbers-'+col).addClass('reset-'+num);
		},
		loadResult: function(retry) {
			clearTimeout(dice.resultTimeout);

			retry = retry || 0;
			var result = dice.result;
			if (!result) {
				if (retry < 10) dice.resultTimeout = setTimeout(dice.loadResult, dice._settings.rotationTime, ++retry);
				else dice.changeState('before-roll');
				return;
			}

			dice.changeState('after-roll');

			var num = String(result.game.roll);
			if(num.length == 1) num = '000'+num;
			if(num.length == 2) num = '00'+num;
			if(num.length == 3) num = '0'+num;
			var nums = num.split('');
			if(!dice.lighting){
				dice.$rolledtext.text("Rolling");
				dice.$rolled.text("");
				dice.roll_col(1, 'SLOW', nums[0]);
				setTimeout(function(){dice.roll_col(2, 'FAST3', nums[1]);},400);
				setTimeout(function(){dice.roll_col(3, 'FAST2', nums[2]);},450);
				setTimeout(function(){dice.roll_col(4, 'FAST1', nums[3]);},500);
				setTimeout(function(){
					setTimeout(function(){
						dice.reset_col(3, nums[2]);
						setTimeout(function(){
							dice.reset_col(2, nums[1]);
							setTimeout(function(){
								dice.reset_col(1, nums[0]);
								dice.$previousRound.removeClass('empty');
								dice.$previousRound.find('.previous-hash-value').text(result.game.hash);
								dice.$previousRound.find('.previous-secret-value').text(result.game.secret);
								dice.$previousRound.find('.previous-roll-value').text(result.game.roll);
								dice.waiting = false;
								dice.$hashValue.text(result.hash);
								dice.addGame(result.game);
								bal(parseInt(result.game.profit + result.game.value));
							},3100);
						},750);
					},750);
					dice.reset_col(4, nums[3]);
				},5400);
			}
			else{
				dice.$previousRound.removeClass('empty');
				dice.$previousRound.find('.previous-hash-value').text(result.game.hash);
				dice.$previousRound.find('.previous-secret-value').text(result.game.secret);
				dice.$previousRound.find('.previous-roll-value').text(result.game.roll);
				dice.waiting = false;
				dice.$rolled.text(parseFloat(result.game.roll / 100).toFixed(2));
				dice.$rolledtext.text("Rolled ");
				dice.$hashValue.text(result.hash);
				dice.addGame(result.game);
				bal(parseInt(result.game.profit + result.game.value));
			}

			dice.result = null;
		},
		onHistory: function(history) {
			if(history && history.length){
				history.forEach(function(game) {
					var gameHTML = dice.generateGameHTML(game);
					dice.addGameHTMLTo(gameHTML, 'all');
					if (game.value >= 10000) dice.addGameHTMLTo(gameHTML, 'high');
					if (game.user.id === steamid) dice.addGameHTMLTo(gameHTML, 'my');
				});
			}
			
		},

		onHash: function(data) {
			this.waiting = false;
			this.$hashValue.text(data.hash);
		},

		onResult: function(result) {
			this.result = result;
		},

		onEvent: function(event) {
			switch(event.type) {
				case 'game':
					if (event.game.user.id !== steamid) this.addGame(event.game);
					break;
			}
		},

		bindButtons: function() {
			var dice = this;
			this.$betButton.on('click', function() {
				if (dice.waiting) return notify('message', 'pleaseWait');
				dice.changeState('rolling', dice);

				if (dice.type === 'under') {
					socket.emit('dice-bet', { value: dice.betAmount, limit: dice.winChance, type: 0 });
				} else {
					socket.emit('dice-bet', { value: dice.betAmount, limit: 10000 - dice.winChance, type: 1 });
				}

				dice.waiting = true;
				dice.resultTimeout = setTimeout(dice.loadResult, dice.lighting ? dice._settings.rotationTime : dice._settings.resultTimeout, 0);
			});

			this.$lightingButton.on('click', function() {
				dice.lighting = !dice.lighting;
				$("#dice-odometer").toggle(!dice.lighting);
			});


			this.$typeSelection.on('click', 'span', function(){
				dice.type = $(this).data('type');
			});


			this.$automaticButton.on('click', function() { notify('warning', 'currentlyDisabled'); });


			$('.history-select').on('click', function() {
				var type = $(this).data('type');
				if (!['my-bets', 'all-bets', 'high-rollers'].includes(type)) return;
				$('.history-select').removeClass('active');
				$('.history-select[data-type="' + type + '"]').addClass('active');
				dice.$gameHistoryArea.removeClass('my-bets all-bets high-rollers').addClass(type);
			});


			$('.controls-amount .button').on('click', function() {
				var value = dice.betAmount;
				var balance = parseInt($('.balance').data('balance'), 10);
				switch($(this).data('action')) {
					case '1/2':
						value /= 2;
						break;
					case 'x2':
						value *= 2;
						break;
					case 'min':
						value = 10;
						break;
					case 'max':
						value = dice._settings.maxBet;
						break;
				}

				value = parseInt(value, 10);
				if (value > balance) value = balance;
				if (value < 0 || isNaN(value)) value = dice._settings.minBet;
				dice.betAmount = value;
			});
		},
		init: function() {
			var dice = this;
			this.calculateProfit();
			this.calculateWinChance();
			this.$slider.on('change input', function() { dice.winChance = parseInt(dice.type === 'under' ? dice.$slider.val() * 100 : 10000 - dice.$slider.val() * 100, 10); });
			this.$winChance.on('change', function() { dice.winChance = parseInt(dice.$winChance.val() * 100, 10); });
			this.$betAmount.on('change input', function() { dice.betAmount = dice.$betAmount.val(); });
			this.$multiplier.on('change', function() { dice.multiplier = parseInt(dice.$multiplier.val() * 100, 10); });



		   // channels.this = socket.subscribe('game:this', { waitForAuth: true });
		   // channels.this.watch(this.onEvent);
			dice.bindButtons();

		}

	});
	Object.defineProperty(dice, 'lighting', {
		get: function() { return dice.$lightingButton.hasClass('active'); },
		set: function(value) {
			if (value) {
				dice.$lightingButton.addClass('active');
			} else {
				dice.$lightingButton.removeClass('active');
			}
		}
	}),

	Object.defineProperty(dice, 'type', {
		get: function() { return dice.$typeSelection.data('active-type'); },
		set: function(value) {
			if (!['under', 'above'].includes(value)) return;
			if (value === dice.type) return;
			dice.$typeSelection.data('active-type', value);
			dice.$type.text(value);
			dice.$typeSelection.find('span').removeClass('active');
			dice.$typeSelection.find('[data-type="' + value + '"]').addClass('active');
			dice.winChance = 10000 - dice.winChance;
		}
	});

	Object.defineProperty(dice, 'betAmount', {
		get: function() { return parseInt(dice.$betAmount.val(), 10); },
		set: function(value) {
			dice.$betAmount.val(value);
			dice.calculateProfit();
		}
	});

	Object.defineProperty(dice, 'multiplier', {
		get: function() { return parseFloat(dice.$multiplier.data('value')); },
		set: function(value) {
			dice.$multiplier.val(parseFloat(value / 100).toFixed(2)).data('value', value);
			dice.calculateProfit();
			dice.calculateWinChance();
		}
	});

	Object.defineProperty(dice, 'profit', {
		get: function() { return parseInt(dice.$profit.text(), 10); },
		set: function(value) { dice.$profit.text(parseInt(value, 10)); }
	});

	Object.defineProperty(dice, 'winChance', {
		get: function() { return parseFloat(dice.$winChance.data('value')); },
		set: function(value) {
			dice.$winChance.val(parseFloat(value / 100).toFixed(2)).data('value', value);
			dice.$slider.val(dice.type === 'under' ? value / 100 : 100 - value / 100);
			dice.$rollValue.text(parseFloat(dice.type === 'under' ? value / 100 : 100 - value / 100).toFixed(2));
			dice.calculateMultiplier();
		}
	});

	dice.init();

	socket.on('dice-hash', function(data) {
		dice.onHash(data);
	});
	socket.on('dice-result', function(result) {
		dice.onResult(result);
	});
	socket.on('dice-history', function(history) {
		dice.onHistory(history);
	});

	socket.on('dice-game', function(event) {
		if (event.game.user.id !== steamid) dice.addGame(event.game);
	});

});
