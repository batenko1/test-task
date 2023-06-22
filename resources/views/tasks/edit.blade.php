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

<form action="{{ route('tasks.update', $task->id) }}" method="post">
    {{ csrf_field() }}

    @method('PATCH')

    <input type="text" name="title" required value="{{ $task->id }}">
    <input type="text" name="body" required value="{{ $task->body }}">
    <select name="executor_id" id="" required>
        @foreach($users as $user)
            <option @if($user->id == $task->executor_id) selected @endif value="{{ $user->id }}">{{ $user->email }}</option>
        @endforeach

    </select>
    <input type="text" name="days" required value="{{ $task->days }}">
    <input type="date" name="date_end" required value="{{ \Carbon\Carbon::parse($task->date_end)->format('Y-m-d') }}">

    <input type="submit" name="submit">
</form>

</body>
</html>
