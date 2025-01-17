<?php

namespace OCA\Collectives\Controller;

use OCA\Collectives\Service\AttachmentService;
use OCA\Collectives\Service\PageService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;
use OCP\IUserSession;
use Psr\Log\LoggerInterface;

class PageController extends Controller {
	private PageService $service;
	private AttachmentService $attachmentService;
	private IUserSession $userSession;
	private LoggerInterface $logger;

	use ErrorHelper;

	public function __construct(string            $appName,
		IRequest          $request,
		PageService       $service,
		AttachmentService $attachmentService,
		IUserSession      $userSession,
		LoggerInterface   $logger) {
		parent::__construct($appName, $request);
		$this->service = $service;
		$this->attachmentService = $attachmentService;
		$this->userSession = $userSession;
		$this->logger = $logger;
	}

	/**
	 * @return string
	 */
	private function getUserId(): string {
		return $this->userSession->getUser()->getUID();
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $collectiveId
	 *
	 * @return DataResponse
	 */
	public function index(int $collectiveId): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId): array {
			$userId = $this->getUserId();
			$pageInfos = $this->service->findAll($collectiveId, $userId);
			return [
				"data" => $pageInfos
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $collectiveId
	 * @param int $parentId
	 * @param int $id
	 *
	 * @return DataResponse
	 */
	public function get(int $collectiveId, int $parentId, int $id): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $parentId, $id): array {
			$userId = $this->getUserId();
			$pageInfo = $this->service->find($collectiveId, $parentId, $id, $userId);
			return [
				"data" => $pageInfo
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int    $collectiveId
	 * @param int    $parentId
	 * @param string $title
	 *
	 * @return DataResponse
	 */
	public function create(int $collectiveId, int $parentId, string $title): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $parentId, $title): array {
			$userId = $this->getUserId();
			$pageInfo = $this->service->create($collectiveId, $parentId, $title, $userId);
			return [
				"data" => $pageInfo
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $collectiveId
	 * @param int $parentId
	 * @param int $id
	 *
	 * @return DataResponse
	 */
	public function touch(int $collectiveId, int $parentId, int $id): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $parentId, $id): array {
			$userId = $this->getUserId();
			$pageInfo = $this->service->touch($collectiveId, $parentId, $id, $userId);
			return [
				"data" => $pageInfo
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int         $collectiveId
	 * @param int         $parentId
	 * @param int         $id
	 * @param string|null $title
	 * @param int|null    $index
	 *
	 * @return DataResponse
	 */
	public function rename(int $collectiveId, int $parentId, int $id, ?string $title = null, ?int $index = 0): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $parentId, $id, $title, $index): array {
			$userId = $this->getUserId();
			$pageInfo = $this->service->rename($collectiveId, $parentId, $id, $title, $index, $userId);
			return [
				"data" => $pageInfo
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int         $collectiveId
	 * @param int         $parentId
	 * @param int         $id
	 * @param string|null $emoji
	 *
	 * @return DataResponse
	 */
	public function setEmoji(int $collectiveId, int $parentId, int $id, ?string $emoji = null): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $parentId, $id, $emoji): array {
			$userId = $this->getUserId();
			$pageInfo = $this->service->setEmoji($collectiveId, $parentId, $id, $emoji, $userId);
			return [
				"data" => $pageInfo
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int         $collectiveId
	 * @param int         $parentId
	 * @param int         $id
	 * @param string|null $subpageOrder
	 *
	 * @return DataResponse
	 */
	public function setSubpageOrder(int $collectiveId, int $parentId, int $id, ?string $subpageOrder = null): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $parentId, $id, $subpageOrder): array {
			$userId = $this->getUserId();
			$pageInfo = $this->service->setSubpageOrder($collectiveId, $parentId, $id, $subpageOrder, $userId);
			return [
				"data" => $pageInfo
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $collectiveId
	 * @param int $parentId
	 * @param int $id
	 *
	 * @return DataResponse
	 */
	public function delete(int $collectiveId, int $parentId, int $id): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $parentId, $id): array {
			$userId = $this->getUserId();
			$pageInfo = $this->service->delete($collectiveId, $parentId, $id, $userId);
			return [
				"data" => $pageInfo
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $collectiveId
	 * @param int $parentId
	 * @param int $id
	 *
	 * @return DataResponse
	 */
	public function getAttachments(int $collectiveId, int $parentId, int $id): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $id): array {
			$userId = $this->getUserId();
			$attachments = $this->attachmentService->getAttachments($collectiveId, $id, $userId);
			return [
				"data" => $attachments
			];
		}, $this->logger);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $collectiveId
	 * @param int $parentId
	 * @param int $id
	 *
	 * @return DataResponse
	 */
	public function getBacklinks(int $collectiveId, int $parentId, int $id): DataResponse {
		return $this->handleErrorResponse(function () use ($collectiveId, $parentId, $id): array {
			$userId = $this->getUserId();
			$backlinks = $this->service->getBacklinks($collectiveId, $parentId, $id, $userId);
			return [
				"data" => $backlinks
			];
		}, $this->logger);
	}
}
