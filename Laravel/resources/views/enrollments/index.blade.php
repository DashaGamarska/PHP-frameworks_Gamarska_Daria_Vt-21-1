@extends('layouts.app')
@section('content')
    <h1>Список Enrollments</h1>

    <form method="GET">
        <input type="text" name="student_id" placeholder="ID студента" value="{{ request('student_id') }}">
        <input type="text" name="course_id" placeholder="ID курсу" value="{{ request('course_id') }}">
        <input type="number" name="itemsPerPage" min="1" value="{ request('itemsPerPage', 10) }">
        <button type="submit">Фільтрувати</button>
    </form>

    <a href="{ route('enrollments.create') }">+ Додати</a>
    <ul>
        @foreach ($items as $item)
            <li>
                { $item->id } —
                <a href="{ route('enrollments.edit', $item->id) }">Редагувати</a> |
                <a href="{ route('enrollments.show', $item->id) }">Деталі</a> |
                <form action="{ route('enrollments.destroy', $item->id) }" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Видалити</button>
                </form>
            </li>
        @endforeach
    </ul>

    { $items->appends(request()->query())->links() }
@endsection
