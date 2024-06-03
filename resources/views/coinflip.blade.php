@extends('layouts.app')
@section('content')
	<div class="coinflip roulette">
        <div class="controls">
            <div class="color-select">
                <button class="btn-multi active" data-value="t">
                    <img class="red-select-button" src="/img/misc/coin-t.png">
                </button>
                <button class="btn-multi" data-value="ct">
                    <img class="black-select-button" src="/img/misc/coin-ct.png">
                </button>
            </div>
            <div class="inputs-area">
                <div class="amount">
                    <label for="minesBet">Enter the amount: </label>
                    <input id="minesBet" class="value" placeholder="Your amount..." />
                </div>
                <div class="buttons">
                    <div class="button" data-action="clear">Clear</div>
                    <div class="button" data-action="last">Last</div>
                    <div class="button" data-action="100+"><span>+</span>100</div>
                    <div class="button" data-action="1000+"><span>+</span>1K</div>
                    <div class="button" data-action="10000+"><span>+</span>10K</div>
                    <div class="button" data-action="1/2">1<span>/</span>2</div>
                    <div class="button" data-action="x2"><span>X</span>2</div>
                    <div class="button" data-action="max">Max</div>
                </div>
            </div>
            <div class="play">
                <button class="btn-play">GO!</button>
            </div>
        </div>
        <div class="balance-latest">
            <div style="display: -ms-flexbox;display: flex;-ms-flex-align: center;align-items: center;-ms-flex-pack: distribute;justify-content: space-around;overflow: hidden;-ms-flex-wrap: wrap;flex-wrap: wrap; margin: 0 auto;position: relative;"><p style="font-size: 22px;">Active Lobbies</p></div>
        </div>
        <div class="roulette-wheel-outer player-bets"></div>

    </div>
   @endsection
		
@section('scripts')
    <script src="/js/progress.min.js"></script>
    <script src="/js/coinflip.js"></script>
@endsection