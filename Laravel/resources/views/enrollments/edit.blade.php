
@extends('layouts.app')

@section('content')
<h1>Редагування запису</h1>
<form method="POST" action="{{ route('enrollments.update', $item->id) }}">
    @csrf
    @method('PUT')
    <label>Студент:
        <input type="number" name="student_id" value="{{ $item->student_id }}" required>
    </label><br>
    <label>Курс:
        <input type="number" name="course_id" value="{{ $item->course_id }}" required>
    </label><br>
    <button type="submit">Оновити</button>
</form>
@endsection
