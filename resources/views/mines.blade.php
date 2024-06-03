@extends('layouts.app')
@section('content')
                <div class="mines">
        <div class="startgame">
            <div class="top">
                <div class="balance" data-balance="@if (Auth::check()){{Auth::user()->wallet}}@else{{0}}@endif">Balance: <span class="value">@if (Auth::check()){{Auth::user()->wallet}}@else{{0}}@endif</span> <a href="/user/deposit"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></div>
                <div class="bombs">
                    <div class="label">Select number of bombs</div>
                    <button class="btn-multi active" data-value="1">1</button>
                    <button class="btn-multi" data-value="3">3</button>
                    <button class="btn-multi" data-value="5">5</button>
                    <button class="btn-multi" data-value="24">24</button>
                </div>
            </div>
            <div class="inputs">
                <div class="inputs-area">
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
                    <div class="amount">
                        <label for="minesBet">Enter the amount: </label>
                        <input id="minesBet" class="value" placeholder="Your amount..." />
                    </div>
                </div>
                <div class="play">
                    <button class="btn-play" data-value="x1">Play</button>
                </div>
            </div>
        </div>

    </div>
    @endsection

    @section('scripts')
    	<script src="/js/mines.js"></script>
    @endsection
