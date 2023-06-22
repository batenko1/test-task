<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="{{ route('tasks.store') }}" method="post">
    {{ csrf_field() }}
    <input type="text" name="title" required>
    <input type="text" name="body" required>
    <select name="executor_id" id="" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->email }}</option>
        @endforeach

    </select>
    <input type="text" name="days" required>
    <input type="date" name="date_end" required>

    <input type="submit" name="submit">
</form>

</body>
</html>
