@extends('layouts.layout')

@section('styles')
    @vite(['resources/css/auth.css'])
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        
        <!-- Login -->
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
            <form id="formAuthentication" class="login mb-3" method="POST" action="{{ route('login') }}">
            @csrf
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="email" name="email" placeholder="Insira seu email" autofocus>
                <label for="email">Email</label>
              </div>
              <div class="mb-3">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="password" class="form-control" name="password" placeholder="Insira sua senha" aria-describedby="password" />
                      <label for="password">Senha</label>
                    </div>
                    <span class="input-group-text cursor-pointer" id="togglePassword"><i class="mdi mdi-eye-off-outline"></i></span>
                  </div>
                </div>
              </div>
              <div class="mb-3 d-flex justify-content-between">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="rememberPasswordCheck" value="{{ old('remember') ? 'checked' : '' }}">
                  <label class="form-check-label" for="rememberPasswordCheck">
                    Lembrar-se
                  </label>
                </div>
                <a href="#" class="float-end mb-1">
                  <span>Esqueceu a senha?</span>
                </a>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
              </div>
            </form>
  
            <p class="text-center">
              <span>É novo na plataforma?</span>
              <a href="{{ route('register') }}">
                <span>Crie sua conta</span>
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