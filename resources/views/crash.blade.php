@extends('layouts.app')
@section('content')
	<div style="display: flex;">
		<div class="crash">
			 <div class="top">
				<div class="top-box box-chart">
					<div class="chart"></div>
					<div class="chart-info"></div>
				</div>
				<div class="boxes">
					<div class="top-box box-bet" style="border-top-right-radius: 10px;">
					  <div class="way">
							<div class="manual-way active" data-show="manual" onclick="crash.setWay(this)">Manual</div>		
							<div class="automatic-way" data-show="automatic" onclick="crash.setWay(this) ">Automatic</div>		
						</div>		
						<div class="manual-way-content" style="display: block;">
							<div class="input-group">
								<label for="bet-coins">Bet: <span>(min <span class="min-bet">100</span>, max <span class="max-bet">100,000</span>)</span> </label>
								<input id="bet-coins" type="number" step="100" value="100" min="0">
							</div>
							<div class="input-group">
								<label for="bet-cashout">Auto cashout at (0 = disabled): </label>
								<input type="number" min="1" step="0.01" value="2" id="bet-cashout">
							</div>

							<button class="bet-butt active" onclick="crash.bet()">PLACE YOUR BET</button>
						</div>
						
						 <div class="automatic-way-content" style="display: none;">		
							<div class="input-group">		
								<label for="autobet-coins">Base: <span>(min <span class="min-bet">100</span> , max <span class="max-bet">100,000</span>)</span> </label>		
								<input id="autobet-coins" type="number" step="100" value="0" min="0">		
							</div>		
							<div class="custom-row">		
								<div class="col-6">		
									<div class="input-group">		
										<label for="autobet-cashout">Auto cashout: </label>		
										<input type="number" min="1" step="0.01" value="2" id="autobet-cashout">		
									</div>		
								</div>		
								<div class="col-6">		
									<div class="input-group">		
										<label for="autobet-limit">Stop at: </label>		
										<input type="number" value="0" min="0" step="100" id="autobet-limit">		
									</div>		
								</div>		
							</div>		
							<div class="custom-row radios">		
								<div class="col-6">		
									<label class="without-input">On Win: </label>		
									<div class="radio-group">		
										<input type="radio" name="autobet-on-win" id="autobet-on-win-multiply-select">		
										<label for="autobet-on-win-multiply-select">Multiply by</label>		
										<input type="number" min="0.01" value="2" step="0.01" id="autobet-on-win-multiply">		
									</div>		
									<div class="radio-group">		
										<input type="radio" name="autobet-on-win" id="autobet-on-win-back" checked>		
										<label for="autobet-on-win-back">Back to base bet</label>		
									</div>		
								</div>		
								<div class="col-6">		
									<label class="without-input">On Lose: </label>		
									<div class="radio-group">		
										<input type="radio" name="autobet-on-lose" id="autobet-on-lose-multiply-select">		
										<label for="autobet-on-lose-multiply-select">Multiply by</label>		
										<input type="number" min="0.01" value="2" step="0.01" id="autobet-on-lose-multiply">		
									</div>		
									<div class="radio-group">		
										<input type="radio" name="autobet-on-lose" id="autobet-on-lose-base" checked>		
										<label for="autobet-on-lose-base"> Back to base bet</label>		
									</div>		
								</div>		
								<div class="autobet-max-bets-container input-group">		
									<label for="autobet-max-bets">Max bets: </label>		
									<input type="number" min="0" value="0" step="1" id="autobet-max-bets">		
								</div>		
								<div class="clearfix"></div>		
							</div>		
							<button class="autobet-butt" state="idle" onclick="crash.autobet()"></button>		
						</div>
						
					</div>
				</div>
			</div>
		<div class="box-history">
			<table>
				<thead>
					<tr>
						<td style="width: 100px;">Crashed</td>
						<td style="width: 100px;">Time</td>
						<td style="width: calc(60% - 100px);">Hash</td>
						<td style="width: calc(40% - 100px);">Secret</td>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		</div>
		<div class="box-bets">
			<table>
				<tr>
					<td>Player</td>
					<td>Bet</td>
					<td>Cashed</td>
					<td>Profit</td>
				</tr>
			</table>
		</div>
	</div>
   @endsection
		
@section('scripts')
	<script src="/js/crash.js"></script>
@endsection