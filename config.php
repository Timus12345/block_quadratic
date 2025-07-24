<?php
unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle';
$CFG->dbuser    = 'moodleuser';
$CFG->dbpass    = 'Vava2023!';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = ['dbpersist' => 0, 'dbport' => '', 'dbsocket' => '', 'dbcollation' => 'utf8mb4_unicode_ci'];

$CFG->wwwroot   = 'http://localhost'; // замени на свой URL, если нужно
$CFG->dataroot  = '/var/moodledata'; // папка с данными Moodle, должна быть доступна и с правами
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');
