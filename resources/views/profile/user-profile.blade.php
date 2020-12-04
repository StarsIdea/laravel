@extends('layouts.blank')
@section('extra-css')
    <style>
        .py-12.content {
            min-height: calc(100vh - 250px);
            justify-content: center;
            display: flex;
            flex-direction: column;
        }

        .category {
            min-width: 500px;
        }

        @media only screen and (max-width: 600px) {
            .category {
                min-width: 300px;
            }
        }

        body {
            background-repeat: no-repeat;
            background-size: cover;
            background: url({{ asset('images/bg01.jpg')}});
            background-attachment: fixed;
        }

        .content .dashboard .category {
            background-color: #fff;
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
            /* margin-top: -3rem; */
            display: none;
        }
        body div.min-h-screen.pt-6{
            padding: 100px 60px;
            background-repeat: no-repeat !important;
            background-size: cover !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection
@section('content')
<div class="loader"></div>
<div class="overlay"></div>
    <div class="py-12 content">
        <div class="dashboard">
            <div class="col-md-12">
                <x-guest-layout>
                    <x-jet-authentication-card>
                        <x-slot name="logo">
                        </x-slot>
                        <x-jet-validation-errors class="mb-4" />
                        <form action="{{ $attributes['action'] }}" method="{{ $attributes['method'] }}" enctype="{{ $attributes['enctype'] }}" id="file_form">
                            @foreach($inputs as $key => $input)
                                <input type="hidden" name="{{ $key }}" value="{{ $input }}" />
                            @endforeach
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                                    <!-- Profile Photo File Input -->
                                    <input type="file" class="hidden"
                                                wire:model="photo"
                                                x-ref="photo"
                                                x-on:change="
                                                        photoName = $refs.photo.files[0].name;
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            photoPreview = e.target.result;
                                                        };
                                                        reader.readAsDataURL($refs.photo.files[0]);
                                                " name="file" id="avatar"/>

                                    <x-jet-label for="photo" value="{{ __('Photo') }}" />

                                    <!-- Current Profile Photo -->
                                    <div class="mt-2" x-show="! photoPreview">
                                        <img class="rounded-full h-20 w-20 object-cover img-responsive" src="{!! Storage::disk('s3')->url('avatars/1603817530008_mp4.gif') !!}" alt="thumb">
                                    </div>

                                    <!-- New Profile Photo Preview -->
                                    <div class="mt-2" x-show="photoPreview">
                                        <span class="block rounded-full w-20 h-20"
                                            x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                                        </span>
                                    </div>

                                    <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                                        {{ __('Select A New Photo') }}
                                    </x-jet-secondary-button>

                                    <x-jet-input-error for="photo" class="mt-2" />
                                </div>
                            @endif
                            <span class="help-block text-danger file-error"><label id="file-error" class="error" for="file">Please select valid image file</label></span>
                        </form>
                        <form id="frm_register" method="POST" action="{{ route('updateProfile') }}">
                            @csrf
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Account Information') }}
                            </h2>
                            <input type="hidden" name="photo" value="">
                            <input type="hidden" name="userType" value="{{ $userType }}">
                            <div>
                                @if($userType == "talent")
                                <x-jet-label value="{{ __('Name') }}" />
                                <input class="block mt-1 w-full" type="text" name="name" value="{{ Auth::user()->name }}" required autofocus autocomplete="name" />
                                @elseif ($userType == "venue")
                                <x-jet-label value="{{ __('Contact Name') }}" />
                                <input class="block mt-1 w-full" type="text" name="contactName" value="{{ Auth::user()->name }}" required autofocus autocomplete="contactName" />
                                @endif
                            </div>

                            <div class="mt-4 address">
                                <div class="mt-4">
                                    <x-jet-label value="{{ __('City') }}" />
                                    <input class="block mt-1 w-full" type="text" name="city" value="{{ Auth::user()->city }}" required />
                                </div>
                                <div class="mt-4">
                                    <x-jet-label value="{{ __('State') }}" />
                                    <input class="block mt-1 w-full" type="text" name="state" value="{{ Auth::user()->state }}" required />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label value="{{ __('Zip') }}" />
                                    <input class="block mt-1 w-full" type="text" name="zip" value="{{ Auth::user()->zip }}" required />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-jet-label value="{{ __('Email') }}" />
                                <input class="block mt-1 w-full" type="email" name="email" value="{{ Auth::user()->email }}" readonly required id="email"/>
                            </div>

                            <div class="mt-4">
                                <x-jet-label value="{{ __('Telephone') }}" />
                                <input class="block mt-1 w-full" type="text" name="telephone" value="{{ Auth::user()->telephone }}" required />
                            </div>

                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                @if(Auth::user()->userType == "talent")
                                {{ __('Talent Info') }}
                                @elseif(Auth::user()->userType == "venue")
                                {{ __('Venue Info') }}
                                @endif
                            </h2>

                            <div>
                                @if($userType == "talent")
                                <x-jet-label value="{{ __('Band / Stage Name') }}" />
                                <input class="block mt-1 w-full" type="text" name="band" value="{{Auth::user()->band}}" required autofocus autocomplete="band" />
                                @elseif($userType == "venue")
                                <x-jet-label value="{{ __('Venue Name') }}" />
                                <input class="block mt-1 w-full" type="text" name="venueName" value="{{Auth::user()->venueName}}" required autofocus autocomplete="venueName" />
                                @endif
                            </div>

                            <div>
                                <x-jet-label value="{{ __('Genre') }}" />
                                <input class="block mt-1 w-full" type="text" name="genre" value="{{Auth::user()->genre}}" required autofocus autocomplete="genre" />
                            </div>

                            <div>
                                <x-jet-label value="{{ __('Location') }}" />
                                <input class="block mt-1 w-full" type="text" name="location" value="{{Auth::user()->location}}" required autofocus autocomplete="location" />
                            </div>



                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Social Media') }}
                            </h2>

                            <div>
                                <x-jet-label value="{{ __('Website') }}" />
                                <input class="block mt-1 w-full" type="text" name="website" value="{{Auth::user()->website}}" autofocus autocomplete="website" />
                            </div>

                            <div>
                                <x-jet-label value="{{ __('Facebook') }}" />
                                <input class="block mt-1 w-full" type="text" name="facebook" value="{{Auth::user()->facebook}}" autofocus autocomplete="facebook" />
                            </div>

                            <div>
                                <x-jet-label value="{{ __('Instagram') }}" />
                                <input class="block mt-1 w-full" type="text" name="instagram" value="{{Auth::user()->instagram}}" autofocus autocomplete="instagram" />
                            </div>

                            <div>
                                <x-jet-label value="{{ __('Twitter') }}" />
                                <input class="block mt-1 w-full" type="text" name="twitter" value="{{Auth::user()->twitter}}" autofocus autocomplete="twitter" />
                            </div>
                            @if($userType == "talent")
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Tips') }}
                            </h2>

                            <div>
                                <x-jet-label value="{{ __('Paypal') }}" />
                                <input class="block mt-1 w-full" type="text" name="paypal" value="{{Auth::user()->paypal}}" autofocus autocomplete="paypal" />
                            </div>

                            <div>
                                <x-jet-label value="{{ __('Venmo') }}" />
                                <input class="block mt-1 w-full" type="text" name="venmo" value="{{Auth::user()->venmo}}" autofocus autocomplete="venmo" />
                            </div>

                            <div>
                                <x-jet-label value="{{ __('CashApp') }}" />
                                <input class="block mt-1 w-full" type="text" name="cashapp" value="{{Auth::user()->cashapp}}" autofocus autocomplete="cashapp" />
                            </div>
                            @endif

                            <x-jet-button class="ml-4 btn-update-user">
                                {{ __('Update') }}
                            </x-jet-button>
                        </form>
                        <hr/>
                        <form id="frm_password" method="POST" action="{{ route('updatePassword') }}">
                            @csrf
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Password') }}
                            </h2>
                            <div class="mt-4">
                                <x-jet-label value="{{ __('Password') }}" />
                                <x-jet-input class="block mt-1 w-full" type="password" name="password" id="password" required autocomplete="new-password" />
                            </div>

                            <div class="mt-4">
                                <x-jet-label value="{{ __('Confirm Password') }}" />
                                <x-jet-input class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            </div>

                            <x-jet-button class="ml-4 btn-update-user">
                                {{ __('Reset password') }}
                            </x-jet-button>
                        </form>
                    </x-jet-authentication-card>
                </x-guest-layout>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(() => {
        // $("#frm_register").parent().parent().css('background', 'url({{ asset("images/bg01.jpg") }})');
        $('#avatar').change(function(){
            label = $('input[type="file"]').val().split('\\');
            // console.log(label);
            $('input[name="photo"]').val(Date.now()+"_"+label[label.length-1]);
            file_label = label[label.length-1];
            console.log(file_label)
            var filename = $('input[name="key"]').val().replace("${filename}",Date.now()+"_"+"${filename}");
            // console.log(filename);
            $('input[name="key"]').val(filename);
            if(($('input[type="file"]').val()!='')&&
                ((file_label.endsWith("jpeg"))||
                (file_label.endsWith("png"))||
                (file_label.endsWith("jpg"))||
                (file_label.endsWith("gif"))||
                (file_label.endsWith("svg")))){
                $('.file-error').hide();
            }
            else{
                $('.file-error').show();
            }
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
        $('#frm_register').validate({
            rules: {
                name: 'required',
                email: {
                    required: true,
                    email: true,//add an email rule that will ensure the value entered is valid email id.
                    maxlength: 255,
                },
                city: 'required',
                state: 'required',
                zip: 'required',
                telephone: 'required',
                band: 'required',
                genre: 'required',
                location: 'required',
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    equalTo: '#password'
                },
            },
            messages: {
                name: "Please specify your name",
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                },
                city: "Please specify city",
                state: "Please specify state",
                zip: "Please specify zip",
                telephone: "Please specify telephone",
                band: "Please specify band",
                genre: "Please specify genre",
                location: "Please specify location"
            },
            submitHandler: function(form) {
                console.log($('input[type="file"]').val());
                // if($('input[type="file"]').val()==''){
                //     $('.file-error').show();
                //     $(window).scrollTop(0);
                //     return false;
                // }
                var $form = $('#frm_register');
                var formData = $('#frm_register').serializeFormJSON();
                var ajaxurl = $('#frm_register').attr("action");
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
                        data = JSON.parse(data);
                        if(data=="success"){
                            if($('input[type="file"]').val()!=''){
                                $('#file_form').submit();
                            }
                            else{
                                document.location.href="/admin/userProfile";
                            }
                        }
                        else if(data=="incorrect_verification_code"){
                            alert('Incorrect Verification Code');
                            $('.loader').hide();
                            $('.overlay').hide();
                        }
                        else{
                            for(var i in data){
                                var key = i;
                                var val = data[i];
                                if(i == "email"){
                                    alert(data["email"]);
                                }
                            }
                            $('.loader').hide();
                            $('.overlay').hide();
                        }
                    }
                });
            }
        });
        $('#frm_password').validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    equalTo: '#password'
                },
                messages: {
                    password: {
                        required: "Please specify your name",
                        minlength: "Your password must be at least 8 characters long"
                    },
                    password_confirmation: {
                        equalTo: "Please enter the same password as above"
                    },
                }
            }
        });
    })
</script>
@endsection
