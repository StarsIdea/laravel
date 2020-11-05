<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    #btn_for_venue{
        display:none;
    }
    .alert{
        display:none;
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
            <input type="hidden" name="verification_code" id="code">
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

                <button type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-4" id="btn_for_talent" data-toggle="modal" data-target="#myModal">{{ __('Next') }}</button>
                <x-jet-button class="ml-4" id="btn_for_venue">
                    {{ __('Next') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<div class="modal fade " id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Checking Verification Code</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Verification code isn't existed.</strong>
        </div>
        <label for="verification_code">Verification Code:</label>
        <input type="text" class="form-control" name="verification_code" id="verification_code" value="">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_confirm">Confirm</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>

    $(document).ready(() => {
        $('.user-type input').removeClass('active');
        $('.user-type:first-child input').addClass('active');
        $('.user-type').click(function(){
            $('.user-type input').removeClass('active');
            $(this).find('input').addClass('active');
            $('.user-type input').attr('checked',false);
            $(this).find('input').attr('checked',true);
            $('#btn_for_submit').toggle();
            $('#btn_for_modal').toggle();
        });

        $('#btn_confirm').click(function(event) {
            if($('#verification_code').val() == ''){
                alert('Please input verification code');
                return ;
            }
            event.preventDefault();
            let href = "/check_verification_code";
            $.ajax({
                url: href,
                data: { verification_code :$('#verification_code').val() },
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    console.log(JSON.parse(result));
                    if(JSON.parse(result) == 'exist'){
                        $('#code').val($('#verification_code').val());
                        $('#frm_register').submit();
                    }
                    else{
                        $('.alert.alert-danger').show();
                    }
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            });
        });
    });


</script>
