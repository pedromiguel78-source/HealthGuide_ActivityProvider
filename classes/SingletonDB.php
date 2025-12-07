<?php
// classes/SingletonDB.php

/**
 * Classe Singleton para administrar a base de dados de guias de saúde
 * 
 * Este padrão garante que existe apenas uma instância da base de dados
 * durante toda a execução da aplicação.
 */
class SingletonDB {
    
    // Instância única da classe
    private static $instance = null;
    
    // Base de dados (array em memória)
    private $db = [];
    
    // Resumo padrão para novos guias
    const DEFAULT_RESUMO = "Guia de saúde digital 2025: Informação atualizada sobre gestão de saúde e bem-estar pessoal.";
    
    // Construtor privado - previne criação direta de objetos
    
    private function __construct() {
        // Inicializa base de dados vazia
        $this->db = [];
    }
    
    // Previne clonagem da instância
    
    private function __clone() {}
    
    
     // Previne deserialização da instância
     
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
    
     //Retorna a instância única da classe (Singleton)
     
   
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new SingletonDB();
        }
        return self::$instance;
    }
  
    public function getDatabase() {
        return $this->db;
    }
   
    public function createInstance($activityID) {
        if (!isset($this->db[$activityID])) {
            $this->db[$activityID] = [
                "resumo" => self::DEFAULT_RESUMO,
                "titulo" => "Guia de Saúde Digital 2025",
                "tipo" => "geral",
                "conteudo" => "Conteúdo de saúde baseado em evidências científicas atualizadas",
                "instrucoes" => "1. Leia atentamente todas as informações\n2. Siga as recomendações do seu profissional de saúde\n3. Mantenha um registo regular dos seus indicadores\n4. Em caso de dúvidas, consulte o seu médico"
            ];
        }
        return $this->db[$activityID];
    }
    
    //Retorna os dados de uma entrada específica
    
    public function accessData($activityID) {
        return isset($this->db[$activityID]) ? $this->db[$activityID] : null;
    }
    
    //Atualiza os dados de uma entrada existente no banco de dados
    
    public function executeOperations($activityID, $resumo = null, $titulo = null, $tipo = null, $conteudo = null, $instrucoes = null) {
        if (!isset($this->db[$activityID])) {
            throw new Exception("Activity ID '$activityID' não encontrado no banco de dados.");
        }
        
        if ($resumo !== null) {
            $this->db[$activityID]["resumo"] = $resumo;
        }
        if ($titulo !== null) {
            $this->db[$activityID]["titulo"] = $titulo;
        }
        if ($tipo !== null) {
            $this->db[$activityID]["tipo"] = $tipo;
        }
        if ($conteudo !== null) {
            $this->db[$activityID]["conteudo"] = $conteudo;
        }
        if ($instrucoes !== null) {
            $this->db[$activityID]["instrucoes"] = $instrucoes;
        }
        
        return $this->db[$activityID];
    }
    
    //Remove uma entrada da base de dados
    
    public function deleteInstance($activityID) {
        if (isset($this->db[$activityID])) {
            unset($this->db[$activityID]);
            return true;
        }
        return false;
    }
    
    //Retorna o número total de entradas
    public function count() {
        return count($this->db);
    }
}
