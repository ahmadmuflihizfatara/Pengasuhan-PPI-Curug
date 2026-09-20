<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }
.app-layout { display: block; min-height: 100vh; }
.main-content { padding: 28px 28px 28px 24px; min-width: 0; max-width: 80rem; margin: 0 auto; width: 100%; }
.profile-title { font-size: 22px; font-weight: 800; color: #333; margin: 0 0 4px 0; }
.profile-subtitle { font-size: 13px; color: #888; margin: 0 0 24px 0; }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<div class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        <h1 class="profile-title"><i class="fas fa-user-circle" style="color:#764ba2; margin-right:10px;"></i>{{ __('Profile') }}</h1>
        <p class="profile-subtitle">Update your account's profile information and email address.</p>

        <div class="space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
