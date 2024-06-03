@extends('layouts.app')
@section('content')
    <div class="roulette jackpot">
        <div class="controls">
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
            <div class="lol123" style="display: -ms-flexbox;display: flex;-ms-flex-align: center;align-items: center;-ms-flex-pack: distribute;justify-content: space-around;overflow: hidden;-ms-flex-wrap: wrap;flex-wrap: wrap; margin: 0 auto;position: relative;">
			<div style="display: -ms-flexbox;display: flex;-ms-flex-align: center;align-items: center;-ms-flex-pack: distribute;justify-content: space-around;overflow: hidden;-ms-flex-wrap: wrap;flex-wrap: wrap; margin: 0 auto;position: relative;"><p style="font-size: 22px;">Worth:</p>  <div class="jptotal" style="text-align: center; color: #c79030;font-weight: bold; font-size: 30px;line-height: 30px;"></div></div>
			</div>
		</div>

        <div class="roulette-wheel-outer" style="border-bottom: 0px solid transparent !important;;display: inline-block;width: 100%;">
			<div class="flip-container" style="width: 300px;position: relative; display: table;margin: 25px auto;stroke: #c79030 !important;font-weight: bold !important; font-size: 55px;">
				<div class="flip" style="position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%);font-weight: bold !important; font-size: 55px;stroke: #c79030 !important;">
				</div>
			</div>
			<div class="JPSpinLocator"></div>
		</div> 
		
	
		<!--<div class="top-box box-history bottomFade" style="background: #15181F;width: 31.97%;display: inline-block;max-height: 346px;">
		<center>
                        <div class="title" style="font-size: 20px;color: #fefefe;padding: 3px 10px;font-weight: 700;justify-content: center;">History</div>
        </center>
						<div class="history" style="max-height: 346px;overflow: auto;">

                        </div>
						
                    </div> -->
	
			<div class="box-bets">
                <table>
                    <tr style="border-bottom: 3px solid rgba(199, 144, 48, 0.5) !important;"> <td>Players</td> </tr>
                </table>
				
			<div class="player-bets"></div>
				
            </div>

	</div>
   @endsection
@section('scripts')
		<script src="/js/progress.min.js"></script>
		<script src="/js/jackpot.js"></script>
		<script src="/js/jquery.easing.1.3.js"></script>
		<style>
.JPAnim {
    border: 2px solid #000000;
    white-space: nowrap;
	position: relative;
}
.winnerindicator {
    position: absolute;
    margin-left: 497.5px;
    width: 5px;
    height: 40px!important;
    background: #c79030;
    -moz-box-shadow: 0 0 5px #c79030;
    -webkit-box-shadow: 0 0 5px #c79030;
    box-shadow: 0px 0px 5px #c79030;
}
#JPAnimbox{
    height: 112px;
	width: 100%;
	margin: auto;
}
.JPAnimbox2 {
    margin: 5px;
    display: inline-block;
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 1);
    -moz-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 1);
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 1);
}
.JPAnimheader {
    height: 80px;
}
.JPAnimImg{
	width: 80px;
	height: 80px;
}
#JPSpin{
	width: 1000px;
	margin: auto;
	overflow: hidden;
}</style>
@endsection