@extends('layouts.app')
@section('content')
    <h1>Список Grades</h1>

    <form method="GET">
        <input type="number" step="any" name="score" placeholder="Оцінка" value="{{ request('score') }}">
        <input type="number" name="itemsPerPage" min="1" value="{ request('itemsPerPage', 10) }">
        <button type="submit">Фільтрувати</button>
    </form>

    <a href="{ route('grades.create') }">+ Додати</a>
    <ul>
        @foreach ($items as $item)
            <li>
                { $item->id } —
                <a href="{ route('grades.edit', $item->id) }">Редагувати</a> |
                <a href="{ route('grades.show', $item->id) }">Деталі</a> |
                <form action="{ route('grades.destroy', $item->id) }" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Видалити</button>
                </form>
            </li>
        @endforeach
    </ul>

    { $items->appends(request()->query())->links() }
@endsection
