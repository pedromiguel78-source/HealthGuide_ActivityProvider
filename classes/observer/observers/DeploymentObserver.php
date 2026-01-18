<?php
// classes/observer/observers/DeploymentObserver.php

require_once __DIR__ . '/../Observer.php';
require_once __DIR__ . '/../../SingletonDB.php';

/**
 * Observer concreto: regista que houve deploy/ativação de instância.
 */
class DeploymentObserver implements Observer {
    private SingletonDB $db;

    public function __construct(SingletonDB $db) {
        $this->db = $db;
    }

    public function update(string $eventName, array $context = []): void {
        $activityID = $context['activityID'] ?? 'default';
        $this->db->incrementMetric($activityID, 'deploy_count', 1);
    }
}
