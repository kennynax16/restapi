<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Vue App</title>
    <!-- Подключаем стили (если нужны) -->
    @vite('resources/css/app.css')
</head>
<body>
<!-- Точка монтирования Vue -->
<div id="app"></div>

<!-- Подключаем JS-бандл, собранный Vite -->
@vite('resources/js/app.js')
</body>
</html>
