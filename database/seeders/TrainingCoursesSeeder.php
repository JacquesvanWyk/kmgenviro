<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingCourse;
use Illuminate\Support\Str;

class TrainingCoursesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing training courses
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('training_courses')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $courses = [
            [
                'name' => 'Environmental Impact Assessment (EIA) Training',
                'slug' => 'environmental-impact-assessment-training',
                'short_description' => 'CPD-Accredited by EAPASA | 2 CPD Points (Category 2). Comprehensive training on the EIA process, NEMA regulations, and specialist studies integration.',
                'full_description' => '<p>This CPD-accredited training course provides comprehensive coverage of the Environmental Impact Assessment process in South Africa. Participants gain practical skills in conducting EIAs, preparing compliant reports, and managing stakeholder engagement.</p>

<h3>Learning Outcomes</h3>
<p>By the end of the training, participants will be able to:</p>
<ul>
<li><strong>Understand Environmental Legislation:</strong> Interpret and apply the National Environmental Management Act (NEMA) and related EIA regulations. Identify the roles of competent authorities in the EIA process.</li>
<li><strong>Apply the EIA Process:</strong> Conduct screening, scoping, impact identification, and significance assessment. Prepare Basic Assessment Reports (BARs) and Environmental Impact Reports (EIRs).</li>
<li><strong>Integrate Specialist Studies into EIAs:</strong> Understand when to commission biodiversity, hydrology, air quality, heritage, and other studies. Incorporate specialist findings into impact ratings and mitigation strategies.</li>
<li><strong>Manage Stakeholder Engagement:</strong> Facilitate public participation processes (PPP). Capture and integrate stakeholder inputs into EIA documentation.</li>
<li><strong>Develop and Implement EMPs:</strong> Design Environmental Management Plans that align with project phases. Include monitoring, auditing, and compliance strategies.</li>
<li><strong>Ensure Regulatory Compliance:</strong> Understand environmental auditing and post-approval enforcement processes. Align EIAs with sustainable development and risk mitigation goals.</li>
</ul>

<h3>Target Audience</h3>
<ul>
<li>Environmental Consultants and Practitioners</li>
<li>Junior and Mid-Level EAPs (Environmental Assessment Practitioners)</li>
<li>Environmental Graduates & Interns</li>
<li>Municipal Officials and Government Staff</li>
<li>Engineers, Developers, and Project Managers</li>
<li>NGOs, Community Representatives, and Activists</li>
</ul>

<h3>Duration</h3>
<p>2 Days</p>

<h3>Accreditation</h3>
<p>CPD-Accredited by EAPASA | 2 CPD Points (Category 2)</p>

<h3>Deliverables</h3>
<ul>
<li>Certificate of Completion (2 CPD Points)</li>
<li>Training Manual</li>
</ul>',
                'duration' => '2 Days',
                'accreditation' => 'EAPASA - 2 CPD Points (Category 2)',
                'price' => null,
                'thumbnail' => null,
                'meta_title' => 'Environmental Impact Assessment (EIA) Training | KMG',
                'meta_description' => 'EAPASA-accredited EIA training course covering NEMA regulations, specialist studies, EMPs, and stakeholder engagement.',
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Workplace Environmental Awareness Training and Field Insight by Specialist',
                'slug' => 'workplace-environmental-awareness-training',
                'short_description' => 'Comprehensive training on environmental and occupational health and safety within various work environments.',
                'full_description' => '<p>KMG Environmental Solutions Services\' workplace course provides comprehensive training on environmental and occupational health and safety within various work environments. It focuses on raising awareness about environmental impacts, health and safety regulations, and the importance of maintaining compliance.</p>

<p>The course includes practical insights from specialists, helping employees understand real-world applications and the significance of safety documentation, like the safety file, in ensuring a safe and compliant workplace.</p>

<h3>Target Audience</h3>
<ul>
<li>Site workers and contractors</li>
<li>Environmental Officers</li>
<li>Project Managers</li>
<li>Safety Officers</li>
<li>Anyone working on construction, mining, or industrial sites</li>
</ul>

<h3>Key Topics</h3>
<ul>
<li>Environmental impacts and management on site</li>
<li>Health and safety regulations</li>
<li>Compliance requirements</li>
<li>Safety file significance and usage</li>
<li>Practical field insights from environmental specialists</li>
</ul>',
                'duration' => '1 Day',
                'accreditation' => 'SACNASP Accredited Training Provider',
                'price' => null,
                'thumbnail' => null,
                'meta_title' => 'Workplace Environmental Awareness Training | KMG',
                'meta_description' => 'Environmental awareness training focusing on health and safety regulations, compliance, and field insights from specialists.',
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Safety File Training & Field Insights by Specialists',
                'slug' => 'safety-file-training-field-insights',
                'short_description' => 'Practical training on safety file compilation, management, and compliance with OHS Act requirements.',
                'full_description' => '<p>This practical training course covers the essential requirements for compiling, managing, and maintaining safety files on construction and industrial sites. Participants gain field insights from experienced specialists on real-world safety file applications.</p>

<h3>Course Content</h3>
<ul>
<li>Safety file legal requirements (OHS Act, Construction Regulations)</li>
<li>Contents and structure of a compliant safety file</li>
<li>Risk assessments and method statements</li>
<li>Site safety documentation and record-keeping</li>
<li>Practical field insights from safety specialists</li>
<li>Common non-compliances and how to avoid them</li>
</ul>

<h3>Target Audience</h3>
<ul>
<li>Construction Site Managers</li>
<li>Project Managers</li>
<li>Health and Safety Officers</li>
<li>Contractors and Subcontractors</li>
<li>Environmental Coordinators</li>
</ul>',
                'duration' => '1 Day',
                'accreditation' => 'SACNASP Accredited Training Provider',
                'price' => null,
                'thumbnail' => null,
                'meta_title' => 'Safety File Training & Field Insights | KMG',
                'meta_description' => 'Practical safety file training covering OHS Act requirements, risk assessments, and field insights from specialists.',
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Health and Safety Workplace Awareness and Field Insights by Specialist',
                'slug' => 'health-safety-workplace-awareness',
                'short_description' => 'Workplace health and safety awareness training with practical field insights from industry specialists.',
                'full_description' => '<p>Comprehensive health and safety awareness training designed for workplace personnel across various industries. The course covers OHS Act requirements, hazard identification, risk management, and practical safety measures.</p>

<h3>Course Content</h3>
<ul>
<li>Occupational Health and Safety Act (OHS Act) overview</li>
<li>Workplace hazard identification and risk assessment</li>
<li>Personal protective equipment (PPE) requirements</li>
<li>Emergency procedures and incident reporting</li>
<li>Legal responsibilities of employers and employees</li>
<li>Practical field insights from health and safety specialists</li>
</ul>

<h3>Target Audience</h3>
<ul>
<li>All workplace employees</li>
<li>Supervisors and Team Leaders</li>
<li>Health and Safety Representatives</li>
<li>New employees requiring safety induction</li>
</ul>',
                'duration' => '1 Day',
                'accreditation' => 'SACNASP Accredited Training Provider',
                'price' => null,
                'thumbnail' => null,
                'meta_title' => 'Health and Safety Workplace Awareness Training | KMG',
                'meta_description' => 'OHS Act workplace awareness training with hazard identification, risk management, and field insights from specialists.',
                'sort_order' => 4,
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($courses as $course) {
            TrainingCourse::create($course);
        }
    }
}
