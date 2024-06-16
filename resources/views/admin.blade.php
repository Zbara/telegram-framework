<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @vite(['resources/scss/_core.scss'])
</head>
<body>
<div id="app"></div>
</body>
@vite(['resources/admin/app.js'])
</html>
