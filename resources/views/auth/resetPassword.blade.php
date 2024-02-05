<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
</head>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<section class="bg-gray-50 ">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 ">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-center text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                    Reset Password
                </h1>
                {{-- @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('status'))
                    <div class="">
                        <ul>
                            <li>{{ session()->get('status') }}</li>
                        </ul>
                    </div>
                @endif --}}
                <form class="space-y-4 md:space-y-6" action="{{ Route('password.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ request()->token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">
                    <div class="mb-5">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                        <input type="password" name="password" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                            placeholder="Password" required="">
                        @error('password')
                        <p class="invalid-message text-red-700">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                            placeholder="Password Confirmation" required="">
                        @error('password_confirmation')
                        <p class="invalid-message text-red-700">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="text-blue-500 underline hover:text-blue-800">
                        <a href="{{ Route('login') }}">Login now !</a>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Forget
                        Password</button>
                </form>
            </div>
        </div>
    </div>
</section>

@yield('script')

</body>

</html>
