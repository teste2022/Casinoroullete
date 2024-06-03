@extends('layouts.app')
@section('content')
<div class="support_form">
	<div>
		<p><strong>Support</strong></p>
		<form  id="support_form">
			<label for="fname">Name</label>
			<input type="text" id="name" name="name" placeholder="Your name..">

			<label for="lname">Email</label>
			<input type="email" id="email" name="email" placeholder="Your email..">

			<label for="country">Feature you are currently facing an issue with</label>
			<select id="country" name="country">
				<option value="roulette">Roulette</option>
				<option value="crash">Crash</option>
				<option value="dice">Dice</option>
				<option value="coinflip">Coinflip</option>
				<option value="jackpot">Jackpot</option>
				<option value="profile">Profile</option>
				<option value="refferals">Refferals</option>
				<option value="deposit">Deposit</option>
				<option value="store">Store</option>
				<option value="pf">Provably Fair</option>
				<option value="FAQ">FAQ</option>
				<option value="giveaway">Giveaway</option>
				<option value="sponsorship">Sponsorship</option>	
				<option value="sponsorship">Other</option>	
			</select>
			
			<label for="lname">Please describe the issue</label>
			<textarea id="description" name="description"></textarea>

			<button>Sumbit</button>
		</form>
	</div>
</div>
<script>
$(document).on('submit','#support_form',function(e){
        e.preventDefault();
   var values = $(this).serialize();
   console.log(values);
});
</script>
   @endsection