<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

</head>
<body class="antialiased">
<div
    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row align-items-center space-between">
            <img src="{{ asset('assets/img/mp1.jpeg') }}" alt="Mario Pérsico" class="logo"/>
            <h2 class="text-white main-title">Biblioteca Digital</h2>
        </div>

        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2">
                @foreach($ebooks as $ebook)
                    <a href="{{ route('ebook.show', $ebook->id) }}"
                       class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                        <img src="{{ $ebook->photoUrl }}" alt="{{ $ebook->title }}" class="ebook-cover"/>
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                 stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                                <path
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                <span class="underline text-gray-900 dark:text-white">
                                    {{ $ebook->title }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center mt-4">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                 stroke-width="2" viewBox="0 0 24 24" class="w-5 h-5 text-gray-500">
                                <path
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                <span class="text-gray-900 dark:text-white">Descrição</span>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">{{ $ebook->description }}</div>
                        </div>

                        <div class="flex items-center mt-2 sm:justify-end">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                 stroke-width="1" viewBox="0 0 24 24" class="w-5 h-5 text-gray-500">
                                <path
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <div class="ml-4 text-sm leading-7 font-semibold">
                                <span
                                    class="text-gray-900 dark:text-white">{{ $ebook->comments_count }} comentários</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center flex justify-center">
                {{ $ebooks->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
</body>
</html>
