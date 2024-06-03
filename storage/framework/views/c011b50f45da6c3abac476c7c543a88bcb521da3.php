<?php $__env->startSection('content'); ?>
	<div class="dice">
    <div class="controls border-top-green">
        <div class="split split--balance-type">
            <div class="game-type">
                <div class="button" data-value="lighting"><i class="fa fa-bolt" aria-hidden="true"></i> Lighting</div>
               <!-- <div class="button" data-value="automatic"><i class="fa fa-repeat" aria-hidden="true"></i> Automatic</div>-->
            </div>
        </div>
        <div class="split split--amount-profit">
            <div class="amount">
                <label for="bet-amount">Bet amount</label>
                <div class="controls-amount">
                    <input type="number" value="10" id="bet-amount" class="value">
                    <div class="button" data-action="1/2">1<span>/</span>2</div>
                    <div class="button" data-action="x2"><span>X</span>2</div>
                    <div class="button" data-action="clear">Clear</div>
                    <div class="button" data-action="max">Max</div>
                </div>
            </div>
            <div class="profit">
                <label class="text-center">Profit on win</label>
                <div class="value">10</div>
            </div>
        </div>
        <div class="split split--chance-multiplier">
            <div class="win-chance">
                <label for="win-chance">Win chance</label>
                <div class="win-chance-controls">
                    <input type="number" value="48" min="5" max="95" step="0.1" data-value="4900" id="win-chance" class="value">
                    <input type="range" value="48" min="5" max="95" step="0.1" data-value="4900" class="range-value">
                </div>
            </div>
            <div class="multiplier">
                <label for="multiplier" class="text-center">Multiplier</label>
                <input type="number" min="1.01" step="0.01" value="2" data-value="200" id="multiplier" class="value">
            </div>
        </div>
        
		<div class="split" id="dice-odometer" style="display: block;">
			<div class="dice-odometer">
				<div class="row">
					<div>
					  <i class="fa fa-caret-right dice-caret" aria-hidden="true"></i>
					</div>
					<div class="numbers">
					<style id="dice_speed_set">
					.roll-SLOW {
					transition: linear 5s;
					}
					.roll-FAST {
					transition: cubic-bezier(0.29, 0.05, 0, 0.31) 3s;
					}
					</style>
					<div class="row">
						<div>
						  <div id="numbers-1" class="numbers">
							<ul>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							</ul>
						  </div>
						</div>
						<div>
						  <div id="numbers-2" class="numbers">
							<ul>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							</ul>
						  </div>
						</div>
						<div>
						  <div id="numbers-3" class="numbers">
							<ul>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							</ul>
						  </div>
						</div>
						<div>
						  <div id="numbers-4" class="numbers">
							<ul>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							  <li>6</li>
							  <li>7</li>
							  <li>8</li>
							  <li>9</li>
							  <li>0</li>
							  <li>1</li>
							  <li>2</li>
							  <li>3</li>
							  <li>4</li>
							  <li>5</li>
							</ul>
						  </div>
						</div>
					  </div>
					</div>
					<div>
					  <i class="fa fa-caret-left dice-caret" aria-hidden="true"></i>
					</div>
				  </div>
				</div>
			</div>
			<div class="type-selection split" data-active-type="under">
				<p><span class="active cursor-pointer" data-type="under">Under</span> / <span class="cursor-pointer" data-type="above">Above</span></p>
			</div>

			<div class="button-roll state-before-roll" id="bet-button">
				<span data-state="before-roll">Roll <span class="type">under</span> <span class="roll-value">48.00</span> to win</span>
				<span data-state="rolling"></span>
				<span data-state="after-roll"><span class="rolling-text">Rolling</span><span class="rolled"></span>!</span>
			</div>

			<div class="provably-fair-details">
				<p class="hash">Hash: <span class="hash-value"></span></p>
				<div class="previous-round empty">
					<p>Previous hash: <span class="previous-hash-value"></span></p>
					<p>Secret: <span class="previous-secret-value"></span></p>
					<p>Roll: <span class="previous-roll-value"></span></p>
				</div>
			</div>
		</div>

		<div class="history-selects">
			<div class="history-select" data-type="my-bets">My bets</div>
			<div class="history-select active" data-type="all-bets">All bets</div>
			<div class="history-select" data-type="high-rollers">High rollers</div>
		</div>
		<div class="game-history-area all-bets">
			<table>
				<thead>
					<tr>
						<td>Players</td>
						<td>X</td>
						<td>Bet</td>
						<td>Game</td>
						<td>Roll</td>
						<td>Profit</td>
					</tr>
				</thead>
				<tbody class="game-history my-bets"></tbody>
				<tbody class="game-history all-bets"></tbody>
				<tbody class="game-history high-rollers"></tbody>
			</table>
		</div>
	</div>
<?php $__env->stopSection(); ?>
		
<?php $__env->startSection('scripts'); ?>
	<script src="/js/dice.js"></script>
	<link rel="stylesheet" href="/css/dice.css"></link>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>