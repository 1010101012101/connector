<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\Camera;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\UserId;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Devices.DomainModel.Camera.Camera.dcm.xml
 */
final class Camera
{

	/**
	 * @var CameraId
	 */
	private $id;

	/**
	 * @var UserId
	 */
	private $ownerId;

	/**
	 * @var string
	 */
	private $cameraName;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Camera\Stream
	 */
	private $stream;

	/**
	 * @var \DateTimeImmutable
	 */
	private $creationDate;

	private function __construct()
	{
	}

	public static function create(CameraId $id, Owner $owner, string $cameraName, Stream $stream, ?\DateTimeImmutable $creationDate = NULL)
	{
		$camera = new self;
		$camera->id = $id;
		$camera->ownerId = $owner->id();
		$camera->cameraName = $cameraName;
		$camera->stream = $stream;
		$camera->creationDate = $creationDate ?: new \DateTimeImmutable('now');
		return $camera;
	}

	public function id(): CameraId
	{
		return $this->id;
	}

	public function ownerId(): UserId
	{
		return $this->ownerId;
	}

	public function cameraName(): string
	{
		return $this->cameraName;
	}

	public function stream(): Stream
	{
		return $this->stream;
	}

	public function creationDate(): \DateTimeImmutable
	{
		return $this->creationDate;
	}

}
