@extends('layouts.app')

@section('title')
    Login
@endsection

@section('content')
    <div class="container">
        <div class="d-flex align-items-center justify-content-center" style="height: 100svh;">
            <div class="col-12 col-lg-8">
                <div class="card elevation-3 rounded-partner">
                    <div class="card-body w-100 py-0 px-2">
                        <div class="row h-100">
                            <div class="col-12 col-md-6 my-auto text-center py-3">
                                <img src="{{ asset('assets/logo/main.png') }}" alt="logo_bjb" style="width: 75%">
                            </div>
                            <div class="col-12 col-md-6 px-5 py-5 bg-primary rounded-partner m-0">
                                <h3 class="text-center"><strong>Login</strong></h3>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="my-3">
                                        <label for="name"
                                            class="form-label col-form-label-sm m-0">{{ __('Name') }}</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="my-3">
                                        <label for="password"
                                            class="form-label col-form-label-sm m-0">{{ __('Password') }}</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row mb-4 text-center">
                                        <div class="col-6">
                                            <div class="icheck-primary">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label for="remember">
                                                    {{ __('Ingat Saya') }}
                                                </label>
                                            </div>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <div class="col-6">
                                                <a href="{{ route('password.request') }}" class="float-end text-white">
                                                    {{ __('Lupa Password?') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-bjb px-3 rounded-partner w-100"
                                            style="font-weight: 800;font-size: 15px">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-bjb mt-3" style="height: 20px;width: 100%"></div>
            </div>
        </div>
    </div>
@endsection
