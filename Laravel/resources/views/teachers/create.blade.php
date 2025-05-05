@extends('layouts.app')

@section('content')
    <h1>Додати викладача</h1>

    <form method="POST" action="{{ route('teachers.store') }}">
        @csrf
        <label>Ім'я:
            <input type="text" name="name" required>
        </label><br>

        <label>Email:
            <input type="email" name="email" required>
        </label><br>

        <button type="submit">Зберегти</button>
    </form>
@endsection
