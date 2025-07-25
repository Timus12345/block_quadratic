<?php
declare(strict_types=1);

require('../../config.php');
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/quadratic/history.php'));
$PAGE->set_title(get_string('history', 'block_quadratic'));
$PAGE->set_heading(get_string('history', 'block_quadratic'));

echo $OUTPUT->header();

global $DB, $USER;

// Получаем все записи текущего пользователя
$records = $DB->get_records('block_quadratic_history', ['userid' => $USER->id], 'timecreated DESC');

if ($records) {
    echo html_writer::start_tag('table', ['class' => 'generaltable']);
    echo html_writer::start_tag('tr');
    echo html_writer::tag('th', 'a');
    echo html_writer::tag('th', 'b');
    echo html_writer::tag('th', 'c');
    echo html_writer::tag('th', 'Решение');
    echo html_writer::tag('th', 'Дата');
    echo html_writer::end_tag('tr');

    foreach ($records as $record) {
        echo html_writer::start_tag('tr');
        echo html_writer::tag('td', $record->a);
        echo html_writer::tag('td', $record->b);
        echo html_writer::tag('td', $record->c);
        echo html_writer::tag('td', s($record->result));
        echo html_writer::tag('td', userdate($record->timecreated));
        echo html_writer::end_tag('tr');
    }

    echo html_writer::end_tag('table');
} else {
    echo html_writer::tag('p', 'История пуста.');
}

echo $OUTPUT->footer();
