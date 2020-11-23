@extends('layouts.blank')
@section('extra-css')
<style>
    body {
        background: url('{{ asset("images/bg01.jpg")}}');
        color: white;
        background-size: cover;
        background-repeat: no-repeat;
    }
    .file-error{
        display: none;
    }
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }
    .loader {
        border-top: 16px solid #3498db;
        border-bottom: 16px solid #3498db;
        margin-top: calc(50vh - 60px);
        position: fixed;
        margin-left: calc(50vw - 60px);
        z-index: 10000;
        display: none;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .overlay{
        position: fixed;
        z-index: 100;
        background-color: #000;
        opacity: 0.7;
        width: 100vw;
        height: 100vh;
        margin-top: -3rem;
        display: none;
    }
</style>
@endsection
@section('content')
    <div class="loader"></div>
    <div class="overlay"></div>
    <div class="container my-5 col-md-12">
        <span class="text-center">
        <h2>Be a part of LiveShow!</h2>
        <h3>Submit your Audition today</h3>
        </span>
        <div class="col-md-8 col-lg-4 upload-form-section">
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
                                Browse
                            <input id="video-input" name="file" type="file" multiple value="{{ old('file') }}">
                            </span>
                        </label>
                        <input type="text" class="form-control rounded-0 lspace" readonly placeholder="Upload video">
                    </div>
                    <span class="help-block text-danger">{{$errors->first('file')}}</span>
                </div>
                <div class="form-group">
                    <p>Disclaimer Text box (Display text) </p>
                    <label class="form-check-label form-check">
                        <input class="form-check-input" type="checkbox" name="disclaimer" id="check_disclaimer"> Accept Terms
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
                                Browse
                            <input id="video-input" name="file" type="file" multiple value="{{ old('file') }}">
                            </span>
                        </label>
                        <input type="text" class="form-control rounded-0 lspace" readonly placeholder="Upload video">
                    </div>
                    <span class="help-block text-danger">{{$errors->first('file')}}</span>
                </div>
            </form>
            <span class="help-block text-danger file-error"><label id="file-error" class="error" for="file">Please select video file</label></span>
            <div class="form-group">
                <div class="disclaimer">
                    <p class="header">Terms and Conditions</p>
                    <p class="content">You are uploading your audition video for consideration to use the
                                       LiveShow service. Uploading a video does not constitute guaranteed acceptance to use the service.
                                       All auditions are reviewed and judged on merit which will include quality of performer / performance,
                                       technical quality of the audition video and fit for curation of the LiveShow brand. By uploading your
                                       audition and providing content to the Live Show service, you grant to
                                       Live Show a worldwide, non-exclusive, royalty-free, sublicensable and transferable license to use uploaded
                                       content. This may include distribution, display, reproduction, and derivative works in connection with
                                       LiveShow, its successors and affiliates business, including for the purpose of promoting and redistributing
                                       part or all of the LiveShow service.</p>
                </div>
                <label class="form-check-label form-check">
                    <input class="form-check-input" type="checkbox" name="disclaimer" id="check_disclaimer"> I Accept Terms and Conditions
                </label>
            </div>
            <button class="btn btn-primary" id="btn_upload">Upload</button>
        </div>

    </div>
@endsection

@section('extra-js')
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
        $('input[name="filename"]').val(Date.now()+"_"+label);
        var filename = $('input[name="key"]').val().replace("${filename}",Date.now()+"_"+"${filename}");
        console.log(filename);
        $('input[name="key"]').val(filename);
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
            $('.loader').show();
            $('.overlay').show();
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
