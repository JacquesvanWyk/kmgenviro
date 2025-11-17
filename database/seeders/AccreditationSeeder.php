<?php

namespace Database\Seeders;

use App\Models\Accreditation;
use Illuminate\Database\Seeder;

class AccreditationSeeder extends Seeder
{
    public function run(): void
    {
        $accreditations = [
            [
                'name' => 'Department of Employment and Labour',
                'acronym' => 'DoEL',
                'description' => 'Approved asbestos inspection authority for workplace asbestos assessments and management plans under the Asbestos Regulations.',
                'logo' => 'placeholder-doel-logo.png', // Placeholder for Phase 2
                'certificate_number' => null,
                'valid_until' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'South African Council for Natural Scientific Professions',
                'acronym' => 'SACNASP',
                'description' => 'Professional registration body for natural scientists. KMG principals are registered Professional Natural Scientists (Pr. Sci. Nat.) and the company is an accredited training provider.',
                'logo' => 'placeholder-sacnasp-logo.png', // Placeholder for Phase 2
                'certificate_number' => null,
                'valid_until' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Environmental Assessment Practitioners Association of South Africa',
                'acronym' => 'EAPASA',
                'description' => 'Registration authority for Environmental Assessment Practitioners conducting EIAs and environmental studies under NEMA. KMG practitioners are registered EAPs.',
                'logo' => 'placeholder-eapasa-logo.png', // Placeholder for Phase 2
                'certificate_number' => null,
                'valid_until' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Green Building Council South Africa',
                'acronym' => 'GBCSA',
                'description' => 'Member organisation supporting sustainable building practices and green building certification in South Africa.',
                'logo' => 'placeholder-gbcsa-logo.png', // Placeholder for Phase 2
                'certificate_number' => null,
                'valid_until' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Water Institute of Southern Africa',
                'acronym' => 'WISA',
                'description' => 'Professional association for water sector specialists. KMG water quality and aquatic specialists maintain WISA membership.',
                'logo' => 'placeholder-wisa-logo.png', // Placeholder for Phase 2
                'certificate_number' => null,
                'valid_until' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Southern African Institute for Occupational Hygiene',
                'acronym' => 'SAIOH',
                'description' => 'Professional body for occupational hygienists in Southern Africa. KMG occupational hygiene practitioners are SAIOH certified professionals.',
                'logo' => 'placeholder-saih-logo.png', // Placeholder for Phase 2
                'certificate_number' => null,
                'valid_until' => null,
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'International Institute of Acoustics and Vibration',
                'acronym' => 'IIAV',
                'description' => 'International professional association for acoustics and vibration specialists. KMG noise and vibration consultants maintain IIAV membership.',
                'logo' => 'placeholder-iiav-logo.png', // Placeholder for Phase 2
                'certificate_number' => null,
                'valid_until' => null,
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'International Association for Impact Assessment South Africa',
                'acronym' => 'IAIAsa',
                'description' => 'Professional network for impact assessment practitioners focusing on best practices in environmental, social, and health impact assessment.',
                'logo' => 'placeholder-iaiasa-logo.png', // Placeholder for Phase 2
                'certificate_number' => null,
                'valid_until' => null,
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($accreditations as $accreditation) {
            Accreditation::create($accreditation);
        }

        $this->command->info('Created 8 accreditations successfully!');
    }
}
