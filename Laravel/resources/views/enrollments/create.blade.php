
@extends('layouts.app')

@section('content')
<h1>Додати запис</h1>
<form method="POST" action="{{ route('enrollments.store') }}">
    @csrf
    <label>Студент:
        <input type="number" name="student_id" required>
    </label><br>
    <label>Курс:
        <input type="number" name="course_id" required>
    </label><br>
    <button type="submit">Зберегти</button>
</form>
@endsection
