@extends('layouts.app')
@section('content')
	 <div class="auxil-terms">
		<div class="ui container">
			<b>Please Note</b>
			<p>Provably fair is designed to ensure that the results are fair and cannot be changed. The way it tends to work, and works on CSGOSentinel, is by generating a salt and using this with the value used to determin the result. The generated hash is then sent to the client before any amount of money has been played.</p>
			</br>
			<b>Roulette</b>
			<p>This works by using the sha256 hash function on the winning number and the secret.<br>The hash is displayed before the game rolles and the secret is displayed after.<br>The code for this is `sha256(winningNumber + ":" + secret);`<br>You can try it below or do it manually.</p>
			<form id="roulette-pf">
				Number: <input type="text" id="roulette-number" class="pf-textbox"><br>
				Secret: <input type="text" id="roulette-secret" class="pf-textbox"><br>
				<input type="submit" value="Submit">
			</form>
			<p id="roulette-expected-hash">Expected hash:</p>
			<b>Crash</b>
			<p>Use the hash and secret</p>

			<b>Dice</b>
			<p>This works by using the sha256 hash function on the rolled number and the secret.<br>The hash is displayed before you roll and the secret is displayed after.<br>The code for this is `sha256(roll + ":" + secret);`<br>You can try it below or do it manually.</p>
			<form id="dice-pf">
				Roll: <input type="text" id="dice-number"  class="pf-textbox"><br>
				Secret: <input type="text" id="dice-secret"  class="pf-textbox"><br>
				<input type="submit" value="Submit">
			</form>
			<p id="dice-expected-hash">Expected hash:</p>

		</div>
	</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="/js/pf.js"></script>
@endsection