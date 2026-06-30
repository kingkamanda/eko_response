<?php
/**
 * AJAX endpoint: given a state id, return that state's local government areas
 * as JSON. Consumed by the state -> LGA dropdowns on the sign-up and emergency
 * report forms.
 */
require_once __DIR__ . '/classes/State.php';

header('Content-Type: application/json');

$state_id = filter_input(INPUT_POST, 'state', FILTER_VALIDATE_INT);

if (!$state_id) {
    echo json_encode([]);
    exit();
}

$states = new State();
echo json_encode($states->getLocalGovernment($state_id));
