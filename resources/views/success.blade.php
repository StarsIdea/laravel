@extends('layouts.blank')
@section('content')
    <section style="text-align:center;margin-top:50px;">
        <h1>Thank you</h1>
        @if($mode == 'register')
        <h2>Please check your eamil and verify for your account.</h2>
        @endif
    </section>

@endsection
