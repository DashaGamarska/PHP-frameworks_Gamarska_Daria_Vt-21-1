
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Система управління студентами</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
</head>
<body>
<header>
    <h1>Home4Students</h1>
    <nav>
        <a href="{{ route('students.index') }}">Студенти</a>
        <a href="{{ route('teachers.index') }}">Викладачі</a>
        <a href="{{ route('courses.index') }}">Курси</a>
        <a href="{{ route('enrollments.index') }}">Записи</a>
        <a href="{{ route('grades.index') }}">Оцінки</a>
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
