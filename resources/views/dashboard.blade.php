@extends('layouts.blank')
@section('extra-css')
<style>
    .py-12.content{
        min-height: calc(100vh - 250px);
        justify-content: center;
        display: flex;
        flex-direction: column;
    }
    .category{
        min-width: 500px;
    }
    @media only screen and (max-width: 600px) {
        .category{
            min-width: 300px;
        }
    }
    body{
        background-repeat: no-repeat;
        background-size: cover;
        background: url({{ asset('images/bg01.jpg') }});
    }
    .content .dashboard .category{
        background-color: #fff;
    }
</style>
@endsection
@section('content')
    <div class="py-12 content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dashboard">
            <div class="category"><a href="/admin/audition">Uploaded Auditions</a></div>
            @if(Auth::user()->userType == 'talent')
            <div class="category"><a href="/admin/performer">Performer List</a></div>
            <div class="category"><a href="/admin/venue">Venue List</a></div>
            @endif
        </div>
    </div>
@endsection
