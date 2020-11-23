@extends('layouts.blank')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection

@section('content')
    <section>
        <h1>LiveShow</h1>
        <p>LiveShow Cloud Stage - Launching Soon!<br />
        Be the first to know!</p>
    </section>

    <!-- Subscribe Form -->
    <form id="frm_subscribe" method="get" action="#">
        @csrf
        <input type="email" name="email" id="email" placeholder="Email Address" />
        <input type="submit" value="Subscribe" />
    </form>
@endsection

@section('extra-js')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
