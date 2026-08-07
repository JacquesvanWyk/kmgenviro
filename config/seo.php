<?php

return [
    'organization' => [
        'name' => 'KMG Environmental Solutions Services',
        'legal_name' => 'KMG Environmental Solutions Services (Pty) Ltd',
        'description' => 'Leading environmental consultancy providing expert solutions across South Africa and the SADC region.',
        'telephones' => ['+27114804822', '+27119696184', '+27725463191'],
        'email' => 'info@kmgenviro.co.za',
        'area_served' => ['ZA', 'Southern African Development Community'],
        'social' => [
            'https://www.linkedin.com/company/53420196',
            'https://www.facebook.com/kmgenviro',
        ],
        'addresses' => [
            [
                'name' => 'Head Office',
                'street' => '08 Hillside Road, Metropolitan Building, 1st Floor B',
                'locality' => 'Parktown, Johannesburg',
                'region' => 'Gauteng',
                'postal_code' => '2193',
            ],
            [
                'name' => 'Branch Office',
                'street' => 'Aston Manor House, 128 Monument Road',
                'locality' => 'Kempton Park',
                'region' => 'Gauteng',
                'postal_code' => '1619',
            ],
        ],
    ],

    'defaults' => [
        'title' => 'KMG Environmental Solutions | Environmental Consultancy South Africa',
        'description' => 'Leading environmental consultancy providing expert solutions across South Africa. Accredited specialists in environmental compliance, training, and equipment rental.',
        'image' => 'images/og-homepage.jpg',
    ],

    /**
     * Meta descriptions for the static public pages, keyed by route name.
     * Keep these under 160 characters so search engines show them in full.
     */
    'pages' => [
        'home' => 'South African environmental consultancy: monitoring, compliance, ESG advisory, occupational hygiene and accredited training. DoEL, SACNASP & EAPASA registered.',
        'about' => 'KMG Environmental Solutions is a South African environmental consultancy with 13+ years experience, B-BBEE Level 2, serving all 9 provinces and the SADC region.',
        'services.index' => 'Environmental monitoring, compliance, ESG advisory, occupational hygiene, waste management, asbestos removal and training across South Africa and SADC.',
        'sectors.index' => 'Environmental compliance solutions tailored to mining, energy, infrastructure, manufacturing and agriculture across South Africa and the SADC region.',
        'projects.index' => 'Environmental consultancy projects delivered by KMG across mining, energy, infrastructure and manufacturing in South Africa and the SADC region.',
        'training.index' => 'EAPASA and SACNASP accredited environmental training in South Africa: environmental management, occupational hygiene, asbestos awareness and legal compliance.',
        'equipment.index' => 'Rent environmental and scientific monitoring equipment in South Africa: air quality monitors, noise meters and water sampling kit, with technical support.',
        'blog.index' => 'Environmental insights, regulatory updates and industry commentary from the specialists at KMG Environmental Solutions.',
        'resources' => 'Download the KMG company profile, service brochures, training materials and technical guides. Free resources for environmental professionals.',
        'gallery' => 'Photographs of KMG Environmental Solutions teams, fieldwork, training sessions and completed environmental projects across South Africa.',
        'contact' => 'Contact KMG Environmental Solutions for consultancy, quotes and enquiries. Offices in Parktown, Johannesburg and Kempton Park, serving all of South Africa.',
    ],
];
