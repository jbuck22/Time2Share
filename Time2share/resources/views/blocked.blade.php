<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blocked') }}
        </h2>
    </x-slot>

    <h2 style="justify-content:center; align-items:center; text-align:center;" class="font-semibold text-xl text-gray-800 leading-tight" >
        You have been blocked. Please reach out to an admin to resolve this issue.
    </h2>

    <section class="product_actions">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-primary-button id="primaryButton" style="margin-left: auto" :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-primary-button>
        </form>
    </section> 
</x-guest-layout>