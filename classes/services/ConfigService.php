<?php
// classes/services/ConfigService.php

/**
 * Serviço simples para suportar a UI de configuração.
 * (Mantém o Facade: o Facade coordena; os serviços fornecem dados/decisões.)
 */
class ConfigService {
    /**
     * Tipos de guia apresentados na página /config-healthguide
     */
    public function getGuideTypes(): array {
        return [
            ["value" => "medicacao", "label" => "💊 Gestão de Medicação"],
            ["value" => "sintomas", "label" => "🩺 Monitorização de Sintomas"],
            ["value" => "bemestar", "label" => "🏃 Programa de Bem-Estar"],
            ["value" => "mental", "label" => "🧘 Saúde Mental"],
            ["value" => "nutricao", "label" => "🍎 Nutrição Personalizada"],
            ["value" => "vacinas", "label" => "💉 Calendário de Vacinas"],
        ];
    }
}
