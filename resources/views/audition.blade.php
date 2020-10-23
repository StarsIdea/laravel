@extends('layouts.blank')
@section('content')

    <link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
    <script src="https://unpkg.com/video.js/dist/video.min.js"></script>

    <style>
        body {
            background: url('{{ asset("images/bg01.jpg")}}');
            color: white;
        }
        .file-error{
            display: none;
        }
    </style>

    <div class="container my-5 col-md-12">
        <h1 class="text-center">Audition</h1>
        <div class="col-md-4 upload-form-section">
        @if (session('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{session('success')}}
            </div>
        @endif
            <form action="{{ route('uploadfile') }}" enctype="multipart/form-data" method="post" id="content_form">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" placeholder="Enter name" name="name" id="name" value="{{ old('name') }}">
                    <span class="help-block text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" placeholder="Enter email" name="email" id="email" value="{{ old('email') }}">
                    <span class="help-block text-danger">{{$errors->first('email')}}</span>
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone:</label>
                    <input type="text" class="form-control" placeholder="Enter telephone" name="telephone" id="telephone" value="{{ old('telephone') }}">
                    <span class="help-block text-danger">{{$errors->first('telephone')}}</span>
                </div>
                <div class="form-group">
                    <label for="band">Band / Stage Name:</label>
                    <input type="text" class="form-control" placeholder="Enter band /stage name" name="band" id="band" value="{{ old('band') }}">
                    <span class="help-block text-danger">{{$errors->first('band')}}</span>
                    <label class="form-check-label form-check">
                        <input class="form-check-input" type="checkbox" name="check-brand" id="check_brand"> Same as name
                    </label>
                </div>
                <div class="form-group">
                    <label for="genre">Genre:</label>
                    <input type="text" class="form-control" placeholder="Enter genre" name="genre" id="genre" value="{{ old('genre') }}">
                    <span class="help-block text-danger">{{$errors->first('genre')}}</span>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" placeholder="Enter location" name="location" id="location" value="{{ old('location') }}">
                    <span class="help-block text-danger">{{$errors->first('location')}}</span>
                </div>
                <input type="hidden" name="filename" value="">
                <!-- <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-btn my-0">
                            <span class="btn btn-large btn-outline-primary rounded-0" id="browse">
                                Browse&hellip; 
                            <input id="video-input" name="file" type="file" multiple value="{{ old('file') }}">
                            </span>
                        </label>
                        <input type="text" class="form-control rounded-0" readonly placeholder="Upload video">
                    </div>
                    <span class="help-block text-danger">{{$errors->first('file')}}</span>
                </div>
                <div class="form-group">
                    <p>Disclaimer Text box (Display text) </p>
                    <label class="form-check-label form-check">
                        <input class="form-check-input" type="checkbox" name="disclaimer" id="check_disclaimer"> Accept disclaimer
                    </label>
                </div>
                <button class="btn btn-primary" id="btn_upload">Upload</button> -->
            </form>



            <form action="{{ $attributes['action'] }}" method="{{ $attributes['method'] }}" enctype="{{ $attributes['enctype'] }}" id="file_form">
                @foreach($inputs as $key => $input)
                    <input type="hidden" name="{{ $key }}" value="{{ $input }}" />
                @endforeach
<!--                 
                <input type="file" name="file" />

                <p><button>Submit</button></p> -->
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-btn my-0">
                            <span class="btn btn-large btn-outline-primary rounded-0" id="browse">
                                Browse&hellip; 
                            <input id="video-input" name="file" type="file" multiple value="{{ old('file') }}">
                            </span>
                        </label>
                        <input type="text" class="form-control rounded-0" readonly placeholder="Upload video">
                    </div>
                    <span class="help-block text-danger">{{$errors->first('file')}}</span>
                </div>
            </form>
            <span class="help-block text-danger file-error"><label id="file-error" class="error" for="file">Please select video file</label></span>
            <div class="form-group">
                <p>Disclaimer Text box (Display text) </p>
                <label class="form-check-label form-check">
                    <input class="form-check-input" type="checkbox" name="disclaimer" id="check_disclaimer"> Accept disclaimer
                </label>
            </div>
            <button class="btn btn-primary" id="btn_upload">Upload</button>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
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
        $('input[name="filename"]').val(label);
        if($('input[type="file"]').val()==''){
            $('.file-error').show();
        }
        else{
            $('.file-error').hide();
        }
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
        $('#check_brand').click(function(){
            if(($(this).is(":checked"))){
                $('#band').val($('#name').val());
            }
            else{
                $('#band').val("");
            }
        });
        $('#btn_upload').prop('disabled',true);
        $('#check_disclaimer').click(function(){
            // console.log($(this).is(":checked"));
            $('#btn_upload').prop('disabled',($(this).is(":checked"))?false:true);
        });
        $("#btn_upload").click(function(e){
            $('#content_form').submit();
        });
        $('#content_form').submit(function (e) {
            e.preventDefault();
            if($('input[type="file"]').val()==''){
                $('.file-error').show();
                return false;
            }
            var $form = $(this);
            var formData = $('#content_form').serializeFormJSON();
            var ajaxurl = $('#content_form').attr("action");
            if (!$form.valid()) return false;
            console.log($form.valid());
            console.log(formData)
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: formData,
                datatype: 'json',
                success: function (data) {
                    console.log(data);
                    if(data="success"){
                        $('#file_form').submit();
                    }
                }
            });
            return false;
        });
        $.fn.serializeFormJSON = function () {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
        $('#content_form').validate({
            rules: {
                name: 'required',
                email: {
                    required: true,
                    email: true,//add an email rule that will ensure the value entered is valid email id.
                    maxlength: 255,
                },
                telephone: 'required',
                band: 'required',
                genre: 'required',
                location: 'required',
                fileName: 'required'
            },
            messages: {
                name: "Please specify your name",
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                },
                telephone: "Please specify telephone",
                band: "Please specify band",
                genre: "Please specify genre",
                location: "Please specify location",
                fileName: "Please specify file"
            }
        });
    });
    </script>
@endsection
