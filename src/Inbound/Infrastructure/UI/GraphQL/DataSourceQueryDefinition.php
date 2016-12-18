<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\UI\GraphQL;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository;
use GraphQL\Type\Definition;

class DataSourceQueryDefinition implements \Adeira\Connector\GraphQL\IQueryDefinition
{

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository
	 */
	private $dataSourceRepository;

	public function __construct(IDataSourceRepository $dataSourceRepository)
	{
		$this->dataSourceRepository = $dataSourceRepository;
	}

	/**
	 * device(id: String!): InboundSource
	 */
	public function __invoke(): array
	{
		$dataSourceType = (new DataSourceType)(); //FIXME: singleton
		return [
			'device' => [
				'type' => $dataSourceType,
				'args' => [
					'id' => [
						'name' => 'id',
						'description' => 'The ID of the data source.',
						'type' => Definition\Type::nonNull(
							Definition\Type::string()
						),
					],
				],
				'resolve' => function ($obj, $args, \Nette\Security\User $context) {
					//TODO: authorization (which layer?)
					return $this->dataSourceRepository->ofId(
						DataSourceId::createFromString($args['id'])
					);
				},
			],
			'devices' => [
				'type' => Definition\Type::listOf($dataSourceType),
				'resolve' => function ($obj, $args, \Nette\Security\User $context) {
					//TODO: authorization (which layer?)
					return $this->dataSourceRepository->all();
				},
			],
		];
	}

}