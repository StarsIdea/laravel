<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<x-guest-layout>
    <x-jet-authentication-card style="background: url({{ asset('images/bg01.jpg') }})">
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form id="frm_register" method="POST" action="{{ route('register') }}">
            @csrf
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Account Information') }}
            </h2>

            <div>
                <x-jet-label value="{{ __('Name') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
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
                <x-jet-input class="block mt-1 w-full" type="text" name="email" :value="old('email')" required />
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
                {{ __('Talent Info') }}
            </h2>

            <div>
                <x-jet-label value="{{ __('Band / Stage Name') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="band" :value="old('band')" required autofocus autocomplete="band" />
            </div>

            <div>
                <x-jet-label value="{{ __('Genre') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="genre" :value="old('genre')" required autofocus autocomplete="genre" />
            </div>

            <div>
                <x-jet-label value="{{ __('Location') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="location" :value="old('location')" required autofocus autocomplete="location" />
            </div>

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
                                " name="photo"/>

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

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Social Media') }}
            </h2>

            <div>
                <x-jet-label value="{{ __('Website') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="website" :value="old('website')" required autofocus autocomplete="website" />
            </div>

            <div>
                <x-jet-label value="{{ __('Facebook') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="facebook" :value="old('facebook')" required autofocus autocomplete="facebook" />
            </div>

            <div>
                <x-jet-label value="{{ __('Instagram') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="instagram" :value="old('instagram')" required autofocus autocomplete="instagram" />
            </div>

            <div>
                <x-jet-label value="{{ __('Twitter') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="twitter" :value="old('twitter')" required autofocus autocomplete="twitter" />
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tips') }}
            </h2>

            <div>
                <x-jet-label value="{{ __('Paypal') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="paypal" :value="old('paypal')" required autofocus autocomplete="paypal" />
            </div>

            <div>
                <x-jet-label value="{{ __('Venmo') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="venmo" :value="old('venmo')" required autofocus autocomplete="venmo" />
            </div>

            <div>
                <x-jet-label value="{{ __('CashApp') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="cashapp" :value="old('cashapp')" required autofocus autocomplete="cashapp" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" name="accept_terms" required>
                    <span class="ml-2 text-sm text-gray-600">Agree to <a href="{{ route('terms') }}" class="text-green-500" target="_blank" style="text-decoration: underline"> terms </a> and conditions</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
    $(document).ready(() => {
        $("#frm_register").parent().parent().css('background', 'url({{ asset("images/bg01.jpg") }})')
    })
</script>