@extends('layouts.app')

@section('title', 'Dashboard - ')

@section('content')

    <h1>Hi, {{ auth()->user()->name }}!</h1>

    <div class="row mt-5">
        <div class="col-12 col-lg-6">
            <div class="p-4 border rounded">
                <h4 class="mb-4">Today</h4>
                <div class="row">
                    <div class="col-5 fw-bold">Most Car Sale</div>
                    <div class="col-7">{{ $today['car'] }}</div>
                </div>
                <div class="row">
                    <div class="col-5 fw-bold">Number Of Sales</div>
                    <div class="col-7">{{ $today['number'] }} <small class="text-muted">({{ $today['number_percentage'] }})</small></div>
                </div>
                <div class="row">
                    <div class="col-5 fw-bold">Total Of Sales</div>
                    <div class="col-7">Rp. {{ toNumber($today['total']) }} <small class="text-muted">({{ $today['total_percentage'] }})</small></div>
                </div>
            </div>
            
        </div>
        <div class="col-12 col-lg-6">

            <div class="p-4 border rounded">
                <h4 class="mb-4">Last 7 Days</h4>
                <div class="row">
                    <div class="col-5 fw-bold">Most Car Sale</div>
                    <div class="col-7">{{ $seven['car'] }}</div>
                </div>
                <div class="row">
                    <div class="col-5 fw-bold">Number Of Sales</div>
                    <div class="col-7">{{ $seven['number'] }}</div>
                </div>
                <div class="row">
                    <div class="col-5 fw-bold">Total Of Sales</div>
                    <div class="col-7">Rp. {{ toNumber($seven['total']) }}</div>
                </div>
            </div>

        </div>
    </div>

@endsection