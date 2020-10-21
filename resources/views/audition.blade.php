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
        @if (session('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{session('success')}}
            </div>
        @endif
        <div class="col-md-4 upload-form-section">
            <form action="{{ route('uploadfile') }}" enctype="multipart/form-data" method="post">
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
                <div class="input-group">
                        <label class="input-group-btn my-0">
                                    <span class="btn btn-large btn-outline-primary rounded-0" id="browse">
                                        Browse&hellip; 
                                    <input id="video-input" name="file" type="file" multiple>
                                    </span>
                                    <span class="help-block text-danger">{{$errors->first('file')}}</span>
                                </label>
                        <input type="text" class="form-control rounded-0" readonly placeholder="Upload video">
                </div>
                <div class="form-group">
                    <p>Disclaimer Text box (Display text) </p>
                    <label class="form-check-label form-check">
                        <input class="form-check-input" type="checkbox" name="disclaimer"> Accept disclaimer
                    </label>
                </div>
                <button class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
    <script>
    $(document).on("change", ":file", function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input
            .val()
            .replace(/\\/g, "/")
            .replace(/.*\//, "");
        input.trigger("fileselect", [numFiles, label]);
        console.log(label);
    });
    $(document).ready(function() {
        $(":file").on("fileselect", function(event, numFiles, label) {
            var input = $(this)
                .parents(".input-group")
                .find(":text"),
                log = numFiles > 1 ? numFiles + " files selected" : label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }
        });
    });
    </script>
@endsection
