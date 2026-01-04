<!-- templates/config-healthguide.php -->
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
        .container { max-width: 700px; width: 100%; }
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
        .subtitle { font-size: 18px; opacity: 0.85; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; }
        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(0, 59, 92, 0.2);
            border-radius: 8px;
            font-family: Verdana, sans-serif;
            font-size: 14px;
        }
        select { cursor: pointer; }
        textarea { resize: vertical; min-height: 100px; }
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
        button:hover { background: rgba(0, 59, 92, 1); }
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

            <!-- Nota: nesta fase, o formulário é ilustrativo (GET). -->
            <form>
                <div class="form-group">
                    <label>Tipo de Guia:</label>
                    <select name="tipo">
                        <option value="">Selecione...</option>
                        <?php foreach ($guideTypes as $type): ?>
                            <option value="<?php echo htmlspecialchars($type['value']); ?>">
                                <?php echo htmlspecialchars($type['label']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Título:</label>
                    <input type="text" name="titulo" placeholder="Ex: Gestão de Diabetes">
                </div>

                <div class="form-group">
                    <label>Resumo:</label>
                    <input type="text" name="resumo" placeholder="Breve descrição">
                </div>

                <div class="form-group">
                    <label>Instruções:</label>
                    <textarea name="instrucoes" placeholder="Passos a seguir..."></textarea>
                </div>

                <button type="button" onclick="alert('Configuração guardada (demo)')">Guardar</button>
            </form>

            <a href="/" class="back-link">← Voltar</a>
        </div>
    </div>
</body>
</html>
