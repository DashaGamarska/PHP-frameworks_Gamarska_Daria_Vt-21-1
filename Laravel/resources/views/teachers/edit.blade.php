@extends('layouts.app')

@section('content')
    <h1>Редагування викладача</h1>

    <form method="POST" action="{{ route('teachers.update', $item->id) }}">
        @csrf
        @method('PUT')

        <label>Ім'я:
            <input type="text" name="name" value="{{ $item->name ?? '' }}" required>
        </label><br>

        <label>Email:
            <input type="email" name="email" value="{{ $item->email ?? '' }}" required>
        </label><br>

        <button type="submit">Оновити</button>
    </form>
@endsection
