<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }
.profile-title { font-size: 22px; font-weight: 800; color: #333; margin: 0 0 4px 0; }
.profile-subtitle { font-size: 13px; color: #888; margin: 0 0 24px 0; }
</style>

<div class="app-layout">
    <x-sidebar active="profile" />

    <div class="main-content">
        <h1 class="profile-title"><i class="fas fa-user-circle" style="color:#12283a; margin-right:10px;"></i>{{ __('Profile') }}</h1>
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
