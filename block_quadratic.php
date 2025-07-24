<?php
declare(strict_types=1);

defined('MOODLE_INTERNAL') || die();

class block_quadratic extends block_base {
    public function init(): void {
        $this->title = get_string('pluginname', 'block_quadratic');
    }
    
    public function get_content(): stdClass {
        global $OUTPUT, $PAGE, $USER, $DB;
        
        if ($this->content !== null) {
            return $this->content;
        }
        
        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';
        
        // Получаем значения из формы
        $a = optional_param('a', null, PARAM_FLOAT);
        $b = optional_param('b', null, PARAM_FLOAT);
        $c = optional_param('c', null, PARAM_FLOAT);
        $solution = '';
        
        // Вводим форму
        $this->content->text .= '
            <form method="post">
                <label>a: <input type="number" name="a" step="any" required value="' . ($a ?? '') . '"></label><br>
                <label>b: <input type="number" name="b" step="any" required value="' . ($b ?? '') . '"></label><br>
                <label>c: <input type="number" name="c" step="any" required value="' . ($c ?? '') . '"></label><br>
                <input type="submit" value="Решить">
            </form>
        ';
        
        // Если есть все коэффициенты то считаем корни
        if ($a !== null && $b !== null && $c !== null) {
            $d = $b * $b - 4 * $a * $c;
            $result = '';
            
            if ($d > 0) {
                $x1 = (-$b + sqrt($d)) / (2 * $a);
                $x2 = (-$b - sqrt($d)) / (2 * $a);
                $result = "x1 = $x1, x2 = $x2";
            } elseif ($d == 0) {
                $x = -$b / (2 * $a);
                $result = "x = $x";
            } else {
                $result = "Корней нет";
            }
            
            //Выводим результат
            $this->content->text .= '<p><strong>Результат: </strong>' . s($result) . '</p>';
                        
            //Сохранение в БД
            $record = new stdClass();
            $record->userid = $USER->id;
            $record->timecreated = time();
            $record->a = $a;
            $record->b = $b;
            $record->c = $c;
            $record->solution = $result;
            
            $DB->insert_record('block_quadratic_history', $record);
        }
        
        //История вычислений
        $url = new moodle_url('/blocks/quadratic/history.php');
        $link = '<p><a href="' . $url . '">История</a></p>';
        $this->content->text .= $link;
        
        $this->content->footer = '';
        
        return $this->content;
    }
}           
