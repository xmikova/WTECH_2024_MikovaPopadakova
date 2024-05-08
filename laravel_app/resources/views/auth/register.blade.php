@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/registration.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="title-header mt-5">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h4>Registrácia</h4>
                </div>
            </div>
        </div>
    </section>

    <section class="registration-container mt-5 mb-5 col-md-6 mx-auto">
        <div class="container row mb-3 justify-content-center">
            <div class="col-md-6 mx-auto">
                <div class="mt-3">
                    <div class="mt-3">
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <x-text-input id="name" class="form-control me-3" placeholder="Meno" type="name" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <x-text-input id="email" class="form-control me-3" placeholder="Email" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <x-text-input id="password" class="form-control me-3"
                                              placeholder="Heslo"
                                              type="password"
                                              name="password"
                                              required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <x-text-input id="password_confirmation" class="form-control me-3"
                                              placeholder="Potvrďte heslo"
                                              type="password"
                                              name="password_confirmation" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="buyNow ms-lg-3 ">
                                <x-primary-button type="submit" class="btn btn-dark text-center">
                                    {{ __('Registrovať sa') }}
                                </x-primary-button>
                            </div>

                            <div class="flex items-center justify-end mt-4 text-center">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                                    {{ __('Máte už účet?') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
