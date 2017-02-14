<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\WeatherStation;

interface IAllWeatherStationRecords
{

	public function add(WeatherStationRecord $aWeatherStationRecord);

	public function ofWeatherStationId(WeatherStationId $weatherStationId): array;

	public function ofAllWeatherStationIds(array $weatherStationId): array;

	public function nextIdentity(): WeatherStationRecordId;

}