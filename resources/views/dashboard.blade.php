@extends('layouts.app')

@section('title', 'Dashboard - ')

@section('content')

    <h1>Hi, {{ auth()->user()->name }}!</h1>

@endsection