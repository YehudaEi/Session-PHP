<?php

require_once('../lib/SessionClass.php');

SESSION::setSessionName("MyTest");
SESSION::init();

if(!isset(SESSION::$s['test'])) SESSION::$s['test'] = 0;

SESSION::$s['test']++;

var_dump(SESSION::get());
