<?php 

// =======================
// = Component Registery =
// =======================

$kirby->set('blueprint', 'mailman', __DIR__ . '/blueprints/mailman.yml');
$kirby->set('controller', 'mailman', __DIR__ . '/controllers/mailman.php');
$kirby->set('template', 'mailman', __DIR__ . '/templates/mailman.php');
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

