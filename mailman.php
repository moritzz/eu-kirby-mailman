<?php 

// =======================
// = Component Registery =
// =======================

// $kirby->set('template', 'calendar', __DIR__ . '/templates/calendar.php');
// $kirby->set('blueprint', 'calendar', __DIR__ . '/blueprints/calendar.php');
$kirby->set('snippet', 'mailman', __DIR__ . '/snippets/mailman.php');

// =======================
// = Plugin Routes =
// =======================

/* 
$kirby->set('route', array(
    'pattern' => 'calendar/timezones',
    'action' => function () {
      return new Response(snippet('timezones', array(), true));
    }
));
*/

// ==========================
// = Load Library Compoents =
// ==========================

// require_once(__DIR__ . '/lib/iCalcreator/iCalcreator.php');

// ===================
// = Model Registery =
// ===================

/* 
require_once(__DIR__ . '/models/CalendarPage.php');
$kirby->set('page::model', 'calendar', 'CalendarPage');
*/

