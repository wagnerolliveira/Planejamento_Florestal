@extends('layouts.layout-dashboard')

@section('styles')
    @vite(['resources/css/dashboard.css'])
@endsection

@section('content')
    <h1>Dashboard</h1>
@endsection

@section('scripts')
    @vite(['resources/js/scripts.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection