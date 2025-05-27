<x-guest-layout>
    <div id="login-container" class="block">
        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-button class="ml-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="#" id="show-register" class="underline text-gray-900 hover:text-indigo-500">
                        {{ __('Register now') }}
                    </a>
                </p>
            </div>
        </div>

        <div id="register-container" class="hidden">
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>


                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    {{ __('Already have an account?') }}
                    <a href="#" id="show-login" class="underline text-gray-900 hover:text-indigo-500">
                        {{ __('Login') }}
                    </a>
                </p>
            </div>
        </div>

        <script>
           document.addEventListener('DOMContentLoaded', function() {
              const loginContainer = document.getElementById('login-container');
              const registerContainer = document.getElementById('register-container');
              const showRegisterLink = document.getElementById('show-register');
              const showLoginLink = document.getElementById('show-login');

              showRegisterLink.addEventListener('click', function(e) {
                 e.preventDefault();
                 loginContainer.classList.add('hidden');
                 registerContainer.classList.remove('hidden');
              });

              showLoginLink.addEventListener('click', function(e) {
                 e.preventDefault();
                 registerContainer.classList.add('hidden');
                 loginContainer.classList.remove('hidden');
              });
           });
        </script>
</x-guest-layout>
