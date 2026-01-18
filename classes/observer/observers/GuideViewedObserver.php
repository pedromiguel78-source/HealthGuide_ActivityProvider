<?php
// classes/observer/observers/GuideViewedObserver.php

require_once __DIR__ . '/../Observer.php';
require_once __DIR__ . '/../../SingletonDB.php';

/**
 * Observer concreto: regista visualizações do guia (para analytics).
 */
class GuideViewedObserver implements Observer {
    private SingletonDB $db;

    public function __construct(SingletonDB $db) {
        $this->db = $db;
    }

    public function update(string $eventName, array $context = []): void {
        $activityID = $context['activityID'] ?? 'default';
        $this->db->incrementMetric($activityID, 'guide_views', 1);
    }
}
