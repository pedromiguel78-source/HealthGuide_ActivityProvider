<?php
// classes/observer/Observer.php

/**
 * Interface Observer (padrão comportamental Observer).
 * Observadores reagem a eventos do sistema (ex.: GUIDE_VIEWED).
 */
interface Observer {
    public function update(string $eventName, array $context = []): void;
}
