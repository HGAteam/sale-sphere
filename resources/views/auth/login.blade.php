@extends('auth.base')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="ec-brand justify-content-center">
                        <a href="javascript:void(0)" title="{{ config('app.name') }}">
                            <img class="ec-brand-icon" src="{{ asset('admin/assets/img/logo/logo-login.png') }}"
                                alt="" />
                        </a>
                    </div>
                </div>
                <div class="card-body p-5">
                    <h4 class="text-dark mb-5">{{ __('Sign In') }}</h4>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-12 mb-4">

                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="{{ __('Email Account') }}" name="email" value="{{ old('email') }}"
                                    required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 ">
                                <input id="password" type="password" placeholder="{{ __('Password') }}"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex my-2 justify-content-between">
                                    <div class="d-inline-block mr-3">
                                        <div class="control control-checkbox">
                                            <label>
                                                {{ __('Remember me') }}
                                                <input type="checkbox" name="remember" id="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
                                                <div class="control-indicator"></div>
                                            </label>
                                        </div>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <p>
                                            <a class="text-blue" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        </p>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary btn-block mb-4">{{ __('Sign In') }}</button>

                                <p class="sign-upp">{{ __("Don't have an account yet ?") }}
                                    <a class="text-blue" href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
