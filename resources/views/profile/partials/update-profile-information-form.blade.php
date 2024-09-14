<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('translate.profileInfo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('translate.updateAcc') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        @can('admin')
        <div>
            <x-input-label for="name" :value="__('translate.name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('translate.email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('translate.yourEmail') }}
                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('translate.resendCode') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('translate.newCodeSend') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('translate.save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
        @elsecan('user')
        <div>
            <x-input-label for="name" :value="__('translate.name')" />
            <input id="name" type="text" class="mt-1 block w-full w-full border-gray-300 rounded-lg" value="{{ old('name', $user->name) }}" @disabled(Auth()->user()->usertype !== 'Admin')>
        </div>
        <div>
            <x-input-label for="email" :value="__('translate.email')" />
            <input id="email" type="email" class="mt-1 block w-full w-full border-gray-300 rounded-lg" value="{{ old('email', $user->email) }}" @disabled(Auth()->user()->usertype !== 'Admin')>
        </div>
        @endcan

    </form>
</section>