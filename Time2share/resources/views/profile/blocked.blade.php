<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blocked') }}
        </h2>
    </x-slot>

    You have been blocked. Please reach out to an admin to resolve this issue. 
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-primary-button :href="route('logout')"
                onclick="event.preventDefault();
                            this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-primary-button>
    </form>
</x-guest-layout>