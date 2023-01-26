<h1>authenticated</h1>
<form method="POST" action="{{ route('logout') }}" x-data>
    @csrf

    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                   @click.prevent="$root.submit();">
        {{ __('Log Out') }}
    </x-jet-responsive-nav-link>
</form>