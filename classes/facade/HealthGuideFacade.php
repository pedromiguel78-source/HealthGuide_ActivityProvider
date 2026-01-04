<?php
// classes/facade/HealthGuideFacade.php

require_once __DIR__ . '/../SingletonDB.php';
require_once __DIR__ . '/../services/ParamsService.php';
require_once __DIR__ . '/../services/DeploymentService.php';
require_once __DIR__ . '/../services/AnalyticsService.php';
require_once __DIR__ . '/../services/ConfigService.php';
require_once __DIR__ . '/../services/GuideService.php';

/**
 * Facade: fornece uma interface única e simples para o funcionamento do Activity Provider.
 * O objetivo é isolar o "exterior" (endpoints) da complexidade/variação interna (serviços e lógica).
 */
class HealthGuideFacade {
    private ParamsService $paramsService;
    private DeploymentService $deploymentService;
    private AnalyticsService $analyticsService;
    private ConfigService $configService;
    private GuideService $guideService;

    public function __construct(SingletonDB $db) {
        $this->paramsService = new ParamsService();
        $this->deploymentService = new DeploymentService($db);
        $this->analyticsService = new AnalyticsService($db);
        $this->configService = new ConfigService();
        $this->guideService = new GuideService($db);
    }

    public function getJsonParams(): array {
        return $this->paramsService->getParams();
    }

    public function getAnalyticsList(): array {
        return $this->paramsService->getAnalyticsSchema();
    }

    public function deploy(string $activityID, string $host): array {
        return $this->deploymentService->deploy($activityID, $host);
    }

    public function postAnalytics(array $payload): array {
        return $this->analyticsService->buildAnalyticsResponse($payload);
    }

    /**
     * ViewModel para a página de configuração (HTML).
     */
    public function getConfigViewModel(): array {
        return [
            'guideTypes' => $this->configService->getGuideTypes(),
        ];
    }

    /**
     * ViewModel para a renderização do guia (HTML).
     */
    public function getGuideViewModel(string $activityID): array {
        return $this->guideService->getGuide($activityID);
    }
}
