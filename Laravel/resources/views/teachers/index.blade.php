@extends('layouts.app')
@section('content')
    <h1>Список Teachers</h1>

    <form method="GET">
        <input type="text" name="name" placeholder="Ім'я" value="{{ request('name') }}">
        <input type="text" name="email" placeholder="Email" value="{{ request('email') }}">
        <input type="number" name="itemsPerPage" min="1" value="{ request('itemsPerPage', 10) }">
        <button type="submit">Фільтрувати</button>
    </form>

    <a href="{ route('teachers.create') }">+ Додати</a>
    <ul>
        @foreach ($items as $item)
            <li>
                { $item->id } —
                <a href="{ route('teachers.edit', $item->id) }">Редагувати</a> |
                <a href="{ route('teachers.show', $item->id) }">Деталі</a> |
                <form action="{ route('teachers.destroy', $item->id) }" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Видалити</button>
                </form>
            </li>
        @endforeach
    </ul>

    { $items->appends(request()->query())->links() }
@endsection
