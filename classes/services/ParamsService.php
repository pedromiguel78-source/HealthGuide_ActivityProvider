<?php
// classes/services/ParamsService.php

class ParamsService {
    public function getParams(): array {
        return [
            ["name" => "resumo", "type" => "text/plain", "description" => "Resumo do guia"],
            ["name" => "titulo", "type" => "text/plain", "description" => "Título do guia"],
            ["name" => "tipo", "type" => "enum", "description" => "Tipo de guia",
             "options" => ["medicacao", "sintomas", "bemestar", "mental", "nutricao", "vacinas"]],
            ["name" => "instrucoes", "type" => "text/plain", "description" => "Instruções"]
        ];
    }

    public function getAnalyticsSchema(): array {
        return [
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
        ];
    }
}
