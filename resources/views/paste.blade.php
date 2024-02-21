<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">
<div class="flex items-center justify-center h-screen p-3">
    <div class=" min-h-96 text-center p-5 rounded">
        <ul>
            <li><a href="{{ route('index') }}">На главную</a></li>
        </ul>
    </div>

    <div class="bg-stone-200 min-h-96 text-center p-5 rounded">
        <h1 class="text-xl mb-3 ">Моя паста</h1>
        <hr>
        @if(isset($postData))
            <p>Название: {{ $postData['title'] }}</p>
            <p>Содержимое: {{ $postData['content'] }}</p>
        @endif
    </div>

    <div>
        <div class="ml-2 overflow-auto w-80 bg-stone-200 min-h-96 max-h-96  text-center p-5 rounded text-center border-l-2 border-gray-500">
            <h2 class="text-lg mb-5">Опубликованные последние пасты</h2>
            @if(isset($publicPosts))
                @foreach($publicPosts as $item)
                    <div class="mb-3 text-left border-b-2 border-gray-300">
                        <div class="">
                            <a class="text-teal-500" href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                            <p>Неизвестный автор</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Ни одной пасты не создано</p>
            @endif
        </div>
    </div>

</div>

</body>
</html>
