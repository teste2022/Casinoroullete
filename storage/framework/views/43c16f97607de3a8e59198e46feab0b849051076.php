<?php $__env->startSection('content'); ?>
<div class="roulette">
<div class="roulette-progress">
        <div class="progress-bar"><div class="progress"></div>
<span style="
    color: #fff;">
  <i class="fa fa-volume-up"></i>
  <span>Rolling in</span>
  <!----><span class="rolling-inner"></span>
</span>
</div>
    </div>
	<div class="balance-latest">
		<div class="latest"></div>
	</div>
	<div class="spinner">
		<div class="inner">
			<div class="roulette-wheel-outer">
				<div class="roulette-wheel">
					<div class="fade-right"></div>
					<div class="fade-left"></div>
					<div class="roulette-caret-down-left"><!--<i class="fa fa-caret-down" aria-hidden="true"></i>--></div>
				</div>
			</div>
		</div>
	</div>
	<div class="controls">
		<div class="inputs-area">
			<div class="amount">
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
	</div>
	<div class="bet-buttons">
		<button type="button" class="btn btn-lg btn-block btn-3d-danger bet-button" data-value="red">
          <span class="hidden-sm-down">1 to 7, Win 2x</span>
          <!---->
        </button>
		<button type="button" class="btn btn-lg btn-block btn-3d-success bet-button" data-value="green">
          <span class="hidden-sm-down">0, Win 14x</span>
          <!---->
        </button>
		<button type="button" class="btn btn-lg btn-block btn-3d-inverse bet-button" data-value="black">
          <span class="hidden-sm-down">8 to 14, Win 2x</span>
          <!---->
        </button></div>
	<div class="roulette-info">Round hash: ...</div>
	<div class="bets">
		<div class="bet-box red-bet">
			<div class="bet-info">
				<div class="bet-label"><i class="fa fa-users icon-game" aria-hidden="true"></i><div class="red-players">0</div></div>
				<div class="total-bet"><span class="red-total total-bet-amount" data-value="0">0</span></div>
			</div>
			<div class="player-bets"></div>
		</div>
		<div class="bet-box green-bet">
			<div class="bet-info">
				<div class="bet-label"><i class="fa fa-users icon-game" aria-hidden="true"></i><div class="green-players">0</div></div>
				<div class="total-bet"><span class="green-total total-bet-amount" data-value="0">0</span></div>
			</div>
			<div class="player-bets"></div>
		</div>
		<div class="bet-box black-bet">
			<div class="bet-info">
				<div class="bet-label"><i class="fa fa-users icon-game" aria-hidden="true"></i><div class="black-players">0</div></div>
				<div class="total-bet"><span class="black-total total-bet-amount" data-value="0">0</span></div>
			</div>
			<div class="player-bets"></div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
		
<?php $__env->startSection('scripts'); ?>
	<script src="/js/roulette.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>