@extends('layouts.layout')

@section('styles')
    @vite(['resources/css/auth.css'])
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
  
        <!-- Register Card -->
        <div class="card p-2">
          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5">
            <a href="/" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img class="d-block mx-auto" height="70" src={{ Vite::asset('resources/images/Forestfyg.png') }} alt="Forestfy">
              </span>
            </a>
          </div>
          <!-- /Logo -->
          <div class="card-body mt-2">
            @if ($errors->has('invalid'))
              <div class="alert alert-danger" role="alert">
                  @foreach ($errors->get('invalid') as $error)
                      <div>
                          {{$error}}
                      </div>
                  @endforeach
              </div>
            @endif
            <form class="signup mb-3" id="signup_form" method="POST" action="{{ route('register') }}">
              @csrf
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Insira seu nome" autofocus>
                <label for="username">Usuário</label>
                @error('name')
                  <span class="text-error"><strong>{{ $message }}</strong></span>
                @enderror
                {{-- <span class="text-error">{{ form.username.errors }}</span> --}}
              </div>
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="email" name="email" placeholder="Insira seu email">
                <label for="email">Email</label>
                @error('email')
                  <span class="text-error"><strong>{{ $message }}</strong></span>
                @enderror
                {{-- <span class="text-error">{{ form.email.errors }}</span> --}}
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="input-group input-group-merge">
                  <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control" name="password" placeholder="Insira sua senha" aria-describedby="password" />
                    <label for="password">Senha</label>
                  </div>
                  <span class="input-group-text cursor-pointer" id="togglePassword"><i class="mdi mdi-eye-off-outline"></i></span>
                </div>
                @error('password')
                  <span class="text-error"><strong>{{ $message }}</strong></span>
                @enderror
                {{-- <span class="text-error">{{ form.password1.errors }}</span> --}}
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                  <label class="form-check-label" for="terms-conditions">
                    Eu aceito os
                    <a href="#">termos e a poítica de privacidade</a>
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">
                Cadastrar-se
              </button>
            </form>
  
            <p class="text-center">
              <span>Já tem uma conta?</span>
              <a href="{{ route('login') }}">
                <span>Faça seu login</span>
              </a>
            </p>
          </div>
        </div>
        
      </div>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/auth/auth.js'])
@endsection