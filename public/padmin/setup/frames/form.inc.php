<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Form edit view
 *
 * @package PhpMyAdmin-Setup
 */

if (!defined('PHPMYADMIN')) {
    exit;
}

/**
 * Core libraries.
 */
require_once './libraries/config/Form.class.php';
require_once './libraries/config/FormDisplay.class.php';
require_once './setup/lib/form_processing.lib.php';

require './libraries/config/setup.forms.php';

$formset_id = PMA_isValid($_GET['formset'], 'scalar') ? $_GET['formset'] : null;
$mode = isset($_GET['mode']) ? $_GET['mode'] : null;
if (! isset($forms[$formset_id]) || substr($formset_id, 0, 1) === '_') {
    PMA_fatalError(__('Incorrect formset, check $formsets array in setup/frames/form.inc.php!'));
}

if (isset($GLOBALS['strConfigFormset_' . $formset_id])) {
    echo '<h2>' . $GLOBALS['strConfigFormset_' . $formset_id] . '</h2>';
}
$form_display = new FormDisplay($GLOBALS['ConfigFile']);
foreach ($forms[$formset_id] as $form_name => $form) {
    $form_display->registerForm($form_name, $form);
}
PMA_Process_formset($form_display);
