@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Đăng Ký Tài Khoản
                    </h2>
                </div>

                <div>{{ $data }}</div>
                                
                <form class="mt-8 space-y-6" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label for="first_name" class="sr-only">Họ</label>
                            <input id="first_name" name="first_name" type="text" required 
                                   class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('first_name') border-red-500 @enderror" 
                                   placeholder="Họ" value="{{ old('first_name') }}">
                        </div>
                        <div>
                            <label for="last_name" class="sr-only">Tên</label>
                            <input id="last_name" name="last_name" type="text" required 
                                   class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('last_name') border-red-500 @enderror" 
                                   placeholder="Tên" value="{{ old('last_name') }}">
                        @error('last_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror" 
                               placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        
                    </div>

                    <div>
                        <button type="submit" 
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Đăng Ký
                        </button>
                    </div>
                </form>
            </div>
        </div>
@endsection