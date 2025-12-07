<?php
// index.php - HealthGuide Activity Provider
// Pedro Pereira - 1102837

require_once __DIR__ . '/classes/SingletonDB.php';

// Obter instância única do Singleton
$db = SingletonDB::getInstance();

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
    ?>
    <!DOCTYPE html>
    <html lang="pt">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuração - HealthGuide</title>
    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #7FDBFF, #B5E9FF);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Verdana, sans-serif;
            color: #003B5C;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            width: 100%;
        }
        .card {
            padding: 40px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(6px);
            border: 2px solid rgba(255,255,255,0.4);
        }
        h1 {
            margin: 0 0 10px 0;
            font-size: 36px;
            text-shadow: 1px 1px 4px rgba(255,255,255,0.7);
        }
        .subtitle {
            font-size: 18px;
            opacity: 0.85;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(0, 59, 92, 0.2);
            border-radius: 8px;
            font-family: Verdana, sans-serif;
            font-size: 14px;
        }
        select {
            cursor: pointer;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        button {
            width: 100%;
            padding: 15px;
            background: rgba(0, 59, 92, 0.8);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        button:hover {
            background: rgba(0, 59, 92, 1);
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #003B5C;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <h1>⚙️ Configuração</h1>
                <p class="subtitle">Configure um novo guia de saúde</p>
                
                <form>
                    <div class="form-group">
                        <label>Tipo de Guia:</label>
                        <select>
                            <option value="">Selecione...</option>
                            <option value="medicacao">💊 Gestão de Medicação</option>
                            <option value="sintomas">🩺 Monitorização de Sintomas</option>
                            <option value="bemestar">🏃 Programa de Bem-Estar</option>
                            <option value="mental">🧘 Saúde Mental</option>
                            <option value="nutricao">🍎 Nutrição Personalizada</option>
                            <option value="vacinas">💉 Calendário de Vacinas</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Título:</label>
                        <input type="text" placeholder="Ex: Gestão de Diabetes">
                    </div>
                    
                    <div class="form-group">
                        <label>Resumo:</label>
                        <input type="text" placeholder="Breve descrição">
                    </div>
                    
                    <div class="form-group">
                        <label>Instruções:</label>
                        <textarea placeholder="Passos a seguir..."></textarea>
                    </div>
                    
                    <button type="button" onclick="alert('Configuração salva!')">Guardar</button>
                </form>
                
                <a href="/" class="back-link">← Voltar</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ========== GET /json-params-healthguide ==========
if ($uri === "/json-params-healthguide" && $method === "GET") {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode([
        ["name" => "resumo", "type" => "text/plain", "description" => "Resumo do guia"],
        ["name" => "titulo", "type" => "text/plain", "description" => "Título do guia"],
        ["name" => "tipo", "type" => "enum", "description" => "Tipo de guia", 
         "options" => ["medicacao", "sintomas", "bemestar", "mental", "nutricao", "vacinas"]],
        ["name" => "instrucoes", "type" => "text/plain", "description" => "Instruções"]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// ========== GET /deploy-healthguide?activityID=... ==========
if ($uri === "/deploy-healthguide" && $method === "GET") {
    header("Content-Type: application/json; charset=utf-8");
    
    $activityID = $_GET['activityID'] ?? 'default';
    $db->createInstance($activityID);
    
    echo json_encode([
        "status" => "success",
        "message" => "Instância criada usando Singleton",
        "activityID" => $activityID,
        "url" => "http://" . $_SERVER['HTTP_HOST'] . "/guia-healthguide?activityID=" . $activityID
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// ========== GET /analytics-list-healthguide ==========
if ($uri === "/analytics-list-healthguide" && $method === "GET") {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode([
        "qualAnalytics" => [
            ["name" => "Acesso ao guia", "type" => "boolean"],
            ["name" => "Guia concluído", "type" => "boolean"],
            ["name" => "Feedback positivo", "type" => "boolean"]
        ],
        "quantAnalytics" => [
            ["name" => "Número de acessos", "type" => "integer"],
            ["name" => "Tempo médio", "type" => "integer"],
            ["name" => "Score de engagement", "type" => "integer"]
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// ========== POST /analytics-healthguide ==========
if ($uri === "/analytics-healthguide" && $method === "POST") {
    header("Content-Type: application/json; charset=utf-8");
    
    $data = json_decode(file_get_contents('php://input'), true);
    $activityID = $data['activityID'] ?? null;
    
    if (!$activityID) {
        http_response_code(400);
        echo json_encode(["error" => "activityID required"], JSON_PRETTY_PRINT);
        exit;
    }
    
    $guideData = $db->accessData($activityID);
    
    if (!$guideData) {
        http_response_code(404);
        echo json_encode(["error" => "Activity not found"], JSON_PRETTY_PRINT);
        exit;
    }
    
    echo json_encode([
        "activityID" => $activityID,
        "guideData" => $guideData,
        "analytics" => [
            "acessoAoGuia" => true,
            "numeroDeAcessos" => 1,
            "scoreEngagement" => 15
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// ========== GET /guia-healthguide?activityID=... ==========
if ($uri === "/guia-healthguide" && $method === "GET") {
    $activityID = $_GET['activityID'] ?? 'default';
    $data = $db->accessData($activityID);
    
    if (!$data) {
        $data = [
            'titulo' => 'Guia de Saúde Digital 2025',
            'resumo' => 'Guia de saúde digital 2025',
            'instrucoes' => "1. Leia atentamente\n2. Siga as recomendações\n3. Consulte o médico"
        ];
    }
    
    $titulo = $data['titulo'];
    $resumo = $data['resumo'];
    $instrucoes = $data['instrucoes'];
    
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
        "GET /guia-healthguide?activityID=..."
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
