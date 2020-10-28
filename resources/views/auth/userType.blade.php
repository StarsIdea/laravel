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
        
        <form id="frm_register" method="GET" action="{{ route('register') }}">
            @csrf
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Choose Account Type') }}
            </h2>
            <input type="hidden" name="userType" value="">

            <div>
                <div class="user-type">
                    <x-jet-input class="block" type="radio" name="userType" required autofocus autocomplete="userType" value="talent" checked/> <span>Talent</span>
                </div>
                <div class="user-type">
                    <x-jet-input class="block" type="radio" name="userType" required autofocus autocomplete="userType" value="venue"/> <span>Venue</span>
                </div>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Next') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
    // $(document).ready(() => {
    //     $('.user-type span').click(function(){
    //         $('.user-type input[type="radio"]').attr("checked",false);
    //         $(this).parent().find('input[type="radio"]').attr("checked",true);
    //     });
    // });
    $(document).ready(() => {
        $('.user-type input').removeClass('active');
        $('.user-type:first-child input').addClass('active');
        $('.user-type').click(function(){
            $('.user-type input').removeClass('active');
            $(this).find('input').addClass('active');
            $('.user-type input').attr('checked',false);
            $(this).find('input').attr('checked',true);
        });
        // $('.user-type span').click(function(){
        //     console.log($(this).parent('.user-type').find('input'));
        //     $(this).parent('.user-type').find('input').click();
        // });
    });
</script>