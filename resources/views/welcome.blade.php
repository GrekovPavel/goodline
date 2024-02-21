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
        <div class="min-h-96 text-center p-5 rounded">
            <ul>
                @if(!Auth::check())
                    <li><a href="{{ route('login') }}">Войти в систему</a></li>
                @else
                    <li><a href="{{ route('person') }}">Личная страница</a></li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="">
                            Выйти из аккаунта
                        </button>
                    </form>
                @endif
            </ul>
        </div>
        <div class="bg-stone-200 min-h-96 text-center p-5 rounded">
            <h1 class="text-xl mb-3 ">Новая паста</h1>
            <hr>
            <form class="text-left" action="/store" method="post">
                @csrf
                <div class="mb-3">
                    <p>Название пасты:</p>
                    <input class="w-full bg-gray-300 rounded" type="text" name="title">
                    @error('title')
                    <div class="text-red-800">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content"></label>
                    <textarea class="w-full h-56" name="content"></textarea>
                    @error('content')
                    <div class="text-red-800">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-1 flex">
                    <label class="w-1/2" for="expiration_time">Срок действия пасты: </label>
                    <select class="w-1/2 font-bold" id="expiration_time" name="expiration_time">
                        <option value="">Без ограничений</option>
                        <option value="10">10 Минут</option>
                        <option value="60">1 час</option>
                        <option value="180">3 часа</option>
                        <option value="1440">1 день</option>
                        <option value="10080">1 неделя</option>
                        <option value="43800">1 месяц</option>
                    </select>
                </div>
                <div class="mb-3 flex justify-between">
                    <label class="w-1/2" for="access_paste">Ограничение доступа пасты: </label>
                    <select class="w-1/2 font-bold" id="access_paste" name="access_paste">
                        <option value="public">Доступна всем</option>
                        <option value="unlisted">Доступна только по ссылке</option>
                        @if(Auth::check())
                            <option value="private">Доступна только мне</option>
                        @endif
                    </select>
                </div>
                <button type="submit" class="mt-auto flex-shrink-0 rounded-md pt-2 pb-2 pl-4 pr-4 bg-green-400">Создать
                </button>
            </form>
        </div>
        <div>
            <div class="ml-2 overflow-auto w-80 bg-stone-200 min-h-96 max-h-96  text-center p-5 rounded text-center border-l-2 border-gray-500">
                <h2 class="text-lg mb-5">Опубликованные последние пасты</h2>
                @if(isset($posts))
                    @foreach($posts as $item)
                        <div class="mb-3 text-left border-b-2 border-gray-300">
                            <div class="">
                                <a class="text-teal-500" href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                                <p>Пользователь: <b>{{ $item['user_name'] }}</b></p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Ни одной пасты не создано</p>
                @endif
            </div>
        </div>
        @if(Auth::check())
            <div>
                <div class="ml-2 overflow-auto w-80 bg-stone-200 min-h-96 max-h-96  text-center p-5 rounded text-center border-l-2 border-gray-500">
                    <h2 class="text-lg mb-5">Мои пасты</h2>

                        @if(isset($userPosts))
                            @foreach($userPosts as $item)
                                <div class="mb-3 text-left border-b-2 border-gray-300">
                                    <div class="">
                                        <a class="text-teal-500" href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                                        <p>Пользователь: <b>{{ $item['user_name'] }}</b></p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Ни одной моей пасты не создано</p>
                        @endif
                </div>
            </div>
        @endif
    </div>
</body>
</html>
