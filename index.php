<?php
// === Функция решения квадратного уравнения ===
function solve_quadratic($a, $b, $c) {
    $d = $b*$b - 4*$a*$c;
    if ($d < 0) return null;
    return [
        'x1' => (-$b + sqrt($d)) / (2 * $a),
        'x2' => (-$b - sqrt($d)) / (2 * $a)
    ];
}

// === Чтение данных из формы ===
$a = $_POST['a'] ?? '';
$b = $_POST['b'] ?? '';
$c = $_POST['c'] ?? '';
$result = null;
$message = '';

// === Вычисление ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($a === '' || $b === '' || $c === '') {
        $message = "Пожалуйста, заполните все поля.";
    } else {
        $result = solve_quadratic($a, $b, $c);
        if ($result) {
            $message = "x₁ = {$result['x1']}, x₂ = {$result['x2']}";
        } else {
            $message = "Нет вещественных решений.";
        }

        // === Сохраняем результат в файл внутри volume ===
        $dataDir = __DIR__ . '/data';
        if (!file_exists($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        $logFile = $dataDir . '/results.txt';
        $logEntry = date('Y-m-d H:i:s') . " | a=$a, b=$b, c=$c | $message\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Решение квадратного уравнения</title>
    <style>
        body { font-family: Arial; margin: 50px; background: #f5f5f5; }
        form { background: white; padding: 20px; border-radius: 12px; width: 320px; }
        input { margin: 5px 0; width: 100%; padding: 8px; }
        button { margin-top: 10px; padding: 10px; width: 100%; background: #007bff; color: white; border: none; border-radius: 8px; }
        .message { margin-top: 20px; padding: 10px; background: #e9ecef; border-radius: 8px; }
    </style>
</head>
<body>

<h2>Решение квадратного уравнения</h2>

<form method="post">
    <label>a:</label>
    <input type="number" name="a" step="any" value="<?= htmlspecialchars($a) ?>">
    <label>b:</label>
    <input type="number" name="b" step="any" value="<?= htmlspecialchars($b) ?>">
    <label>c:</label>
    <input type="number" name="c" step="any" value="<?= htmlspecialchars($c) ?>">
    <button type="submit">Решить</button>
</form>

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<p><a href="data/results.txt" target="_blank">Посмотреть историю решений</a></p>

</body>
</html>
