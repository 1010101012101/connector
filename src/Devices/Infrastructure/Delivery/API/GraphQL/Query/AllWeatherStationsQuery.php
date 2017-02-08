<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Query;

use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAllWeatherStations;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type\WeatherStationsConnectionType;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\GraphQL\Structure\Argument;
use function Adeira\Connector\GraphQL\{
	nullableInt, nullableString, type
};
use GraphQL\Type\Definition;

final class AllWeatherStationsQuery extends \Adeira\Connector\GraphQL\Structure\Query
{

	/**
	 * @var ViewAllWeatherStations
	 */
	private $allWeatherStationsService;

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type\WeatherStationsConnectionType
	 */
	private $weatherStationsConnection;

	public function __construct(
		ViewAllWeatherStations $allWeatherStationsService,
		WeatherStationsConnectionType $weatherStationsConnection
	) {
		$this->allWeatherStationsService = $allWeatherStationsService;
		$this->weatherStationsConnection = $weatherStationsConnection;
	}

	public function getPublicQueryName(): string
	{
		return 'allWeatherStations';
	}

	public function getPublicQueryDescription(): string
	{
		return 'All weather stations';
	}

	public function getQueryReturnType(): Definition\ObjectType
	{
		return type($this->weatherStationsConnection);
	}

	public function defineArguments(): ?array
	{
		return [
			new Argument('first', 'How many records do you want', nullableInt()),
			new Argument('after', 'Last cursor', nullableString()),
		];
	}

	public function resolve($ancestorValue, $args, Context $context)
	{
		$limit = $args['first'] ?? NULL;
		$fromWeatherStationId = isset($args['after']) ? WeatherStationId::createFromString(base64_decode($args['after'])) : NULL;
		return $this->allWeatherStationsService->execute($context->userId(), $limit, $fromWeatherStationId);
	}

}
