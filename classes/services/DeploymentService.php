<?php
// classes/services/DeploymentService.php

require_once __DIR__ . '/../SingletonDB.php';

class DeploymentService {
    private SingletonDB $db;

    public function __construct(SingletonDB $db) {
        $this->db = $db;
    }

    public function deploy(string $activityID, string $host): array {
        $this->db->createInstance($activityID);

        return [
            "status" => "success",
            "message" => "Instância criada (via Facade + Singleton)",
            "activityID" => $activityID,
            "url" => "http://" . $host . "/guia-healthguide?activityID=" . rawurlencode($activityID)
        ];
    }
}
