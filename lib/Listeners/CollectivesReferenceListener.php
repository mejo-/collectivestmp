<?php

namespace OCA\Collectives\Listeners;

use OCA\Collectives\AppInfo\Application;
use OCP\Collaboration\Reference\RenderReferenceEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\Util;

class CollectivesReferenceListener implements IEventListener {
	public function __construct() {
	}

	public function handle(Event $event): void {
		if (!$event instanceof RenderReferenceEvent) {
			return;
		}

		Util::addScript(Application::APP_NAME, Application::APP_NAME . '-reference');
	}
}
