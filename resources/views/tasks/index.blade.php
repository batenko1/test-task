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


<style>
    table {
        width:100%;
    }

    td, th {
        border:1px solid #ccc;
        text-align: center;
    }

    .pagination li {
        display: inline-block;
        vertical-align: middle;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }
</style>
<a href="{{ route('tasks.create') }}">Создать задачу</a>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Заголовок задачи</th>
        <th scope="col">Тело задачи</th>
        <th scope="col">Создатель</th>
        <th scope="col">Исполнитель</th>
        <th scope="col">Дата добавления</th>
        <th scope="col">Дата обновления</th>
        <th scope="col">Срок в днях</th>
        <th scope="col">Дата окончания срока</th>
        <th scope="col">Статус</th>
        <th>Редактирование</th>
        <th>Удаление</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td scope="row">{{ $task->title }}</td>
            <td>{{ $task->body }}</td>
            <td>{{ $task->user->email }}</td>
            <td>{{ $task->executor->email }}</td>
            <td>{{ $task->created_at }}</td>
            <td>{{ $task->updated_at }}</td>
            <td>{{ $task->days }}</td>
            <td>{{ $task->date_end }}</td>
            <td>{{ \Carbon\Carbon::parse($task->date_end) > now() ? 'Просрочено' : 'Активно' }}</td>
            <td>
                @if(Gate::allows('edit', $task))
                    <a href="{{ route('tasks.edit', $task->id) }}">Редактировать</a>
                @else
                    Нет прав
                @endif
            </td>
            <td>
                @if(Gate::allows('delete', $task))
                <form method="post" action="{{ route('tasks.destroy', $task->id) }}">
                    @csrf
                    @method('delete')
                    <input type="submit" name="submit" value="Удалить">
                </form>
                @else
                    Нет прав
                @endif
            </td>
        </tr>
    @endforeach



    </tbody>
</table>
{{ $tasks->links() }}

</body>
</html>
