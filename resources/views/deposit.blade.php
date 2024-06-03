@extends('layouts.app')
@section('content')
                <div class="items-container">
        <div class="infos">
            Choose the items you would like to Deposit
        </div>
        <div class="inv-buttons">
            <input class="form-control search" type="text" placeholder="Search..." disabled>
			<button class="form-control select select-box" off="false">
				<div class="select-button">
					<span id="select-text">Price descending</span> <i class="fa fa-caret-down" aria-hidden="true"></i>
				</div>
				<div class="select-open">
					<div value="price desc" class="active">Price descending</div>
					<div value="price asc">Price ascending</div>
					<div value="name asc">Name ascending</div>
					<div value="name desc">Name descending</div>
				</div>
			</button>
            <button class="form-control force-reload">Refresh Inventory &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></button>
        </div>
        <div class="items inventory">
            <div class="loading">Loading equipment<span class="ldots"><span class="one">.</span><span class="two">.</span><span class="three">.</span>​</span></div>
        </div>
        <div class="infos-selected">
            <div class="items-amount">Total items: <span class="value">0</span> (Max 30 items)</div>
            <div class="items-value">Total Worth: <span class="value">0</span> (0,50$ Min)</div>
        </div>
        <div class="deposit-item-button confirm-button">DEPOSIT</div>
    </div>
	
   @endsection
		
@section('scripts')
    <script src="/js/deposit.js"></script>
@endsection
