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
                                <h3 class="text-center"><strong>Change Password</strong></h3>
                                <form method="POST" action="{{ route('password.updated') }}">
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
                                        <label for="otp"
                                            class="form-label col-form-label-sm m-0">{{ __('OTP') }}</label>
                                        <input id="otp" type="text"
                                            class="form-control @error('otp') is-invalid @enderror" name="otp"
                                            value="{{ old('otp') }}" placeholder="Enter OTP" required>
                                        @error('otp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="my-3">
                                        <label for="password" class="mb-0 form-label col-form-label-sm">Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" placeholder="Enter password" required type="password" required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="my-3">
                                        <label for="confirm_password" class="mb-0 form-label col-form-label-sm">Confirm
                                            Password</label>
                                        <input class="form-control @error('confirm_password') is-invalid @enderror"
                                            id="confirm_password" name="confirm_password"
                                            placeholder="Enter password confirmation" required type="password" required>
                                        @error('confirm_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="my-4 text-center">
                                        <button type="submit" class="btn btn-lg btn-bjb px-3 rounded-partner w-100"
                                            style="font-weight: 800;font-size: 15px">
                                            {{ __('Change Password') }}
                                        </button>
                                    </div>

                                    <a href="{{ route('login') }}" class="float-end text-white">
                                        {{ __('Back to Login') }}
                                    </a>
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
