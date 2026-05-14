<?php

return [
    'definitions' => [
        [
            'slug' => 'plan_master',
            'name' => 'Maître du plan',
            'description' => 'Atteindre le nombre maximal d\'habitudes autorisé par votre plan.',
            'type' => 'plan_limit',
        ],
        [
            'slug' => 'monthly_consistency',
            'name' => 'Régularité 30 jours',
            'description' => 'Compléter au moins une habitude chaque jour pendant 30 jours consécutifs.',
            'type' => 'monthly_consistency',
        ],
    ],
];
