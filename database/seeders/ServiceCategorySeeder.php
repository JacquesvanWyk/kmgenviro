<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Environmental Monitoring Services',
                'slug' => 'environmental-monitoring-services',
                'description' => 'KMG provides scientifically robust monitoring campaigns for air quality, water quality, noise, vibration, and biodiversity. Our SACNASP-registered specialists use accredited laboratories and calibrated equipment to deliver reliable environmental data for compliance and impact assessment.',
                'icon' => null,
                'sort_order' => 1,
                'is_active' => true,
                'meta_title' => 'Environmental Monitoring Services | Air, Water, Noise | KMG',
                'meta_description' => 'Accredited environmental monitoring services including air quality, water sampling, noise & vibration assessment, and biodiversity surveys by SACNASP registered specialists.',
            ],
            [
                'name' => 'Environmental Impact & Specialist Studies',
                'slug' => 'environmental-impact-specialist-studies',
                'description' => 'KMG\'s professionally registered Environmental Assessment Practitioners conduct comprehensive Environmental Impact Assessments, Basic Assessments, and specialist studies. Our multidisciplinary team delivers NEMA-compliant reports for mining, infrastructure, and renewable energy projects.',
                'icon' => null,
                'sort_order' => 2,
                'is_active' => true,
                'meta_title' => 'EIA & Specialist Studies | NEMA Compliance | KMG Environmental',
                'meta_description' => 'Full-scope Environmental Impact Assessments, Basic Assessments, and specialist studies by EAPASA-registered practitioners. NEMA-compliant EIA services for all sectors.',
            ],
            [
                'name' => 'Permitting Services & Applications',
                'slug' => 'permitting-services-applications',
                'description' => 'KMG manages the complete environmental permitting process including water use licences, waste management licences, atmospheric emission licences, and environmental authorisations. We navigate complex regulatory frameworks to secure approvals on time.',
                'icon' => null,
                'sort_order' => 3,
                'is_active' => true,
                'meta_title' => 'Environmental Permits & Licences | Water Use, Waste, AEL | KMG',
                'meta_description' => 'Expert environmental permitting services: water use licences, waste management licences, atmospheric emission licences, and NEMA environmental authorisations.',
            ],
            [
                'name' => 'Waste Management Services',
                'slug' => 'waste-management-services',
                'description' => 'Comprehensive waste management solutions from waste classification and minimisation plans to licence applications and audit compliance. KMG develops practical strategies aligned with the National Waste Management Strategy and circular economy principles.',
                'icon' => null,
                'sort_order' => 4,
                'is_active' => true,
                'meta_title' => 'Waste Management Services | Classification, Licensing, Audits | KMG',
                'meta_description' => 'Complete waste management services including classification, waste management plans, licence applications, and compliance audits for industrial and commercial clients.',
            ],
            [
                'name' => 'ESG Advisory & Reporting',
                'slug' => 'esg-advisory-reporting',
                'description' => 'KMG supports corporate sustainability through ESG strategy development, materiality assessments, carbon footprint calculations, and sustainability reporting aligned with GRI, CDP, and TCFD frameworks. Our services help organisations demonstrate environmental responsibility to stakeholders.',
                'icon' => null,
                'sort_order' => 5,
                'is_active' => true,
                'meta_title' => 'ESG Advisory & Sustainability Reporting | GRI, CDP, TCFD | KMG',
                'meta_description' => 'Corporate ESG advisory, sustainability reporting, carbon footprint assessment, and environmental strategy development aligned with international frameworks.',
            ],
            [
                'name' => 'Occupational Hygiene Services',
                'slug' => 'occupational-hygiene-services',
                'description' => 'SAIOH-certified occupational hygienists conduct workplace exposure assessments for dust, noise, chemical hazards, heat stress, and illumination. KMG provides risk management solutions to protect employee health and ensure Mine Health and Safety Act compliance.',
                'icon' => null,
                'sort_order' => 6,
                'is_active' => true,
                'meta_title' => 'Occupational Hygiene Services | Dust, Noise, Chemical Exposure | KMG',
                'meta_description' => 'Professional occupational hygiene services including exposure monitoring, risk assessments, and health compliance for mining, industrial, and construction sectors.',
            ],
            [
                'name' => 'Training Courses & CPD',
                'slug' => 'training-courses-cpd',
                'description' => 'SACNASP and EAPASA accredited training courses for environmental practitioners, compliance officers, and sustainability professionals. KMG offers practical, competency-based training with CPD points recognised toward professional registration and career development.',
                'icon' => null,
                'sort_order' => 7,
                'is_active' => true,
                'meta_title' => 'Accredited Environmental Training | SACNASP, EAPASA CPD | KMG',
                'meta_description' => 'SACNASP and EAPASA accredited training courses for environmental professionals. Earn CPD points toward professional registration with practical, expert-led courses.',
            ],
            [
                'name' => 'Equipment Rental Services',
                'slug' => 'equipment-rental-services',
                'description' => 'Rental of calibrated environmental monitoring equipment including air quality samplers, noise meters, water quality instruments, and occupational hygiene devices. All equipment is maintained to manufacturer specifications with current calibration certificates.',
                'icon' => null,
                'sort_order' => 8,
                'is_active' => true,
                'meta_title' => 'Environmental Monitoring Equipment Rental | Calibrated Instruments | KMG',
                'meta_description' => 'Rent calibrated environmental monitoring equipment: air quality samplers, noise meters, water testing kits, and occupational hygiene instruments.',
            ],
            [
                'name' => 'Environmental Auditing & Compliance',
                'slug' => 'environmental-auditing-compliance',
                'description' => 'Independent environmental compliance audits against NEMA, NWA, NEM:WA, and MPRDA requirements. KMG conducts internal audits, external performance assessments, and due diligence investigations to identify non-compliance risks and improvement opportunities.',
                'icon' => null,
                'sort_order' => 9,
                'is_active' => true,
                'meta_title' => 'Environmental Compliance Audits | NEMA, NWA, ISO 14001 | KMG',
                'meta_description' => 'Independent environmental compliance auditing services for NEMA, water use, waste management, and mining compliance. Identify risks and ensure regulatory adherence.',
            ],
            [
                'name' => 'Asbestos Management Services',
                'slug' => 'asbestos-management-services',
                'description' => 'DoEL-approved asbestos inspection, assessment, and management planning services. KMG conducts asbestos surveys, air monitoring during removal, and prepares compliant asbestos management plans for building owners and demolition contractors.',
                'icon' => null,
                'sort_order' => 10,
                'is_active' => true,
                'meta_title' => 'DoEL Approved Asbestos Services | Inspection, Assessment, Management | KMG',
                'meta_description' => 'Department of Employment and Labour approved asbestos services: surveys, air monitoring, management plans, and compliance assessments.',
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }

        $this->command->info('Created 10 service categories successfully!');
    }
}
