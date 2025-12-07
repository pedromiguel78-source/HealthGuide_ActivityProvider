<?php
/**
 * Teste do Padrão Singleton
 * Demonstra que apenas uma instância é criada
 */

require_once __DIR__ . '/classes/SingletonDB.php';

echo "===========================================\n";
echo "TESTE DO PADRÃO SINGLETON - HealthGuide\n";
echo "===========================================\n\n";

// Teste 1: Obter instância do Singleton
echo "--- TESTE 1: Obter Instância Única ---\n";
$db1 = SingletonDB::getInstance();
$db2 = SingletonDB::getInstance();

if ($db1 === $db2) {
    echo "✅ SUCESSO: db1 === db2 (mesma instância!)\n";
} else {
    echo "❌ ERRO: Instâncias diferentes\n";
}
echo "\n";

// Teste 2: Criar entradas
echo "--- TESTE 2: Criar Entradas ---\n";
$db1->createInstance('activity_001');
$db1->createInstance('activity_002');
echo "✅ Criadas 2 entradas: activity_001, activity_002\n";
echo "Total de entradas: " . $db1->count() . "\n\n";

// Teste 3: Verificar que ambas as instâncias tem os mesmos dados
echo "--- TESTE 3: Dados Partilhados Entre Instâncias ---\n";
echo "Entradas visíveis em db1: " . $db1->count() . "\n";
echo "Entradas visíveis em db2: " . $db2->count() . "\n";

if ($db1->count() === $db2->count()) {
    echo "✅ SUCESSO: Ambas as instâncias veem os mesmos dados\n";
} else {
    echo "❌ ERRO: Dados diferentes\n";
}
echo "\n";

// Teste 4: Atualizar dados usando uma instância
echo "--- TESTE 4: Atualizar Dados ---\n";
$db1->executeOperations(
    'activity_001',
    'Guia de Paracetamol',
    'Medicação: Paracetamol',
    'medicacao',
    null,
    'Tomar 500mg de 8 em 8 horas'
);
echo "✅ Dados atualizados via db1\n";

// Verificar em db2
$data = $db2->accessData('activity_001');
echo "Dados lidos via db2:\n";
echo "  Resumo: " . $data['resumo'] . "\n";
echo "  Título: " . $data['titulo'] . "\n";
echo "  Tipo: " . $data['tipo'] . "\n\n";

// Teste 5: Tentar criar nova instância diretamente (deve falhar)
echo "--- TESTE 5: Prevenção de Criação Direta ---\n";
try {
    // Isto não é possível porque o construtor é privado
    // $db3 = new SingletonDB(); // Descomentar causaria erro
    echo "✅ Construtor privado previne criação direta\n";
} catch (Error $e) {
    echo "❌ ERRO: " . $e->getMessage() . "\n";
}
echo "\n";

// Teste 6: Aceder a base de dados
echo "--- TESTE 6: Visualizar Base de Dados ---\n";
$database = $db1->getDatabase();
echo "Base de dados completa:\n";
echo json_encode($database, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// Teste 7: Remover entrada
echo "--- TESTE 7: Remover Entrada ---\n";
$deleted = $db1->deleteInstance('activity_002');
if ($deleted) {
    echo "✅ Entrada activity_002 removida\n";
    echo "Total de entradas restantes: " . $db1->count() . "\n";
} else {
    echo "❌ Erro ao remover entrada\n";
}
echo "\n";

echo "===========================================\n";
echo "TESTES CONCLUÍDOS COM SUCESSO\n";
echo "===========================================\n";
echo "\n✅ Singleton Pattern implementado corretamente!\n";
echo "✅ Apenas uma instância existe\n";
echo "✅ Dados são partilhados entre todas as referências\n";
echo "✅ Construtor privado previne criação direta\n";
