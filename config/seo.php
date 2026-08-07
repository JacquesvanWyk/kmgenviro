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
     */
    'pages' => [
        'home' => 'Leading South African environmental consultancy providing expert environmental monitoring, compliance, ESG advisory, occupational hygiene, and accredited training services. DoEL approved, SACNASP, EAPASA & GBCSA registered.',
        'about' => 'Learn about KMG Environmental Solutions - a leading South African environmental consultancy with 13+ years experience. DoEL approved, SACNASP, EAPASA & GBCSA registered. B-BBEE Level 2 contributor serving all 9 provinces and SADC region.',
        'services.index' => 'Comprehensive environmental services including monitoring, compliance, ESG advisory, occupational hygiene, waste management, asbestos removal, and professional training. Accredited specialists serving South Africa and SADC region.',
        'sectors.index' => 'KMG Environmental Solutions serves key South African industries including mining, energy, infrastructure, manufacturing, and agriculture. Discover tailored environmental compliance solutions for your sector.',
        'projects.index' => 'A portfolio of environmental consultancy projects completed by KMG Environmental Solutions across mining, energy, infrastructure and manufacturing in South Africa and the SADC region.',
        'training.index' => 'EAPASA and SACNASP accredited environmental training courses in South Africa. Courses include environmental management, occupational hygiene, asbestos awareness, legal compliance, and more. Book online or request in-house training.',
        'equipment.index' => 'Rent professional environmental and scientific monitoring equipment in South Africa. Air quality monitors, noise meters, water sampling equipment, and more. Flexible rental terms with technical support.',
        'blog.index' => 'Environmental insights, regulatory updates and industry commentary from the specialists at KMG Environmental Solutions.',
        'resources' => 'Download KMG Environmental Solutions company profile, service brochures, training materials, and technical guides. Free resources for environmental professionals and industry stakeholders.',
        'gallery' => 'Photographs of KMG Environmental Solutions teams, fieldwork, training sessions and completed environmental projects across South Africa.',
        'contact' => 'Contact KMG Environmental Solutions for environmental consultancy services, quotes, and enquiries. Offices in Parktown, Johannesburg and Kempton Park, serving all of South Africa and the SADC region.',
    ],
];
