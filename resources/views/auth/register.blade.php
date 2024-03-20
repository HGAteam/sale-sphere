@extends('auth.base')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-10">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="ec-brand">
                        <a href="{{route('welcome')}}" title="Ekka">
                            <img class="ec-brand-icon" src="{{ asset('admin/assets/img/logo/logo-login.png') }}"
                                alt="" />
                        </a>
                    </div>
                </div>
                <div class="card-body p-5">
                    <h4 class="text-dark mb-5">{{ __('Sign Up') }}</h4>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12 mb-4">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="User Name"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 mb-4">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}"
                                    required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 ">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 ">
                                <input id="password-confirm" type="password" class="form-control"
                                    placeholder="Confirm Password" name="password_confirmation" required
                                    autocomplete="new-password">
                            </div>

                            <div class="col-md-12">
                                <div class="d-inline-block mr-3">
                                    <div class="control control-checkbox">
                                        <label>
                                            <input type="checkbox" />
                                            <div class="control-indicator"></div>
                                            {{ __('I Agree the terms and conditions') }}
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block mb-4">{{ __('Sign Up') }}</button>

                                <p class="sign-upp">{{ __('Already have an account?') }}
                                    <a class="text-blue" href="{{ __('login') }}">{{ __('Sign in') }}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
