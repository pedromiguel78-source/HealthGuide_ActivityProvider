<?php
// classes/observer/ActivityEventBus.php

require_once __DIR__ . '/Observer.php';

/**
 * Subject/EventBus: mantém uma lista de observers por evento e notifica-os.
 */
class ActivityEventBus {
    private array $observers = [];

    public function attach(string $eventName, Observer $observer): void {
        $this->observers[$eventName][] = $observer;
    }

    public function notify(string $eventName, array $context = []): void {
        foreach ($this->observers[$eventName] ?? [] as $observer) {
            $observer->update($eventName, $context);
        }
    }
}
