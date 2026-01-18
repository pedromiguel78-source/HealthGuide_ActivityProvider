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
     * - confirma se existe instância/dados
     * - devolve payload de analytics (alimentado por eventos via Observer)
     */
    public function buildAnalyticsResponse(array $payload): array {
        $activityID = $payload['activityID'] ?? null;

        if (!$activityID) {
            http_response_code(400);
            return ["error" => "activityID required"];
        }

        $guideData = $this->db->accessData($activityID);
        if (!$guideData) {
            http_response_code(404);
            return ["error" => "Activity not found"];
        }

        // Métricas recolhidas durante a execução (ex.: via Observer)
        $metrics = $this->db->getMetrics($activityID);
        $guideViews = (int)($metrics['guide_views'] ?? 0);
        $deployCount = (int)($metrics['deploy_count'] ?? 0);

        // Indicadores derivados (simples e transparentes)
        $acessoAoGuia = $guideViews > 0;
        $numeroDeAcessos = $guideViews;

        // Score de engagement (heurística simples para demonstração)
        $scoreEngagement = min(100, $guideViews * 10);

        return [
            "activityID" => $activityID,
            "guideData" => $guideData,
            "analytics" => [
                "acessoAoGuia" => $acessoAoGuia,
                "numeroDeAcessos" => $numeroDeAcessos,
                "deployCount" => $deployCount,
                "scoreEngagement" => $scoreEngagement
            ]
        ];
    }
}
