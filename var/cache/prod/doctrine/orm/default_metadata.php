<?php

// This file has been auto-generated by the Symfony Cache Component.

return [[

'App__Entity__User__CLASSMETADATA__' => 0,
'App__Entity__Task__CLASSMETADATA__' => 1,

], [

0 => static function () {
    return \Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
        $o = [
            clone (($p = &\Symfony\Component\VarExporter\Internal\Registry::$prototypes)['Doctrine\\ORM\\Mapping\\ClassMetadata'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('Doctrine\\ORM\\Mapping\\ClassMetadata')),
            clone ($p['Doctrine\\ORM\\Id\\IdentityGenerator'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('Doctrine\\ORM\\Id\\IdentityGenerator')),
        ],
        null,
        [
            'stdClass' => [
                'name' => [
                    'App\\Entity\\User',
                ],
                'namespace' => [
                    'App\\Entity',
                ],
                'rootEntityName' => [
                    'App\\Entity\\User',
                ],
                'customRepositoryClassName' => [
                    'App\\Repository\\UserRepository',
                ],
                'identifier' => [
                    [
                        'id',
                    ],
                ],
                'generatorType' => [
                    4,
                ],
                'fieldMappings' => [
                    [
                        'id' => [
                            'fieldName' => 'id',
                            'type' => 'integer',
                            'scale' => null,
                            'length' => null,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'id' => true,
                            'columnName' => 'id',
                        ],
                        'username' => [
                            'fieldName' => 'username',
                            'type' => 'string',
                            'scale' => null,
                            'length' => 25,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'columnName' => 'username',
                        ],
                        'password' => [
                            'fieldName' => 'password',
                            'type' => 'string',
                            'scale' => null,
                            'length' => 64,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'columnName' => 'password',
                        ],
                        'email' => [
                            'fieldName' => 'email',
                            'type' => 'string',
                            'scale' => null,
                            'length' => 60,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'columnName' => 'email',
                        ],
                        'roles' => [
                            'fieldName' => 'roles',
                            'type' => 'json',
                            'scale' => null,
                            'length' => null,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'columnName' => 'roles',
                        ],
                    ],
                ],
                'fieldNames' => [
                    [
                        'id' => 'id',
                        'username' => 'username',
                        'password' => 'password',
                        'email' => 'email',
                        'roles' => 'roles',
                    ],
                ],
                'columnNames' => [
                    [
                        'id' => 'id',
                        'username' => 'username',
                        'password' => 'password',
                        'email' => 'email',
                        'roles' => 'roles',
                    ],
                ],
                'table' => [
                    [
                        'name' => 'user',
                    ],
                ],
                'associationMappings' => [
                    [
                        'tasks' => [
                            'fieldName' => 'tasks',
                            'mappedBy' => 'user',
                            'targetEntity' => 'App\\Entity\\Task',
                            'cascade' => [],
                            'orphanRemoval' => false,
                            'fetch' => 2,
                            'type' => 4,
                            'inversedBy' => null,
                            'isOwningSide' => false,
                            'sourceEntity' => 'App\\Entity\\User',
                            'isCascadeRemove' => false,
                            'isCascadePersist' => false,
                            'isCascadeRefresh' => false,
                            'isCascadeMerge' => false,
                            'isCascadeDetach' => false,
                        ],
                    ],
                ],
                'idGenerator' => [
                    $o[1],
                ],
            ],
        ],
        $o[0],
        []
    );
},
1 => static function () {
    return \Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
        $o = [
            clone (($p = &\Symfony\Component\VarExporter\Internal\Registry::$prototypes)['Doctrine\\ORM\\Mapping\\ClassMetadata'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('Doctrine\\ORM\\Mapping\\ClassMetadata')),
            clone ($p['Doctrine\\ORM\\Id\\IdentityGenerator'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('Doctrine\\ORM\\Id\\IdentityGenerator')),
        ],
        null,
        [
            'stdClass' => [
                'name' => [
                    'App\\Entity\\Task',
                ],
                'namespace' => [
                    'App\\Entity',
                ],
                'rootEntityName' => [
                    'App\\Entity\\Task',
                ],
                'customRepositoryClassName' => [
                    'App\\Repository\\TaskRepository',
                ],
                'identifier' => [
                    [
                        'id',
                    ],
                ],
                'generatorType' => [
                    4,
                ],
                'fieldMappings' => [
                    [
                        'id' => [
                            'fieldName' => 'id',
                            'type' => 'integer',
                            'scale' => null,
                            'length' => null,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'id' => true,
                            'columnName' => 'id',
                        ],
                        'createdAt' => [
                            'fieldName' => 'createdAt',
                            'type' => 'datetime_immutable',
                            'scale' => null,
                            'length' => null,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'columnName' => 'created_at',
                        ],
                        'title' => [
                            'fieldName' => 'title',
                            'type' => 'string',
                            'scale' => null,
                            'length' => 255,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'columnName' => 'title',
                        ],
                        'content' => [
                            'fieldName' => 'content',
                            'type' => 'string',
                            'scale' => null,
                            'length' => 255,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'columnName' => 'content',
                        ],
                        'isDone' => [
                            'fieldName' => 'isDone',
                            'type' => 'boolean',
                            'scale' => null,
                            'length' => null,
                            'unique' => false,
                            'nullable' => false,
                            'precision' => null,
                            'columnName' => 'is_done',
                        ],
                    ],
                ],
                'fieldNames' => [
                    [
                        'id' => 'id',
                        'created_at' => 'createdAt',
                        'title' => 'title',
                        'content' => 'content',
                        'is_done' => 'isDone',
                    ],
                ],
                'columnNames' => [
                    [
                        'id' => 'id',
                        'createdAt' => 'created_at',
                        'title' => 'title',
                        'content' => 'content',
                        'isDone' => 'is_done',
                    ],
                ],
                'table' => [
                    [
                        'name' => 'task',
                    ],
                ],
                'associationMappings' => [
                    [
                        'user' => [
                            'fieldName' => 'user',
                            'joinColumns' => [
                                [
                                    'name' => 'user_id',
                                    'referencedColumnName' => 'id',
                                ],
                            ],
                            'cascade' => [],
                            'inversedBy' => 'tasks',
                            'targetEntity' => 'App\\Entity\\User',
                            'fetch' => 2,
                            'type' => 2,
                            'mappedBy' => null,
                            'isOwningSide' => true,
                            'sourceEntity' => 'App\\Entity\\Task',
                            'isCascadeRemove' => false,
                            'isCascadePersist' => false,
                            'isCascadeRefresh' => false,
                            'isCascadeMerge' => false,
                            'isCascadeDetach' => false,
                            'sourceToTargetKeyColumns' => [
                                'user_id' => 'id',
                            ],
                            'joinColumnFieldNames' => [
                                'user_id' => 'user_id',
                            ],
                            'targetToSourceKeyColumns' => [
                                'id' => 'user_id',
                            ],
                            'orphanRemoval' => false,
                        ],
                    ],
                ],
                'idGenerator' => [
                    $o[1],
                ],
            ],
        ],
        $o[0],
        []
    );
},

]];
