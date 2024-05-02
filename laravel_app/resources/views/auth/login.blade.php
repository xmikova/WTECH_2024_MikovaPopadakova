@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="title-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h4>Prihlásenie</h4>
                </div>
            </div>
        </div>
    </section>

    <section class="login-container mt-5 mb-5 col-md-6 mx-auto">
             <div class="container row mb-3 justify-content-center">
                 <div class="col-md-6 mx-auto">
                     <div class="mt-3">
                         <div class="mt-3">
                             <x-auth-session-status class="mb-4" :status="session('status')" />
                             <form method="POST" action="{{ route('login') }}">
                                 @csrf
                                 <!-- Email -->
                                 <div class="mb-3">
                                    <x-text-input id="email" class="form-control me-3" placeholder="Email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                 </div>

                                 <!-- Password -->
                                 <div class="mb-3">

                                    <x-text-input id="password" class="block mt-1 w-full"
                                                  class="form-control me-3" placeholder="Heslo"
                                                  type="password"
                                                  name="password"
                                                  required autocomplete="current-password" />

                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Remember Me -->
                                 <div class="mb-3 text-center">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                        <span class="ms-2 text-sm text-gray-600" >{{ __('Zapamätať si ma') }}</span>
                                    </label>
                                </div>

                                 <div class="buyNow ms-lg-3 ">
                                     <x-primary-button class="btn btn-dark text-center">
                                         {{ __('Prihlásiť sa') }}
                                     </x-primary-button>
                                 </div>

                                <div class="flex items-center justify-end mt-4 text-center">
                                    @if (Route::has('password.request'))
                                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                            {{ __('Zabudli ste svoje heslo?') }}
                                        </a>
                                    @endif
                                </div>
                             </form>
                         </div>
                    </div>
                </div>
             </div>
    </section>
@endsection
