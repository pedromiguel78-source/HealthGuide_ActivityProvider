<?php
// index.php - HealthGuide Activity Provider
// Pedro Pereira - 1102837

require_once __DIR__ . '/classes/SingletonDB.php';
require_once __DIR__ . '/classes/facade/HealthGuideFacade.php';

// Obter instância única do Singleton
$db = SingletonDB::getInstance();

// Instanciar Facade
$facade = new HealthGuideFacade($db);

// Obter URL e método
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

// ========== PÁGINA INICIAL ==========
if ($uri === "/" || $uri === "/index.php") {
    header("Content-Type: text/html; charset=utf-8");
    include __DIR__ . "/templates/index.html";
    exit;
}

// ========== GET /config-healthguide ==========
if ($uri === "/config-healthguide" && $method === "GET") {
    header("Content-Type: text/html; charset=utf-8");

    $viewModel = $facade->getConfigViewModel();
    $guideTypes = $viewModel['guideTypes'] ?? [];

    include __DIR__ . "/templates/config-healthguide.php";
    exit;
}


// ========== UI (HTML) ==========
if ($uri === "/ui/json-params-healthguide" && $method === "GET") {
    header("Content-Type: text/html; charset=utf-8");
    include __DIR__ . "/templates/ui-json-params.html";
    exit;
}

if ($uri === "/ui/deploy-healthguide" && $method === "GET") {
    header("Content-Type: text/html; charset=utf-8");
    include __DIR__ . "/templates/ui-deploy.html";
    exit;
}

if ($uri === "/ui/analytics-list-healthguide" && $method === "GET") {
    header("Content-Type: text/html; charset=utf-8");
    include __DIR__ . "/templates/ui-analytics-list.html";
    exit;
}

// ========== GET /json-params-healthguide ==========
if ($uri === "/json-params-healthguide" && $method === "GET") {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode(
        $facade->getJsonParams(),
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );
    exit;
}

// ========== GET /deploy-healthguide?activityID=... ==========
if ($uri === "/deploy-healthguide" && $method === "GET") {
    header("Content-Type: application/json; charset=utf-8");
    $activityID = $_GET['activityID'] ?? 'default';

    echo json_encode(
        $facade->deploy($activityID, $_SERVER['HTTP_HOST']),
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );
    exit;
}

// ========== GET /analytics-list-healthguide ==========
if ($uri === "/analytics-list-healthguide" && $method === "GET") {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode(
        $facade->getAnalyticsList(),
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );
    exit;
}

// ========== POST /analytics-healthguide ==========
if ($uri === "/analytics-healthguide" && $method === "POST") {
    header("Content-Type: application/json; charset=utf-8");
    $payload = json_decode(file_get_contents('php://input'), true) ?? [];

    try {
        echo json_encode(
            $facade->postAnalytics($payload),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(
            ["error" => $e->getMessage()],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }
    exit;
}

// ========== GET /guia-healthguide?activityID=... ==========
if ($uri === "/guia-healthguide" && $method === "GET") {
    $activityID = $_GET['activityID'] ?? 'default';
    $vm = $facade->getGuideViewModel($activityID);

    $titulo = $vm['titulo'] ?? 'Guia de Saúde Digital 2025';
    $resumo = $vm['resumo'] ?? 'Guia de saúde digital 2025';
    $instrucoes = $vm['instrucoes'] ?? "1. Leia atentamente\n2. Siga as recomendações\n3. Consulte o médico";

    include __DIR__ . "/templates/guia.html";
    exit;
}

// ========== 404 ==========
header("Content-Type: application/json; charset=utf-8");
http_response_code(404);
echo json_encode([
    "error" => "Endpoint não encontrado",
    "url" => $uri,
    "endpoints" => [
        "GET /",
        "GET /config-healthguide",
        "GET /json-params-healthguide",
        "GET /deploy-healthguide?activityID=...",
        "GET /analytics-list-healthguide",
        "POST /analytics-healthguide",
        "GET /guia-healthguide?activityID=...",
        "GET /ui/json-params-healthguide",
        "GET /ui/deploy-healthguide?activityID=...",
        "GET /ui/analytics-list-healthguide"
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
