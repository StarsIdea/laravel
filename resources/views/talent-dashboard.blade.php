@extends('layouts.blank')
@section('extra-css')
    <style>
    </style>
@endsection
@section('content')
@endsection
@section('extra-js')
    <script>
        let evtSource = new EventSource("/getEventStream", {
            withCredentials: true
        });
        evtSource.onmessage = function(e) {
            let data = JSON.parse(e.data);
            console.log(data);
        };

    </script>
@endsection
