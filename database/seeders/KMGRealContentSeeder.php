<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    ServiceCategory,
    Service,
    TeamMember,
    Accreditation,
    Sector
};
use Illuminate\Support\Str;

class KMGRealContentSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data (truncate to reset auto-increment and remove all records)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('services')->truncate();
        \DB::table('service_categories')->truncate();
        \DB::table('team_members')->truncate();
        \DB::table('accreditations')->truncate();
        \DB::table('sectors')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Service Categories with accurate descriptions
        $this->createServiceCategories();

        // Create Individual Services under each category
        $this->createServices();

        // Create Team Members
        $this->createTeamMembers();

        // Create Accreditations
        $this->createAccreditations();

        // Create Sectors
        $this->createSectors();
    }

    private function createServiceCategories(): void
    {
        $categories = [
            [
                'name' => 'Environmental Monitoring Services',
                'slug' => 'environmental-monitoring-services',
                'description' => 'KMG provides scientifically robust monitoring campaigns for air quality, water quality, noise, vibration, and biodiversity. Our SACNASP-registered specialists use accredited laboratories and calibrated equipment to deliver reliable environmental data for compliance and impact assessment.',
                'icon' => '📊',
                'sort_order' => 1,
                'is_active' => true,
                'meta_title' => 'Environmental Monitoring Services | KMG',
                'meta_description' => 'Professional environmental monitoring services including air quality, water quality, noise, and biodiversity monitoring across South Africa.',
            ],
            [
                'name' => 'Environmental Impact & Specialist Studies',
                'slug' => 'environmental-impact-specialist-studies',
                'description' => 'KMG\'s professionally registered Environmental Assessment Practitioners conduct comprehensive Environmental Impact Assessments, Basic Assessments, and specialist studies. Our multidisciplinary team delivers NEMA-compliant reports for mining, infrastructure, and renewable energy projects.',
                'icon' => '🔬',
                'sort_order' => 2,
                'is_active' => true,
                'meta_title' => 'Environmental Impact Assessments & Specialist Studies | KMG',
                'meta_description' => 'NEMA-compliant Environmental Impact Assessments and specialist studies by registered EAPs for mining, infrastructure, and renewable energy projects.',
            ],
            [
                'name' => 'Permitting Services & Applications',
                'slug' => 'permitting-services-applications',
                'description' => 'KMG manages the complete environmental permitting process including water use licences, waste management licences, atmospheric emission licences, and environmental authorisations. We navigate complex regulatory frameworks to secure approvals on time.',
                'icon' => '📋',
                'sort_order' => 3,
                'is_active' => true,
                'meta_title' => 'Environmental Permitting & Licensing Services | KMG',
                'meta_description' => 'Expert environmental permitting services for water use licences, waste management, atmospheric emissions, and NEMA authorisations.',
            ],
            [
                'name' => 'Waste Management Services',
                'slug' => 'waste-management-services',
                'description' => 'Comprehensive waste management solutions from waste classification and minimisation plans to licence applications and audit compliance. KMG develops practical strategies aligned with the National Waste Management Strategy and circular economy principles.',
                'icon' => '♻️',
                'sort_order' => 4,
                'is_active' => true,
                'meta_title' => 'Waste Management Services & Solutions | KMG',
                'meta_description' => 'Integrated waste management services including hazardous waste, medical waste, asbestos management, and waste licensing.',
            ],
            [
                'name' => 'ESG Advisory & Reporting',
                'slug' => 'esg-advisory-reporting',
                'description' => 'KMG supports corporate sustainability through ESG strategy development, materiality assessments, carbon footprint calculations, and sustainability reporting aligned with GRI, CDP, and TCFD frameworks. Our services help organisations demonstrate environmental responsibility to stakeholders.',
                'icon' => '🌱',
                'sort_order' => 5,
                'is_active' => true,
                'meta_title' => 'ESG Advisory & Sustainability Reporting | KMG',
                'meta_description' => 'ESG strategy development, carbon footprinting, and sustainability reporting aligned with GRI, SDGs, King IV, and TCFD frameworks.',
            ],
            [
                'name' => 'Occupational Hygiene Services',
                'slug' => 'occupational-hygiene-services',
                'description' => 'SAIOH-certified occupational hygienists conduct workplace exposure assessments for dust, noise, chemical hazards, heat stress, and illumination. KMG provides risk management solutions to protect employee health and ensure Mine Health and Safety Act compliance.',
                'icon' => '🏭',
                'sort_order' => 6,
                'is_active' => true,
                'meta_title' => 'Occupational Hygiene & Workplace Health Services | KMG',
                'meta_description' => 'SAIOH-certified occupational hygiene services including noise surveys, air quality assessments, and workplace exposure monitoring.',
            ],
            [
                'name' => 'Training Courses & CPD',
                'slug' => 'training-courses-cpd',
                'description' => 'SACNASP and EAPASA accredited training courses for environmental practitioners, compliance officers, and sustainability professionals. KMG offers practical, competency-based training with CPD points recognised toward professional registration and career development.',
                'icon' => '🎓',
                'sort_order' => 7,
                'is_active' => true,
                'meta_title' => 'Accredited Environmental Training & CPD Courses | KMG',
                'meta_description' => 'SACNASP and EAPASA accredited environmental training courses with CPD points for professional development.',
            ],
            [
                'name' => 'Equipment Rental Services',
                'slug' => 'equipment-rental-services',
                'description' => 'Rental of calibrated environmental monitoring equipment including air quality samplers, noise meters, water quality instruments, and occupational hygiene devices. All equipment is maintained to manufacturer specifications with current calibration certificates.',
                'icon' => '🔧',
                'sort_order' => 8,
                'is_active' => true,
                'meta_title' => 'Environmental Monitoring Equipment Rental | KMG',
                'meta_description' => 'Calibrated environmental monitoring equipment rental including air quality, water quality, noise meters, and occupational hygiene instruments.',
            ],
            [
                'name' => 'Environmental Auditing & Compliance',
                'slug' => 'environmental-auditing-compliance',
                'description' => 'Independent environmental compliance audits against NEMA, NWA, NEM:WA, and MPRDA requirements. KMG conducts internal audits, external performance assessments, and due diligence investigations to identify non-compliance risks and improvement opportunities.',
                'icon' => '✅',
                'sort_order' => 9,
                'is_active' => true,
                'meta_title' => 'Environmental Compliance Auditing Services | KMG',
                'meta_description' => 'Independent environmental compliance audits for NEMA, NWA, NEM:WA, and MPRDA compliance verification.',
            ],
            [
                'name' => 'Asbestos Management Services',
                'slug' => 'asbestos-management-services',
                'description' => 'DoEL-approved asbestos inspection, assessment, and management planning services. KMG conducts asbestos surveys, air monitoring during removal, and prepares compliant asbestos management plans for building owners and demolition contractors.',
                'icon' => '⚠️',
                'sort_order' => 10,
                'is_active' => true,
                'meta_title' => 'DoEL Approved Asbestos Management Services | KMG',
                'meta_description' => 'DoEL-approved asbestos contractor providing inspection, assessment, management planning, and safe removal services.',
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }

    private function createServices(): void
    {
        $services = [
            // Environmental Monitoring Services
            [
                'category' => 'environmental-monitoring-services',
                'services' => [
                    [
                        'name' => 'Air Quality Monitoring',
                        'short_description' => 'Ambient air monitoring for PM₂.₅, PM₁₀, SO₂, NO₂, CO, H₂S, and VOCs using ASTM D1739 methods.',
                        'full_description' => '<p>KMG provides comprehensive air quality monitoring services including ambient air monitoring, dust fallout monitoring, passive sampling, and high-volume sampling. Our services support baseline assessments for EIAs and ongoing compliance monitoring for Atmospheric Emission Licences (AEL).</p><p><strong>Services include:</strong></p><ul><li>Ambient air monitoring (PM₂.₅, PM₁₀, SO₂, NO₂, CO, H₂S, VOCs)</li><li>Dust fallout monitoring (ASTM D1739)</li><li>Passive sampling and high-volume sampling</li><li>Stack emissions monitoring</li><li>Baseline and operational monitoring for EIAs</li></ul>',
                    ],
                    [
                        'name' => 'Water Quality Monitoring',
                        'short_description' => 'Surface water and groundwater sampling with physico-chemical and bacteriological analysis.',
                        'full_description' => '<p>Our water quality monitoring services provide reliable data for compliance with Water Use Licence conditions and environmental management requirements.</p><p><strong>Services include:</strong></p><ul><li>Surface water and groundwater sampling</li><li>Physico-chemical & bacteriological analysis</li><li>River health assessments</li><li>Wet season vs dry season comparison</li><li>Compliance monitoring for WUL conditions</li></ul>',
                    ],
                    [
                        'name' => 'Noise Monitoring',
                        'short_description' => 'Baseline noise surveys and intrusive noise assessments aligned with SANS 10103.',
                        'full_description' => '<p>SANS 10103-compliant noise monitoring services for environmental compliance and impact assessment.</p><p><strong>Services include:</strong></p><ul><li>Baseline noise surveys (SANS 10103)</li><li>Intrusive noise assessments</li><li>Occupational noise monitoring (SANS 10083)</li><li>Noise impact pathways and receptor evaluation</li></ul>',
                    ],
                    [
                        'name' => 'Soil & Sediment Monitoring',
                        'short_description' => 'Soil contamination screening and metal/hydrocarbon analysis.',
                        'full_description' => '<p>Comprehensive soil and sediment monitoring services for contamination assessment and environmental compliance.</p><p><strong>Services include:</strong></p><ul><li>Soil contamination screening</li><li>Metal and hydrocarbon analysis</li><li>Sediment sampling around industrial and mining sites</li></ul>',
                    ],
                    [
                        'name' => 'Ecological & Biodiversity Monitoring',
                        'short_description' => 'Seasonal fauna and flora surveys with habitat condition assessments.',
                        'full_description' => '<p>Ecological monitoring programmes to track biodiversity and ecosystem health over time.</p><p><strong>Services include:</strong></p><ul><li>Seasonal fauna & flora surveys</li><li>Ecological change detection</li><li>Habitat condition & ecosystem integrity assessments</li></ul>',
                    ],
                ],
            ],
            // Environmental Impact & Specialist Studies
            [
                'category' => 'environmental-impact-specialist-studies',
                'services' => [
                    [
                        'name' => 'Agricultural Impact Assessment (AIA)',
                        'short_description' => 'Land capability and soil classification assessments aligned with DALRRD protocols.',
                        'full_description' => '<p>Professional agricultural impact assessments for land development and mining projects.</p><p><strong>Services include:</strong></p><ul><li>Land capability and land use assessments</li><li>Soil classification and mapping</li><li>Sensitivity analysis and DALRRD compliance</li></ul>',
                    ],
                    [
                        'name' => 'Terrestrial Biodiversity Assessment',
                        'short_description' => 'Species of conservation concern identification and habitat sensitivity mapping.',
                        'full_description' => '<p>Comprehensive terrestrial biodiversity assessments by qualified specialists.</p><p><strong>Services include:</strong></p><ul><li>Species of conservation concern identification</li><li>Habitat and ecological sensitivity mapping</li><li>Impact significance evaluation and mitigation</li></ul>',
                    ],
                    [
                        'name' => 'Aquatic Biodiversity Assessment',
                        'short_description' => 'River and wetland macroinvertebrate surveys with ecological status determination.',
                        'full_description' => '<p>Aquatic ecosystem assessments using approved methodologies.</p><p><strong>Services include:</strong></p><ul><li>River and wetland macroinvertebrate surveys</li><li>Instream habitat assessments</li><li>Ecological status determination (IHI, FRAI, MIRAI)</li></ul>',
                    ],
                    [
                        'name' => 'Wetland & Hydropedology Assessment',
                        'short_description' => 'Wetland delineation and functional assessment with DWS Risk Matrix compliance.',
                        'full_description' => '<p>Wetland assessments by qualified wetland specialists.</p><p><strong>Services include:</strong></p><ul><li>Wetland delineation and functional assessment</li><li>Hydropedological modelling</li><li>DWS Risk Matrix & mitigation planning</li></ul>',
                    ],
                    [
                        'name' => 'Heritage & Palaeontology Studies',
                        'short_description' => 'Archaeological surveys and palaeontological sensitivity assessments.',
                        'full_description' => '<p>Heritage and palaeontological impact assessments for NHRA compliance.</p><p><strong>Services include:</strong></p><ul><li>Archaeological field surveys</li><li>Palaeontological sensitivity assessments</li><li>Chance-find procedures and NHRA compliance</li></ul>',
                    ],
                    [
                        'name' => 'Visual & Landscape Impact Assessment',
                        'short_description' => 'Viewshed analysis and landscape character assessment.',
                        'full_description' => '<p>Professional visual impact assessments for development projects.</p><p><strong>Services include:</strong></p><ul><li>Viewshed analysis and landscape character assessment</li><li>Visual exposure modelling</li><li>Receptor-based impact evaluation</li></ul>',
                    ],
                    [
                        'name' => 'Social Impact Assessment (SIA)',
                        'short_description' => 'Socio-economic baseline studies and stakeholder impact analysis.',
                        'full_description' => '<p>Comprehensive social impact assessments for project approval.</p><p><strong>Services include:</strong></p><ul><li>Socio-economic baseline studies</li><li>Stakeholder impact analysis</li><li>Community vulnerability assessments</li></ul>',
                    ],
                    [
                        'name' => 'Hydrology & Geohydrology Assessment',
                        'short_description' => 'Catchment hydrology and groundwater investigations with floodline modelling.',
                        'full_description' => '<p>Hydrological and geohydrological assessments for water resource management.</p><p><strong>Services include:</strong></p><ul><li>Catchment hydrology assessment</li><li>Groundwater investigations</li><li>Floodline modelling (1:50, 1:100)</li></ul>',
                    ],
                    [
                        'name' => 'Geotechnical Studies',
                        'short_description' => 'Soil mechanics and foundation investigation services for development projects.',
                        'full_description' => '<p>Professional geotechnical investigations to assess soil stability and foundation requirements for infrastructure and development projects.</p>',
                    ],
                    [
                        'name' => 'Landscape Impact Assessment',
                        'short_description' => 'Assessment of development impacts on landscape character and visual resources.',
                        'full_description' => '<p>Evaluation of how proposed developments affect landscape character, scenic quality, and visual amenity of the surrounding area.</p>',
                    ],
                    [
                        'name' => 'Traffic Impact Assessment',
                        'short_description' => 'Transportation planning and traffic impact studies for development applications.',
                        'full_description' => '<p>Professional traffic impact assessments evaluating the effects of proposed developments on road networks and traffic patterns.</p>',
                    ],
                    [
                        'name' => 'Ecological Impact Assessment',
                        'short_description' => 'Comprehensive ecosystem and ecological process assessments.',
                        'full_description' => '<p>Holistic ecological assessments examining ecosystem functioning, connectivity, and ecological processes affected by development.</p>',
                    ],
                    [
                        'name' => 'Flood Risk Assessment',
                        'short_description' => 'Floodplain delineation and flood hazard risk analysis.',
                        'full_description' => '<p>Detailed flood risk studies including hydraulic modelling and floodplain mapping to inform development planning and risk management.</p>',
                    ],
                    [
                        'name' => 'Marine Impact Assessment',
                        'short_description' => 'Marine ecosystem and coastal development impact studies.',
                        'full_description' => '<p>Specialist assessments of development impacts on marine environments, coastal processes, and marine biodiversity.</p>',
                    ],
                    [
                        'name' => 'Climate Change Impact Assessment',
                        'short_description' => 'Climate risk analysis and adaptation planning for projects.',
                        'full_description' => '<p>Assessment of climate change risks and vulnerabilities with adaptation and mitigation strategy development for resilient project planning.</p>',
                    ],
                    [
                        'name' => 'Waste Management Impact Assessment',
                        'short_description' => 'Assessment of waste generation and management impacts from development.',
                        'full_description' => '<p>Evaluation of waste streams, waste management infrastructure requirements, and environmental impacts of waste management activities.</p>',
                    ],
                    [
                        'name' => 'Environmental Health Impact Assessment',
                        'short_description' => 'Human health risk assessment related to environmental exposures.',
                        'full_description' => '<p>Assessment of potential human health impacts from environmental contamination, air emissions, noise, and other environmental stressors.</p>',
                    ],
                    [
                        'name' => 'Palaeontological Impact Assessment',
                        'short_description' => 'Fossil heritage assessment and paleontological sensitivity analysis.',
                        'full_description' => '<p>Specialist assessment of paleontological resources and fossil heritage significance in accordance with NHRA requirements.</p>',
                    ],
                    [
                        'name' => 'Energy Impact Assessment',
                        'short_description' => 'Assessment of energy use and renewable energy integration.',
                        'full_description' => '<p>Evaluation of project energy requirements, energy efficiency opportunities, and renewable energy integration potential.</p>',
                    ],
                    [
                        'name' => 'Cumulative Impact Assessment',
                        'short_description' => 'Assessment of combined impacts from multiple projects and activities.',
                        'full_description' => '<p>Evaluation of cumulative environmental effects when multiple projects or activities occur in the same area over time.</p>',
                    ],
                    [
                        'name' => 'Noise Impact Assessment',
                        'short_description' => 'Acoustic modelling and noise impact prediction for development projects.',
                        'full_description' => '<p>Professional noise impact assessments using acoustic modelling to predict noise levels and evaluate compliance with SANS 10103 standards.</p><p><strong>Services include:</strong></p><ul><li>Baseline noise environment characterisation</li><li>Impact modelling using accepted acoustics methods</li><li>Mitigation and noise control recommendations</li></ul>',
                    ],
                    [
                        'name' => 'Air Quality Impact Assessment',
                        'short_description' => 'Dispersion modelling and air quality impact prediction studies.',
                        'full_description' => '<p>Comprehensive air quality impact assessments using dispersion modelling to predict pollutant concentrations and assess compliance.</p><p><strong>Services include:</strong></p><ul><li>Baseline dispersion environment characterisation</li><li>Gaussian dispersion modelling</li><li>Emissions & receptor risk evaluation</li></ul>',
                    ],
                    [
                        'name' => 'Soil Capability Assessment',
                        'short_description' => 'Agricultural soil potential and land capability classification.',
                        'full_description' => '<p>Detailed soil investigations and land capability assessments for agricultural and land use planning purposes.</p>',
                    ],
                ],
            ],
            // Permitting Services & Applications
            [
                'category' => 'permitting-services-applications',
                'services' => [
                    [
                        'name' => 'Environmental Authorization (EA) Support',
                        'short_description' => 'NEMA Basic Assessment and Scoping EIA support for environmental authorizations.',
                        'full_description' => '<p>Comprehensive support for obtaining Environmental Authorizations under NEMA, including Basic Assessments and full Scoping EIAs.</p><p><strong>Services include:</strong></p><ul><li>Basic Assessment & Scoping EIA support</li><li>Environmental Management Programme (EMPr) compilation</li><li>Public participation guidance</li></ul>',
                    ],
                    [
                        'name' => 'Water Use License Applications (WULA)',
                        'short_description' => 'Section 21 water use evaluation and integrated WUL compliance support.',
                        'full_description' => '<p>Professional Water Use License application services for all Section 21 water uses under the National Water Act.</p><p><strong>Services include:</strong></p><ul><li>Section 21 water use evaluation</li><li>Technical motivation reports</li><li>Integrated WUL compliance monitoring</li></ul>',
                    ],
                    [
                        'name' => 'Waste Management Licensing',
                        'short_description' => 'Waste characterization and NEM:WA regulatory submissions.',
                        'full_description' => '<p>Complete waste management licensing support for storage, treatment, and disposal facilities.</p><p><strong>Services include:</strong></p><ul><li>Waste characterisation</li><li>Storage, treatment, and disposal licensing</li><li>NEM:WA regulatory submissions</li></ul>',
                    ],
                    [
                        'name' => 'Atmospheric Emissions Licensing (AEL)',
                        'short_description' => 'Baseline air quality assessment and emission inventory development for AEL.',
                        'full_description' => '<p>AEL application support including baseline assessments and emissions management.</p><p><strong>Services include:</strong></p><ul><li>Baseline air quality assessment</li><li>Emission inventory development</li><li>Source identification and emission reduction planning</li></ul>',
                    ],
                    [
                        'name' => 'Mining & Prospecting Rights Support',
                        'short_description' => 'SLP and EMPr development for MPRDA applications.',
                        'full_description' => '<p>Environmental support for mining and prospecting right applications under MPRDA.</p><p><strong>Services include:</strong></p><ul><li>SLP and EMPr development</li><li>Specialist input for prospecting rights</li><li>Compliance monitoring and reporting</li></ul>',
                    ],
                ],
            ],
            // Waste Management Services
            [
                'category' => 'waste-management-services',
                'services' => [
                    [
                        'name' => 'Integrated Waste Management Planning',
                        'short_description' => 'IWMP development implementing waste hierarchy principles.',
                        'full_description' => '<p>Strategic waste management planning for municipalities and industries aligned with the National Waste Management Strategy.</p><p><strong>Services include:</strong></p><ul><li>IWMP development for municipalities and industries</li><li>Waste hierarchy implementation</li></ul>',
                    ],
                    [
                        'name' => 'Hazardous Waste Management',
                        'short_description' => 'Chemical waste identification, classification, and regulatory compliance.',
                        'full_description' => '<p>Specialist hazardous waste management services ensuring full regulatory compliance.</p><p><strong>Services include:</strong></p><ul><li>Chemical waste identification and classification</li><li>Hazardous waste registers and manifests</li></ul>',
                    ],
                    [
                        'name' => 'Medical Waste Management (HCRW)',
                        'short_description' => 'Healthcare risk waste segregation, storage, and disposal planning.',
                        'full_description' => '<p>Comprehensive medical waste management for healthcare facilities.</p><p><strong>Services include:</strong></p><ul><li>Segregation, storage, transport and disposal planning</li><li>Compliance audits for healthcare facilities</li></ul>',
                    ],
                ],
            ],
            // Occupational Hygiene Services
            [
                'category' => 'occupational-hygiene-services',
                'services' => [
                    [
                        'name' => 'Noise Survey',
                        'short_description' => 'Workplace noise exposure assessment and hearing conservation programmes.',
                        'full_description' => '<p>SAIOH-certified occupational noise surveys for Mine Health and Safety Act compliance.</p>',
                    ],
                    [
                        'name' => 'Indoor Air Quality (IAQ) Survey',
                        'short_description' => 'Indoor air quality assessment for office and industrial environments.',
                        'full_description' => '<p>Comprehensive IAQ assessments evaluating ventilation, CO₂, VOCs, and other indoor air pollutants.</p>',
                    ],
                    [
                        'name' => 'Chemical Exposure Survey',
                        'short_description' => 'Workplace chemical hazard identification and exposure monitoring.',
                        'full_description' => '<p>Assessment of chemical exposures in the workplace with recommendations for control measures.</p>',
                    ],
                    [
                        'name' => 'Illumination Survey',
                        'short_description' => 'Workplace lighting assessment aligned with SANS 10114 standards.',
                        'full_description' => '<p>Lighting level assessments to ensure adequate illumination for workplace tasks and safety.</p>',
                    ],
                    [
                        'name' => 'Thermal Stress Survey',
                        'short_description' => 'Heat stress and thermal comfort assessment in workplaces.',
                        'full_description' => '<p>Evaluation of workplace thermal conditions and heat stress risks for employee health and safety.</p>',
                    ],
                    [
                        'name' => 'Ergonomics Survey',
                        'short_description' => 'Workplace ergonomics assessment and musculoskeletal risk evaluation.',
                        'full_description' => '<p>Assessment of workstation design and work processes to identify ergonomic risk factors.</p>',
                    ],
                    [
                        'name' => 'Respirable Dust Survey',
                        'short_description' => 'Personal dust exposure monitoring for mining and industrial operations.',
                        'full_description' => '<p>Dust exposure assessments to protect workers from silicosis and other dust-related diseases.</p>',
                    ],
                ],
            ],
        ];

        foreach ($services as $categoryData) {
            $category = ServiceCategory::where('slug', $categoryData['category'])->first();

            if ($category) {
                $order = 1;
                foreach ($categoryData['services'] as $serviceData) {
                    Service::create([
                        'service_category_id' => $category->id,
                        'name' => $serviceData['name'],
                        'slug' => Str::slug($serviceData['name']),
                        'short_description' => $serviceData['short_description'],
                        'full_description' => $serviceData['full_description'],
                        'sort_order' => $order++,
                        'is_active' => true,
                        'is_featured' => false,
                    ]);
                }
            }
        }
    }

    private function createTeamMembers(): void
    {
        $members = [
            [
                'name' => 'Khumbelo Given Marabe',
                'slug' => 'khumbelo-given-marabe',
                'title' => 'Managing Director and Principal Environmental Consultant',
                'email' => 'khumbelo@kmgenviro.co.za',
                'phone' => '072 546 3191',
                'bio' => '<p>Khumbelo Given Marabe is the visionary leader and driving force behind KMG Environmental Solutions Services. With over 14 years of experience in the environmental consulting industry, Khumbelo has a deep understanding of environmental regulations, compliance, and sustainable practices. His expertise spans environmental impact assessments (EIA), environmental audits, waste management, and environmental permitting. As a Principal Environmental Consultant, Khumbelo has led numerous high-profile projects, delivering innovative solutions that balance development with environmental stewardship. His leadership ensures that KMG remains at the forefront of the industry, providing exceptional service to a diverse range of clients.</p>',
                'qualifications' => 'SACNASP Registered Natural Scientist, WISA Member, EAPASA Affiliated',
                'registrations' => json_encode([
                    ['organization' => 'SACNASP', 'registration_number' => 'Pending Update', 'valid_until' => null],
                    ['organization' => 'WISA', 'registration_number' => 'Member', 'valid_until' => null],
                    ['organization' => 'EAPASA', 'registration_number' => 'Affiliated', 'valid_until' => null],
                ]),
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Mulalo Mutavhatsindi',
                'slug' => 'mulalo-mutavhatsindi',
                'title' => 'Administrator',
                'email' => 'admin@kmgenviro.co.za',
                'phone' => null,
                'bio' => '<p>Mulalo Mutavhatsindi plays a crucial role in the smooth operation of KMG Environmental Solutions Services. With a strong background in office management and administrative support, Mulalo ensures that all projects run efficiently. Her organizational skills and attention to detail are key to maintaining the high standards that KMG is known for. Mulalo also supports the team in client communications, document management, and the coordination of environmental reports and compliance documents, ensuring that every detail is handled with precision.</p>',
                'qualifications' => 'Business Administration, EAPASA Training Support',
                'registrations' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Randela Mashudu',
                'slug' => 'randela-mashudu',
                'title' => 'Environmental Practitioner',
                'email' => 'randela@kmgenviro.co.za',
                'phone' => null,
                'bio' => '<p>Randela Mashudu is a dedicated Environmental Practitioner with extensive experience in environmental monitoring, impact assessments, and compliance auditing. With a deep knowledge of South African environmental regulations, Randela excels in conducting detailed environmental studies and developing effective management plans. Her expertise includes air quality monitoring, water quality assessments, and biodiversity impact studies. Randela\'s commitment to environmental protection and sustainability drives her to deliver thorough and accurate assessments, ensuring that all projects comply with environmental legislation.</p>',
                'qualifications' => 'Environmental Science, Biodiversity & SIA Specialist',
                'registrations' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'John Gilfilan',
                'slug' => 'john-gilfilan',
                'title' => 'Environmental Practitioner',
                'email' => 'john@kmgenviro.co.za',
                'phone' => null,
                'bio' => '<p>John Gilfilan is a seasoned Environmental Practitioner with a wealth of experience in environmental compliance, monitoring, and management. His extensive knowledge in areas such as geohydrological studies, soil capability assessments, and noise impact assessments makes him a valuable asset to the KMG team. John is skilled at conducting environmental audits and preparing detailed reports that guide clients in meeting regulatory requirements. His hands-on approach and analytical skills ensure that all environmental risks are identified and mitigated effectively.</p>',
                'qualifications' => 'Environmental Science, Wetland & Terrestrial Ecology Specialist',
                'registrations' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Thikhedzo Nephawe',
                'slug' => 'thikhedzo-nephawe',
                'title' => 'Environmental Consultant',
                'email' => 'thikhedzo@kmgenviro.co.za',
                'phone' => null,
                'bio' => '<p>Thikhedzo Nephawe is an expert Environmental Consultant with a strong focus on sustainable development and environmental impact reduction. With a deep understanding of environmental legislation and compliance, Thikhedzo specializes in conducting comprehensive environmental audits, impact assessments, and risk analyses. His ability to develop practical solutions for complex environmental challenges has made him a trusted advisor for clients across various sectors. Thikhedzo is committed to promoting best practices in environmental management and ensuring that all projects adhere to regulatory standards.</p>',
                'qualifications' => 'Environmental Management, Noise & Air Quality Specialist',
                'registrations' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Moloko Ramare',
                'slug' => 'moloko-ramare',
                'title' => 'Environmental Consultant',
                'email' => 'moloko@kmgenviro.co.za',
                'phone' => null,
                'bio' => '<p>Moloko Ramare is a skilled Environmental Consultant known for his expertise in environmental monitoring and management. He brings extensive experience in conducting environmental assessments, waste management planning, and compliance monitoring. Moloko\'s analytical approach and attention to detail enable him to identify potential environmental risks and develop effective mitigation strategies. His work ensures that clients not only meet regulatory requirements but also implement sustainable practices that contribute to long-term environmental protection.</p>',
                'qualifications' => 'Environmental Science, Water & Waste Management Specialist',
                'registrations' => null,
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }

    private function createAccreditations(): void
    {
        $accreditations = [
            [
                'name' => 'Department of Employment & Labour - Approved Asbestos Contractor',
                'acronym' => 'DoEL',
                'description' => 'KMG is registered as an Approved Asbestos Contractor with the Department of Employment and Labour, authorizing professional asbestos assessment, handling, and removal services.',
                'certificate_number' => 'RAC2024-CI/100',
                'valid_until' => '2026-12-31',
                'logo' => '',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'South African Council for Natural Scientific Professions',
                'acronym' => 'SACNASP',
                'description' => 'SACNASP registration as Natural Scientists and Accredited Training Provider for professional environmental services and training delivery.',
                'certificate_number' => 'Accredited Training Provider',
                'valid_until' => null,
                'logo' => '',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Environmental Assessment Practitioners Association of South Africa',
                'acronym' => 'EAPASA',
                'description' => 'EAPASA-approved training provider for environmental assessment practitioner training and professional development.',
                'certificate_number' => 'Approved Training Provider',
                'valid_until' => null,
                'logo' => '',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Green Building Council South Africa',
                'acronym' => 'GBCSA',
                'description' => 'Registered member of the Green Building Council of South Africa, promoting sustainable built environments and climate-resilient project planning.',
                'certificate_number' => 'Member',
                'valid_until' => null,
                'logo' => '',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Water Institute of Southern Africa',
                'acronym' => 'WISA',
                'description' => 'Membership with the Water Institute of Southern Africa for water resource management excellence.',
                'certificate_number' => 'Member',
                'valid_until' => null,
                'logo' => '',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'International Institute of Acoustics and Vibration',
                'acronym' => 'IIAV',
                'description' => 'Professional membership for acoustics and noise impact assessment services.',
                'certificate_number' => 'Member',
                'valid_until' => null,
                'logo' => '',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'International Association for Impact Assessment South Africa',
                'acronym' => 'IAIAsa',
                'description' => 'Membership with IAIAsa for environmental and social impact assessment professional standards.',
                'certificate_number' => 'Member',
                'valid_until' => null,
                'logo' => '',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'South African Institute for Occupational Hygiene',
                'acronym' => 'SAIOH',
                'description' => 'SAIOH certification for professional occupational hygiene services and workplace health assessments.',
                'certificate_number' => 'Certified',
                'valid_until' => null,
                'logo' => '',
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($accreditations as $accreditation) {
            Accreditation::create($accreditation);
        }
    }

    private function createSectors(): void
    {
        $sectors = [
            [
                'name' => 'Mining & Mineral Resources',
                'slug' => 'mining-mineral-resources',
                'description' => 'Environmental services for prospecting, mining rights, chrome, PGMs, aggregate, and industrial minerals projects.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Infrastructure & Construction',
                'slug' => 'infrastructure-construction',
                'description' => 'Environmental assessments and monitoring for road, bridge, bulk infrastructure, and construction projects.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Municipal & Public Sector',
                'slug' => 'municipal-public-sector',
                'description' => 'Environmental compliance for municipal development, housing projects, and public infrastructure.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Renewable Energy',
                'slug' => 'renewable-energy',
                'description' => 'Environmental services for solar PV, wind energy feasibility, and renewable energy project assessments.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Industrial & Manufacturing',
                'slug' => 'industrial-manufacturing',
                'description' => 'Occupational hygiene, waste management, and environmental compliance for industrial facilities.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Water, Sanitation & Utilities',
                'slug' => 'water-sanitation-utilities',
                'description' => 'Environmental support for water infrastructure, sanitation, and municipal utilities projects.',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($sectors as $sector) {
            Sector::create($sector);
        }
    }
}
