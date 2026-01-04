<?php
// classes/services/AnalyticsService.php

require_once __DIR__ . '/../SingletonDB.php';

class AnalyticsService {
    private SingletonDB $db;

    public function __construct(SingletonDB $db) {
        $this->db = $db;
    }

    /**
     * Processa o POST /analytics-healthguide
     * - valida activityID
     * - obtém dados do guia
     * - devolve payload de analytics
     */
    public function buildAnalyticsResponse(array $payload): array {
        $activityID = $payload['activityID'] ?? null;
        if (!$activityID) {
            throw new InvalidArgumentException("activityID required");
        }

        $guideData = $this->db->accessData($activityID);
        if (!$guideData) {
            throw new RuntimeException("activityID not found");
        }

        // Exemplo simples 
        return [
            "activityID" => $activityID,
            "guideData" => $guideData,
            "analytics" => [
                "acessoAoGuia" => true,
                "numeroDeAcessos" => 1,
                "scoreEngagement" => 15
            ]
        ];
    }
}

