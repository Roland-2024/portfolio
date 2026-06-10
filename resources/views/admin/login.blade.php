<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Admin Login | Roland Portfolio</title><link rel="stylesheet" href="{{ asset('admin.css') }}"></head>
<body class="login-page">
<main class="login-card">
    <h1>Portfolio Dashboard</h1>
    <p class="muted">Sign in to manage the website content.</p>
    @if($errors->any())<div class="alert error">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <label>Email<input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
        <label>Password<input type="password" name="password" required></label>
        <label class="check"><input type="checkbox" name="remember" value="1"> Remember me</label>
        <button class="btn" type="submit">Sign in</button>
    </form>
</main>
</body>
</html>
