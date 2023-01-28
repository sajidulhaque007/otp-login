<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <h2>OTP Login</h2>
        </x-slot>
        <x-jet-validation-errors class="mb-4" />
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('generate-otp')}}" method="POST">
            @csrf
            <div>
                <x-jet-label for="mobile_no" value="{{ __('Enter your registered mobile no') }}" />
                <x-jet-input id="mobile_no" class="block mt-1 w-full" type="text" name="mobile_no" :value="old('mobile_no')" required autofocus />
            </div>
            <br>
            <x-jet-button class="ml-4">
                Generate OTP
            </x-jet-button>
            <br>
            @auth
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                {{ __('Not registered?') }}
            </a>
            @endauth
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
