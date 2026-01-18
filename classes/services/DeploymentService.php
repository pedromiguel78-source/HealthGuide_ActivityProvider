<?php
// classes/services/DeploymentService.php

require_once __DIR__ . '/../SingletonDB.php';
require_once __DIR__ . '/../observer/ActivityEventBus.php';

class DeploymentService {
    private SingletonDB $db;
    private ?ActivityEventBus $eventBus;

    public function __construct(SingletonDB $db, ?ActivityEventBus $eventBus = null) {
        $this->db = $db;
        $this->eventBus = $eventBus;
    }

    public function deploy(string $activityID, string $host): array {
        $this->db->createInstance($activityID);

        // Notifica observers (padrão Observer) que foi efetuado deploy/ativação da instância
        if ($this->eventBus) {
            $this->eventBus->notify('DEPLOYED', [
                'activityID' => $activityID
            ]);
        }

        return [
            "status" => "success",
            "message" => "Instância criada (via Facade + Singleton)",
            "activityID" => $activityID,
            "url" => "http://" . $host . "/guia-healthguide?activityID=" . rawurlencode($activityID)
        ];
    }
}
