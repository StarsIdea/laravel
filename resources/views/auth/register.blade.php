<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
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
</style>
<div class="loader"></div>
<div class="overlay"></div>
<x-guest-layout>
    <x-jet-authentication-card style="background: url({{ asset('images/bg01.jpg') }})">
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
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
                        <img class="rounded-full h-20 w-20 object-cover">
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
        <form id="frm_register" method="POST" action="{{ route('register') }}">
            @csrf
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Account Information') }}
            </h2>
            <input type="hidden" name="photo" value="">
            <input type="hidden" name="userType" value="{{ $userType }}">
            <div>
                @if($userType == "talent")
                <x-jet-label value="{{ __('Name') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                @elseif ($userType == "venue")
                <x-jet-label value="{{ __('Contact Name') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="contactName" :value="old('contactName')" required autofocus autocomplete="contactName" />
                @endif
            </div>

            <div class="mt-4 address">
                <div class="mt-4">
                    <x-jet-label value="{{ __('City') }}" />
                    <x-jet-input class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
                </div>
                <div class="mt-4">
                    <x-jet-label value="{{ __('State') }}" />
                    <x-jet-input class="block mt-1 w-full" type="text" name="state" :value="old('state')" required />
                </div>

                <div class="mt-4">
                    <x-jet-label value="{{ __('Zip') }}" />
                    <x-jet-input class="block mt-1 w-full" type="text" name="zip" :value="old('zip')" required />
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Email') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Telephone') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" required />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Password') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Confirm Password') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if($userType == "talent")
                {{ __('Talent Info') }}
                @elseif($userType == "venue")
                {{ __('Venue Info') }}
                @endif
            </h2>

            <div>
                @if($userType == "talent")
                <x-jet-label value="{{ __('Band / Stage Name') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="band" :value="old('band')" required autofocus autocomplete="band" />
                @elseif($userType == "venue")
                <x-jet-label value="{{ __('Venue Name') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="venueName" :value="old('venueName')" required autofocus autocomplete="venueName" />
                @endif
            </div>

            <div>
                <x-jet-label value="{{ __('Genre') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="genre" :value="old('genre')" required autofocus autocomplete="genre" />
            </div>

            <div>
                <x-jet-label value="{{ __('Location') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="location" :value="old('location')" required autofocus autocomplete="location" />
            </div>

            

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Social Media') }}
            </h2>

            <div>
                <x-jet-label value="{{ __('Website') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="website" :value="old('website')" autofocus autocomplete="website" />
            </div>

            <div>
                <x-jet-label value="{{ __('Facebook') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="facebook" :value="old('facebook')" autofocus autocomplete="facebook" />
            </div>

            <div>
                <x-jet-label value="{{ __('Instagram') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="instagram" :value="old('instagram')" autofocus autocomplete="instagram" />
            </div>

            <div>
                <x-jet-label value="{{ __('Twitter') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="twitter" :value="old('twitter')" autofocus autocomplete="twitter" />
            </div>
            @if($userType == "talent")
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tips') }}
            </h2>

            <div>
                <x-jet-label value="{{ __('Paypal') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="paypal" :value="old('paypal')" autofocus autocomplete="paypal" />
            </div>

            <div>
                <x-jet-label value="{{ __('Venmo') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="venmo" :value="old('venmo')" autofocus autocomplete="venmo" />
            </div>

            <div>
                <x-jet-label value="{{ __('CashApp') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="cashapp" :value="old('cashapp')" autofocus autocomplete="cashapp" />
            </div>
            @endif
            


            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </form>
        <x-jet-button class="ml-4">
            {{ __('Register') }}
        </x-jet-button>
    </x-jet-authentication-card>
</x-guest-layout>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(() => {
        $("#frm_register").parent().parent().css('background', 'url({{ asset("images/bg01.jpg") }})');
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
        $('button[type="submit"]').click(function(e){
            if($('input[type="file"]').val()==''){
                $('.file-error').show();
                return false;
            }
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
                        $('#file_form').submit();
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
                location: 'required'
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
            }
        });
    })
</script>