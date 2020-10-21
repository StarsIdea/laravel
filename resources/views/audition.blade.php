@extends('layouts.blank')
@section('content')

    <link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
    <script src="https://unpkg.com/video.js/dist/video.min.js"></script>

    <style>
        body {
            background: url('{{ asset("images/bg01.jpg")}}');
            color: white;
        }
    </style>

    <div class="container my-5 col-md-12">
        <h1 class="text-center">Audition</h1>
        <div class="col-md-4 upload-form-section">
            <form id="audition file" method="post" action="#">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" placeholder="Enter name" id="name">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" placeholder="Enter email" id="email">
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone:</label>
                    <input type="text" class="form-control" placeholder="Enter telephone" id="telephone">
                </div>
                <div class="form-group">
                    <label for="band">Band / Stage Name:</label>
                    <input type="text" class="form-control" placeholder="Enter band /stage name" id="band">
                    <label class="form-check-label form-check">
                        <input class="form-check-input" type="checkbox" name="check-brand"> Same as name
                    </label>
                </div>
                <div class="form-group">
                    <label for="genre">Genre:</label>
                    <input type="text" class="form-control" placeholder="Enter genre" id="genre">
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" placeholder="Enter location" id="location">
                </div>
                <div class="form-group">
                    <p>Disclaimer Text box (Display text) </p>
                    <label class="form-check-label form-check">
                        <input class="form-check-input" type="checkbox" name="disclaimer"> Accept disclaimer
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
@endsection
