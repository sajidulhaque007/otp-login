<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <img src="{{asset('index2.jpg')}}" alt="">
            
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('verified-otp-login')}}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <div>
                <x-jet-label for="otp" value="{{ __('Enter your OTP') }}" />
                <x-jet-input id="otp" class="block mt-1 w-full" type="text" name="otp" :value="old('otp')" required autofocus />
            </div>
            <br>
            <x-jet-button class="ml-4">
                login
            </x-jet-button>
            <br>  
            <br>  
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('otp-login') }}">
                {{ __('Resend OTP') }}
            </a>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
