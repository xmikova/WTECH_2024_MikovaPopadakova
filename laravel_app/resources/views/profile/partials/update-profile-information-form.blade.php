@php use Illuminate\Contracts\Auth\MustVerifyEmail; @endphp
@section('customCss')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
@endsection

<section class="login-container">
    <header>
        <h3 class="text-lg font-medium text-gray-900">
            {{ __('Osobné údaje') }}
        </h3>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Tu môžete zmeniť svoje meno alebo emailovú adresu.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-text-input class="form-control me-3" id="name" name="name" type="text"
                          :value="old('name', Auth::user()->name)" required autofocus autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div class="mb-3">
            <x-text-input class="form-control me-3" id="email" name="email" type="email"
                          :value="old('email', Auth::user()->email)" required autocomplete="username"/>
            <x-input-error class="mt-2" :messages="$errors->get('email')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-dark text-center">{{ __('Uložiť') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
