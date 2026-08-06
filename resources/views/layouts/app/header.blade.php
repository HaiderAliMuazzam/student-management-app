<header>
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

        <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

        <x-app-logo href="{{ route('dashboard') }}" wire:navigate />


        <flux:navbar class="-mb-px max-lg:hidden">

            <flux:navbar.item 
                icon="layout-grid"
                :href="route('dashboard')"
                :current="request()->routeIs('dashboard')"
                wire:navigate>

                {{ __('Dashboard') }}

            </flux:navbar.item>

        </flux:navbar>


        {{-- Language Switcher --}}
        <div class="flex items-center gap-2 ms-3">

            <a href="{{ route('language.switch', 'en') }}"
               class="px-3 py-1 text-sm rounded bg-zinc-200 dark:bg-zinc-700">

                English

            </a>


            <a href="{{ route('language.switch', 'ar') }}"
               class="px-3 py-1 text-sm rounded bg-zinc-200 dark:bg-zinc-700">

                العربية

            </a>

        </div>


        <x-desktop-user-menu />

        <flux:spacer />


    </flux:header>
</header>