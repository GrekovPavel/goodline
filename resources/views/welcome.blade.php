<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite('resources/css/app.css')

</head>
<body class="bg-slate-100">
    <div class="flex items-center justify-center h-screen p-3">
        <div class="bg-stone-200 min-h-96 text-center p-5 rounded">
            <h1 class="text-xl mb-3 ">Новая паста</h1>
            <hr>
            <form class="text-left" action="/store" method="post">
                @csrf
                <div class="mb-3">
                    <label for="pasteTextarea"></label>
                    <textarea class="w-full h-56" name="pasteTextarea"></textarea>
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
                    </select>
                </div>
                <button type="submit" class="mt-auto flex-shrink-0 rounded-md pt-2 pb-2 pl-4 pr-4 bg-green-400">Создать
                </button>
            </form>
        </div>
        <div class="ml-2 w-80 bg-stone-200 min-h-96 text-center p-5 rounded text-center border-l-2 border-gray-500">
            <h2 class="text-lg mb-5">Опубликованные пасты</h2>
            <div class="mb-3 text-left">
                <div class="">
                    <p>Название</p>
                    <p>Автор</p>
                </div>
            </div>
            <div class="mb-3 text-left">
                <div class="">
                    <p>Название</p>
                    <p>Автор</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
