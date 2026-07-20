@extends('layouts.app')
@section('title', 'Sign In')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-2xl font-bold text-gray-900">
                Shop<span class="text-indigo-600">Wave</span>
            </a>
            <h2 class="mt-4 text-xl font-semibold text-gray-900">Welcome back</h2>
            <p class="text-sm text-gray-500 mt-1">Sign in to your account</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-300 @enderror">
                    @error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 active:scale-95 transition-all duration-150">
                    Sign In
                </button>
            </form>

            <div class="mt-4 p-3 bg-gray-50 rounded-xl">
                <p class="text-xs text-gray-500 font-medium mb-1">Demo accounts:</p>
                <p class="text-xs text-gray-500">Admin: <code class="bg-gray-100 px-1 py-0.5 rounded">admin@shopwave.com</code> / <code class="bg-gray-100 px-1 py-0.5 rounded">password</code></p>
                <p class="text-xs text-gray-500">Customer: <code class="bg-gray-100 px-1 py-0.5 rounded">customer@shopwave.com</code> / <code class="bg-gray-100 px-1 py-0.5 rounded">password</code></p>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Create one</a>
            </p>
        </div>
    </div>
</div>
@endsection
