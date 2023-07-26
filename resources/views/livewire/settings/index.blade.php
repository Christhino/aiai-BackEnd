@section('title', __('Settings'))
<div>

    <x-baseview title="{{ __('Settings') }}">

        <x-tab.tabview class="shadow pb-10">

            <x-slot name="header">
                <x-tab.header tab="1" title="{{ __('Push notification setting(Firebase)') }}" />
                <x-tab.header tab="2" title="{{ __('Web App Settings') }}" />
                <x-tab.header tab="3" title="{{ __('Privacy Policy') }}" />
                <x-tab.header tab="4" title="{{ __('Contact Info') }}" />
                <x-tab.header tab="5" title="{{ __('Terms & Condition') }}" />
                <x-tab.header tab="6" title="{{ __('Page Setting') }}" />
                <x-tab.header tab="7" title="{{ __('Custom Order Notification Messages') }}" />
                <x-tab.header tab="8" title="{{ __('File Upload Limits') }}" />
            </x-slot>

            <x-slot name="body">
                <x-tab.body tab="1">
                    <livewire:settings.notification />
                </x-tab.body>
                <x-tab.body tab="2">
                    <livewire:settings.web-app-settings />
                </x-tab.body>
                <x-tab.body tab="3">
                    <livewire:settings.privacy-policy />
                </x-tab.body>
                <x-tab.body tab="4">
                    <livewire:settings.contact />
                </x-tab.body>
                <x-tab.body tab="5">
                    <livewire:settings.terms />
                </x-tab.body>
                <x-tab.body tab="6">
                    <livewire:settings.page />
                </x-tab.body>
                <x-tab.body tab="7">
                    <livewire:settings.custom-notification-message />
                </x-tab.body>
                <x-tab.body tab="8">
                    <livewire:settings.file-limit />
                </x-tab.body>
            </x-slot>

        </x-tab.tabview>
    </x-baseview>

    @include('layouts.partials.wysisyg')
    <x-loading />
</div>
