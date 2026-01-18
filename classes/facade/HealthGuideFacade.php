<?php
// classes/facade/HealthGuideFacade.php

require_once __DIR__ . '/../SingletonDB.php';
require_once __DIR__ . '/../services/ParamsService.php';
require_once __DIR__ . '/../services/DeploymentService.php';
require_once __DIR__ . '/../services/AnalyticsService.php';
require_once __DIR__ . '/../services/ConfigService.php';
require_once __DIR__ . '/../services/GuideService.php';

// Observer (padrão comportamental)
require_once __DIR__ . '/../observer/ActivityEventBus.php';
require_once __DIR__ . '/../observer/observers/GuideViewedObserver.php';
require_once __DIR__ . '/../observer/observers/DeploymentObserver.php';

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

    // EventBus/Subject do padrão Observer
    private ActivityEventBus $eventBus;

    public function __construct(SingletonDB $db) {
        $this->eventBus = new ActivityEventBus();
        // Observers registados (podem ser estendidos futuramente)
        $this->eventBus->attach('GUIDE_VIEWED', new GuideViewedObserver($db));
        $this->eventBus->attach('DEPLOYED', new DeploymentObserver($db));

        $this->paramsService = new ParamsService();
        $this->deploymentService = new DeploymentService($db, $this->eventBus);
        $this->analyticsService = new AnalyticsService($db);
        $this->configService = new ConfigService();
        $this->guideService = new GuideService($db, $this->eventBus);
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
