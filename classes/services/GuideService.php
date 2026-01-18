<?php
// classes/services/GuideService.php

require_once __DIR__ . '/../SingletonDB.php';
require_once __DIR__ . '/../observer/ActivityEventBus.php';

/**
 * Serviço para obter (ou criar) os dados do guia.
 */
class GuideService {
    private SingletonDB $db;
    private ?ActivityEventBus $eventBus;

    public function __construct(SingletonDB $db, ?ActivityEventBus $eventBus = null) {
        $this->db = $db;
        $this->eventBus = $eventBus;
    }

    /**
     * Garante que existe uma instância para o activityID e devolve os dados do guia.
     */
    public function getGuide(string $activityID): array {
        // Se não existir, cria com defaults (via SingletonDB)
        $data = $this->db->accessData($activityID);
        if (!$data) {
            $data = $this->db->createInstance($activityID);
        }


        // Notifica observers (padrão Observer) que o guia foi visualizado
        if ($this->eventBus) {
            $this->eventBus->notify('GUIDE_VIEWED', [
                'activityID' => $activityID,
                'tipo' => $data['tipo'] ?? 'geral',
            ]);
        }


        return [
            'titulo' => $data['titulo'] ?? 'Guia de Saúde Digital',
            'resumo' => $data['resumo'] ?? 'Guia de saúde digital',
            'instrucoes' => $data['instrucoes'] ?? "1. Leia atentamente\n2. Siga as recomendações\n3. Consulte o médico",
        ];
    }
}
