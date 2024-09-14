<x-app-layout>
    <div class="bg-white w-full text-sm py-5 px-7">
        <h2 class="w-fit font-bold text-2xl text-gray-800 border-b-[3px] border-[#9db3bf] pb-1 ">
            {{ __('translate.profile') }}
        </h2>
    </div>

    <div class="bg-[#ffffff]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
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

            @can('Admin')
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout>