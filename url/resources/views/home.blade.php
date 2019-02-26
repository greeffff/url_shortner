<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>URl Сокращалка</title>
<link rel="stylesheet" href="{{ URL::to('css/global.css') }}">
</head>

<body>
<div class="block_1">
<h1 class="zagolovok">URL Сокращалка</h1>
@if($errors->has('url'))
	<p>{{ $errors->first('url') }}</p>
@endif
@if (Session::has('global'))
             <p>{!! Session::get('global') !!}</p>
         @endif
<form action="{{ URL::action('LinkController@make') }}" method="post">{{ csrf_field() }}
<input type="url" name="url" id="url_for_short" placeholder="Введите ссылку" autocomplete="off">
<input type="submit" value="Сократить">
</form>
</div>
</body>
</html>