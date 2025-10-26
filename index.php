<?php
function solve_quadratic($a, $b, $c) {
    $d = $b*$b - 4*$a*$c;
    if ($d < 0) return null;
    return ['x1' => (-$b + sqrt($d))/(2*$a), 'x2' => (-$b - sqrt($d))/(2*$a)];
}

$a = $_POST['a'] ?? 1;
$b = $_POST['b'] ?? 0;
$c = $_POST['c'] ?? 0;

$result = solve_quadratic($a, $b, $c);
?>
<form method="post">
a: <input name="a" value="<?= $a ?>"><br>
b: <input name="b" value="<?= $b ?>"><br>
c: <input name="c" value="<?= $c ?>"><br>
<input type="submit" value="Решить">
</form>

<?php
if ($result) {
    echo "x1 = {$result['x1']}, x2 = {$result['x2']}";
} else {
    echo "Нет решений";
}
?>
