<section>
    <header>
        <h3 class="text-lg font-medium text-gray-900">
            {{ __('Zmena hesla') }}
        </h3>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Pre zabezpečenie účtu používajte dostatočne dlhé a komplexné heslo') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-3">
            <x-text-input class="form-control me-3" id="update_password_current_password" placeholder="Aktuálne heslo"  name="current_password" type="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-text-input class="form-control me-3" id="update_password_password" placeholder="Nové heslo" name="password" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-text-input class="form-control me-3" id="update_password_password_confirmation" placeholder="Potvrďte heslo"  name="password_confirmation" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-dark text-center">{{ __('Uložiť') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Zmena uložená.') }}</p>
            @endif
        </div>
    </form>
</section>
