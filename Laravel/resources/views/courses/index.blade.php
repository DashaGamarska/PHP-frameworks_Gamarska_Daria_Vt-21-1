@extends('layouts.app')
@section('content')
    <h1>Список Courses</h1>

    <form method="GET">
        <input type="text" name="name" placeholder="Назва курсу" value="{{ request('name') }}">
        <input type="number" name="itemsPerPage" min="1" value="{ request('itemsPerPage', 10) }">
        <button type="submit">Фільтрувати</button>
    </form>

    <a href="{ route('courses.create') }">+ Додати</a>
    <ul>
        @foreach ($items as $item)
            <li>
                { $item->id } —
                <a href="{ route('courses.edit', $item->id) }">Редагувати</a> |
                <a href="{ route('courses.show', $item->id) }">Деталі</a> |
                <form action="{ route('courses.destroy', $item->id) }" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Видалити</button>
                </form>
            </li>
        @endforeach
    </ul>

    { $items->appends(request()->query())->links() }
@endsection
