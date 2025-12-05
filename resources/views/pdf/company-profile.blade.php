<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KMG Environmental Solutions - Company Profile</title>
    <style>
        @page {
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.5;
            color: #1a1a1a;
        }

        /* ========================================
           COVER PAGE - DRAMATIC SPLIT DESIGN
           ======================================== */
        .cover {
            position: relative;
            height: 100%;
            page-break-after: always;
        }
        .cover-left {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 60%;
            background-color: #18181b;
            padding: 50px 40px;
        }
        .cover-right {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 40%;
            background-color: #458BC9;
        }
        .cover-right-img {
            width: 100%;
            opacity: 0.4;
        }
        .cover-logo {
            width: 160px;
            margin-bottom: 60px;
        }
        .cover-year {
            font-size: 11px;
            letter-spacing: 4px;
            color: #458BC9;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .cover-title {
            font-size: 38px;
            font-weight: bold;
            color: white;
            line-height: 1.1;
            margin-bottom: 20px;
        }
        .cover-subtitle {
            font-size: 13px;
            color: #a1a1aa;
            line-height: 1.7;
            margin-bottom: 40px;
            max-width: 320px;
        }
        .cover-stat-row {
            margin-bottom: 25px;
        }
        .cover-stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #458BC9;
        }
        .cover-stat-label {
            font-size: 9px;
            color: #71717a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .cover-footer {
            position: absolute;
            bottom: 50px;
            left: 40px;
            right: 40px;
        }
        .cover-contact-line {
            font-size: 9px;
            color: #71717a;
            margin-bottom: 4px;
        }
        .cover-badges {
            margin-top: 15px;
        }
        .cover-badge {
            display: inline-block;
            background-color: #27272a;
            color: #458BC9;
            padding: 4px 10px;
            font-size: 7px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        /* ========================================
           CONTENT PAGES - MODERN LAYOUT
           ======================================== */
        .page {
            padding: 0;
            page-break-after: always;
            position: relative;
        }
        .page-inner {
            padding: 45px;
        }

        /* Accent bar on left */
        .accent-bar {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 8px;
            background-color: #22c55e;
        }

        /* Page header with number */
        .page-top {
            margin-bottom: 30px;
        }
        .page-number {
            display: inline-block;
            background-color: #18181b;
            color: white;
            font-size: 8px;
            font-weight: bold;
            padding: 4px 12px;
            letter-spacing: 2px;
        }
        .section-label {
            font-size: 9px;
            color: #22c55e;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 5px;
        }
        .section-title {
            font-size: 28px;
            font-weight: bold;
            color: #18181b;
            line-height: 1.1;
            margin-bottom: 5px;
        }
        .section-line {
            width: 60px;
            height: 4px;
            background-color: #22c55e;
            margin-top: 12px;
            margin-bottom: 25px;
        }

        /* Typography */
        h2 {
            font-size: 14px;
            color: #18181b;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        h3 {
            font-size: 11px;
            color: #22c55e;
            font-weight: bold;
            margin-bottom: 5px;
        }
        p {
            color: #52525b;
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .lead {
            font-size: 11pt;
            color: #334155;
            line-height: 1.7;
        }

        /* Two Column Layout */
        .two-col {
            width: 100%;
            border-collapse: collapse;
        }
        .two-col td {
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        .two-col td:last-child {
            padding-right: 0;
            padding-left: 20px;
        }

        /* Stats Grid - Bold Design */
        .stats-row {
            width: 100%;
            margin: 25px 0;
            border-collapse: collapse;
        }
        .stat-cell {
            width: 25%;
            text-align: center;
            padding: 20px 10px;
            background-color: #fafafa;
            border-right: 3px solid white;
        }
        .stat-cell:last-child {
            border-right: none;
        }
        .stat-cell.dark {
            background-color: #18181b;
        }
        .stat-cell.dark .stat-num {
            color: #22c55e;
        }
        .stat-cell.dark .stat-lbl {
            color: #71717a;
        }
        .stat-num {
            font-size: 32px;
            font-weight: bold;
            color: #18181b;
            line-height: 1;
        }
        .stat-lbl {
            font-size: 8px;
            color: #71717a;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        /* Feature Box - Highlighted */
        .feature-box {
            background-color: #18181b;
            padding: 25px 30px;
            margin: 20px 0;
        }
        .feature-box h3 {
            color: #22c55e;
            font-size: 12px;
            margin-bottom: 8px;
        }
        .feature-box p {
            color: #cbd5e1;
            margin-bottom: 0;
        }

        /* Service Cards - Grid Style */
        .service-grid {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .service-card {
            padding: 15px;
            border: 2px solid #e4e4e7;
            vertical-align: top;
        }
        .service-card:hover {
            border-color: #22c55e;
        }
        .service-icon {
            width: 40px;
            height: 40px;
            background-color: #22c55e;
            margin-bottom: 10px;
        }
        .service-card h3 {
            color: #18181b;
            font-size: 11px;
            margin-bottom: 6px;
        }
        .service-card p {
            font-size: 8pt;
            color: #71717a;
            margin-bottom: 0;
            line-height: 1.5;
        }

        /* Image with overlay caption */
        .img-container {
            position: relative;
            margin: 15px 0;
        }
        .img-full {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }
        .img-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(15, 23, 42, 0.85);
            color: white;
            font-size: 8px;
            padding: 8px 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Gallery Grid */
        .gallery-row {
            width: 100%;
            margin: 15px 0;
        }
        .gallery-row td {
            width: 33.33%;
            padding: 4px;
            vertical-align: top;
        }
        .gallery-img {
            width: 100%;
            height: auto;
        }
        .gallery-label {
            background-color: #18181b;
            color: #22c55e;
            font-size: 7px;
            padding: 6px 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* List Styling */
        ul {
            margin: 8px 0;
            padding-left: 0;
            list-style: none;
        }
        li {
            position: relative;
            padding-left: 15px;
            margin-bottom: 5px;
            color: #52525b;
            font-size: 9pt;
        }
        li:before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            width: 6px;
            height: 6px;
            background-color: #22c55e;
        }

        /* Accreditation Badges */
        .accred-row {
            width: 100%;
            margin: 15px 0;
        }
        .accred-row td {
            width: 25%;
            text-align: center;
            padding: 12px 8px;
            vertical-align: top;
        }
        .accred-badge {
            display: inline-block;
            background-color: #22c55e;
            color: #18181b;
            font-size: 10px;
            font-weight: bold;
            padding: 8px 16px;
            margin-bottom: 5px;
        }
        .accred-badge.dark {
            background-color: #18181b;
            color: #22c55e;
        }
        .accred-name {
            font-size: 7px;
            color: #71717a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Contact Section */
        .contact-section {
            background-color: #18181b;
            padding: 30px;
            margin-top: 25px;
        }
        .contact-section h2 {
            color: white;
            margin-top: 0;
            font-size: 16px;
        }
        .contact-section h3 {
            color: #22c55e;
            margin-top: 15px;
        }
        .contact-section p {
            color: #a1a1aa;
            font-size: 9pt;
        }
        .contact-highlight {
            color: #22c55e;
            font-weight: bold;
        }

        /* Footer */
        .page-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e4e4e7;
            margin-top: 25px;
        }
        .footer-tagline {
            font-size: 10px;
            color: #22c55e;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .footer-company {
            font-size: 8px;
            color: #a1a1aa;
            margin-top: 5px;
        }

        /* Sector boxes */
        .sector-box {
            background-color: #fafafa;
            padding: 15px;
            margin-bottom: 10px;
        }
        .sector-box h3 {
            color: #18181b;
            border-bottom: 2px solid #22c55e;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- ==========================================
         COVER PAGE
         ========================================== -->
    <div class="cover">
        <div class="cover-left">
            <img src="{{ public_path('images/logo.png') }}" class="cover-logo" alt="KMG">

            <div class="cover-year">Company Profile 2025</div>
            <div class="cover-title">Environmental<br>Excellence.<br>Delivered.</div>
            <div class="cover-subtitle">
                South Africa's trusted environmental consultancy. Accredited specialists delivering regulation-aligned solutions across the SADC region.
            </div>

            <div class="cover-stat-row">
                <div class="cover-stat-number">13+</div>
                <div class="cover-stat-label">Years of Excellence</div>
            </div>
            <div class="cover-stat-row">
                <div class="cover-stat-number">100+</div>
                <div class="cover-stat-label">Projects Delivered</div>
            </div>

            <div class="cover-footer">
                <div class="cover-contact-line">011 480 4822 / 011 969 6184</div>
                <div class="cover-contact-line">info@kmgenviro.co.za</div>
                <div class="cover-contact-line">www.kmgenviro.co.za</div>
                <div class="cover-badges">
                    <span class="cover-badge">DoEL APPROVED</span>
                    <span class="cover-badge">SACNASP</span>
                    <span class="cover-badge">EAPASA</span>
                    <span class="cover-badge">B-BBEE LEVEL 2</span>
                </div>
            </div>
        </div>
        <div class="cover-right"></div>
    </div>

    <!-- ==========================================
         PAGE 2: ABOUT US
         ========================================== -->
    <div class="page">
        <div class="accent-bar"></div>
        <div class="page-inner">
            <div class="page-top">
                <span class="page-number">01 / ABOUT</span>
            </div>

            <div class="section-label">Who We Are</div>
            <div class="section-title">Leading Environmental<br>Consultancy in Africa</div>
            <div class="section-line"></div>

            <table class="two-col">
                <tr>
                    <td style="width: 55%;">
                        <p class="lead">KMG Environmental Solutions is a premier South African environmental consultancy delivering comprehensive services across environmental management, ESG compliance, occupational hygiene, and professional training.</p>

                        <p>With a multidisciplinary team of SACNASP-registered scientists, EAPASA-accredited practitioners, and SAIOH occupational hygienists, we bring together expertise spanning environmental science, chemistry, waste management, and regulatory compliance.</p>

                        <p>Our commitment to scientific excellence and professional integrity has made us the trusted partner for clients in mining, industrial, infrastructure, and renewable energy sectors across South Africa and the SADC region.</p>
                    </td>
                    <td style="width: 45%;">
                        <img src="{{ public_path('images/gallery/team-fieldwork.jpg') }}" style="width: 100%; margin-bottom: 10px;">

                        <div class="feature-box" style="margin-top: 0;">
                            <h3>Our Mission</h3>
                            <p>Delivering scientifically robust solutions that protect ecosystems, ensure compliance, and enable sustainable development.</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table class="stats-row">
                <tr>
                    <td class="stat-cell dark">
                        <div class="stat-num">13+</div>
                        <div class="stat-lbl">Years Experience</div>
                    </td>
                    <td class="stat-cell">
                        <div class="stat-num">100+</div>
                        <div class="stat-lbl">Projects Completed</div>
                    </td>
                    <td class="stat-cell dark">
                        <div class="stat-num">9</div>
                        <div class="stat-lbl">SA Provinces</div>
                    </td>
                    <td class="stat-cell">
                        <div class="stat-num">L2</div>
                        <div class="stat-lbl">B-BBEE Status</div>
                    </td>
                </tr>
            </table>

            <h2>Our Values</h2>
            <table class="two-col">
                <tr>
                    <td>
                        <ul>
                            <li><strong>Integrity</strong> — Honest, ethical conduct in all dealings</li>
                            <li><strong>Excellence</strong> — Highest scientific standards</li>
                            <li><strong>Sustainability</strong> — Environmental stewardship</li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li><strong>Professionalism</strong> — Registered, accredited expertise</li>
                            <li><strong>Innovation</strong> — Modern solutions to challenges</li>
                            <li><strong>Partnership</strong> — Collaborative client relationships</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- ==========================================
         PAGE 3: CORE SERVICES
         ========================================== -->
    <div class="page">
        <div class="accent-bar"></div>
        <div class="page-inner">
            <div class="page-top">
                <span class="page-number">02 / SERVICES</span>
            </div>

            <div class="section-label">What We Do</div>
            <div class="section-title">Core Services</div>
            <div class="section-line"></div>

            <table class="service-grid">
                <tr>
                    <td class="service-card">
                        <h3>Environmental Monitoring</h3>
                        <p>Water, air, noise & soil monitoring with SANAS-accredited lab analysis. Baseline studies and compliance tracking.</p>
                    </td>
                    <td class="service-card">
                        <h3>Impact Assessments</h3>
                        <p>Full EIA services: Basic Assessments, Scoping & EIR, specialist studies, and Environmental Management Programmes.</p>
                    </td>
                    <td class="service-card">
                        <h3>Permitting & Licensing</h3>
                        <p>AEL, WUL, Waste Management Licenses, and integrated environmental authorisation applications.</p>
                    </td>
                </tr>
                <tr>
                    <td class="service-card">
                        <h3>Waste Management</h3>
                        <p>Waste audits, management plans, hazardous waste classification, and regulatory compliance support.</p>
                    </td>
                    <td class="service-card">
                        <h3>Asbestos Management</h3>
                        <p>DoEL-approved surveys, risk assessments, abatement supervision, air monitoring & clearance certification.</p>
                    </td>
                    <td class="service-card">
                        <h3>ESG & Carbon Advisory</h3>
                        <p>Carbon footprinting, climate risk analysis, GRI/CDP reporting, and net-zero pathway development.</p>
                    </td>
                </tr>
                <tr>
                    <td class="service-card">
                        <h3>Occupational Hygiene</h3>
                        <p>SAIOH-registered workplace exposure assessments, health risk management, and OHS compliance audits.</p>
                    </td>
                    <td class="service-card">
                        <h3>Environmental Auditing</h3>
                        <p>EMPr compliance, legal audits, ISO 14001 gap analysis, and environmental due diligence.</p>
                    </td>
                    <td class="service-card">
                        <h3>CPD Training Courses</h3>
                        <p>SACNASP & EAPASA accredited environmental awareness, EIA, and specialist training programmes.</p>
                    </td>
                </tr>
            </table>

            <table class="gallery-row">
                <tr>
                    <td>
                        <img src="{{ public_path('images/services/water-monitoring.jpg') }}" class="gallery-img">
                        <div class="gallery-label">Water Quality</div>
                    </td>
                    <td>
                        <img src="{{ public_path('images/services/air-monitoring.jpg') }}" class="gallery-img">
                        <div class="gallery-label">Air Monitoring</div>
                    </td>
                    <td>
                        <img src="{{ public_path('images/services/soil-sampling.jpg') }}" class="gallery-img">
                        <div class="gallery-label">Soil Analysis</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- ==========================================
         PAGE 4: SECTORS & TRAINING
         ========================================== -->
    <div class="page">
        <div class="accent-bar"></div>
        <div class="page-inner">
            <div class="page-top">
                <span class="page-number">03 / EXPERIENCE</span>
            </div>

            <div class="section-label">Industries We Serve</div>
            <div class="section-title">Sector Experience</div>
            <div class="section-line"></div>

            <table class="two-col">
                <tr>
                    <td>
                        <div class="sector-box">
                            <h3>Mining & Resources</h3>
                            <ul>
                                <li>Environmental monitoring programmes</li>
                                <li>Mining right applications & EMPr</li>
                                <li>Closure planning & rehabilitation</li>
                                <li>Water use license applications</li>
                            </ul>
                        </div>

                        <div class="sector-box">
                            <h3>Energy & Renewables</h3>
                            <ul>
                                <li>Solar PV plant assessments</li>
                                <li>Wind farm environmental studies</li>
                                <li>Power line EIAs</li>
                                <li>Battery storage facilities</li>
                            </ul>
                        </div>
                    </td>
                    <td>
                        <div class="sector-box">
                            <h3>Infrastructure & Transport</h3>
                            <ul>
                                <li>Road & rail environmental assessments</li>
                                <li>Water & sanitation projects</li>
                                <li>Telecommunications infrastructure</li>
                                <li>Port and logistics facilities</li>
                            </ul>
                        </div>

                        <div class="sector-box">
                            <h3>Industrial & Commercial</h3>
                            <ul>
                                <li>Manufacturing facility compliance</li>
                                <li>Property development EIAs</li>
                                <li>Retail & commercial projects</li>
                                <li>Industrial park planning</li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="feature-box">
                <h3>Geographic Coverage</h3>
                <p><strong style="color: #22c55e;">South Africa:</strong> All nine provinces with head office in Johannesburg.<br>
                <strong style="color: #22c55e;">SADC Region:</strong> Lesotho, Botswana, Mozambique, Namibia, eSwatini, Zimbabwe.</p>
            </div>

            <h2>CPD Accredited Training</h2>
            <p>SACNASP and EAPASA accredited training provider. Our courses award CPD points for registered professionals.</p>

            <table class="two-col">
                <tr>
                    <td>
                        <ul>
                            <li><strong>Environmental Impact Assessment</strong> — 2 days</li>
                            <li><strong>Workplace Environmental Awareness</strong> — 1 day</li>
                            <li><strong>Safety File Compilation</strong> — 1 day</li>
                        </ul>
                    </td>
                    <td>
                        <ul>
                            <li><strong>Water Quality Management</strong> — 1 day</li>
                            <li><strong>Waste Management Compliance</strong> — 1 day</li>
                            <li><strong>Custom Corporate Programmes</strong> — On request</li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- ==========================================
         PAGE 5: CAPABILITIES & EQUIPMENT
         ========================================== -->
    <div class="page">
        <div class="accent-bar"></div>
        <div class="page-inner">
            <div class="page-top">
                <span class="page-number">04 / CAPABILITIES</span>
            </div>

            <div class="section-label">Our Resources</div>
            <div class="section-title">Equipment & Expertise</div>
            <div class="section-line"></div>

            <p class="lead">We maintain a comprehensive fleet of calibrated monitoring equipment for project deployment and rental services.</p>

            <table class="two-col">
                <tr>
                    <td>
                        <h2>Air Quality</h2>
                        <ul>
                            <li>Personal dust samplers (PM10, PM2.5, TSP)</li>
                            <li>Real-time particulate monitors</li>
                            <li>Gas detection equipment</li>
                            <li>Portable weather stations</li>
                        </ul>

                        <h2>Noise Monitoring</h2>
                        <ul>
                            <li>Type 1 & 2 sound level meters</li>
                            <li>Personal noise dosimeters</li>
                            <li>Octave band analysers</li>
                            <li>Environmental noise monitors</li>
                        </ul>
                    </td>
                    <td>
                        <h2>Water Quality</h2>
                        <ul>
                            <li>Multi-parameter water quality meters</li>
                            <li>Portable pH & conductivity meters</li>
                            <li>Turbidity meters</li>
                            <li>Professional sampling equipment</li>
                        </ul>

                        <h2>Survey & Specialist</h2>
                        <ul>
                            <li>Soil sampling equipment</li>
                            <li>GPS surveying instruments</li>
                            <li>Thermal imaging cameras</li>
                            <li>Drone for aerial surveys</li>
                        </ul>
                    </td>
                </tr>
            </table>

            <table class="gallery-row">
                <tr>
                    <td>
                        <img src="{{ public_path('images/gallery/monitoring-coal-mine.jpg') }}" class="gallery-img">
                        <div class="gallery-label">Mining Sites</div>
                    </td>
                    <td>
                        <img src="{{ public_path('images/gallery/team-monitoring-mountains.jpg') }}" class="gallery-img">
                        <div class="gallery-label">Remote Areas</div>
                    </td>
                    <td>
                        <img src="{{ public_path('images/gallery/team-soil-sampling.jpg') }}" class="gallery-img">
                        <div class="gallery-label">Soil Studies</div>
                    </td>
                </tr>
            </table>

            <div class="feature-box">
                <h3>Quality Assurance & Laboratory Network</h3>
                <p>All equipment calibrated to international standards with detailed records. We partner with SANAS-accredited laboratories for sample analysis, ensuring results meet regulatory requirements.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================
         PAGE 6: ACCREDITATIONS & CONTACT
         ========================================== -->
    <div class="page" style="page-break-after: avoid;">
        <div class="accent-bar"></div>
        <div class="page-inner">
            <div class="page-top">
                <span class="page-number">05 / CONTACT</span>
            </div>

            <div class="section-label">Credentials</div>
            <div class="section-title">Accreditations</div>
            <div class="section-line"></div>

            <p>Our professional registrations demonstrate commitment to excellence and regulatory compliance:</p>

            <table class="accred-row">
                <tr>
                    <td>
                        <span class="accred-badge">DoEL</span><br>
                        <span class="accred-name">Approved Asbestos<br>Contractor</span>
                    </td>
                    <td>
                        <span class="accred-badge">SACNASP</span><br>
                        <span class="accred-name">Registered<br>Professionals</span>
                    </td>
                    <td>
                        <span class="accred-badge">EAPASA</span><br>
                        <span class="accred-name">Accredited EAPs &<br>Training Provider</span>
                    </td>
                    <td>
                        <span class="accred-badge">SAIOH</span><br>
                        <span class="accred-name">Occupational<br>Hygienists</span>
                    </td>
                </tr>
            </table>
            <table class="accred-row">
                <tr>
                    <td>
                        <span class="accred-badge">GBCSA</span><br>
                        <span class="accred-name">Green Building<br>Council SA</span>
                    </td>
                    <td>
                        <span class="accred-badge">WISA</span><br>
                        <span class="accred-name">Water Institute<br>of Southern Africa</span>
                    </td>
                    <td>
                        <span class="accred-badge">IAIAsa</span><br>
                        <span class="accred-name">Impact Assessment<br>Association</span>
                    </td>
                    <td>
                        <span class="accred-badge">B-BBEE L2</span><br>
                        <span class="accred-name">Level 2<br>Contributor</span>
                    </td>
                </tr>
            </table>

            <div class="contact-section">
                <h2>Get In Touch</h2>
                <table class="two-col">
                    <tr>
                        <td>
                            <h3>Head Office</h3>
                            <p>
                                08 Hillside Road<br>
                                Metropolitan Building, 1st Floor B<br>
                                Parktown, Johannesburg, 2193<br>
                                South Africa
                            </p>
                        </td>
                        <td>
                            <h3>Contact Details</h3>
                            <p>
                                <span class="contact-highlight">Tel:</span> 011 480 4822 / 011 969 6184<br>
                                <span class="contact-highlight">Cell:</span> 072 546 3191<br>
                                <span class="contact-highlight">Email:</span> info@kmgenviro.co.za<br>
                                <span class="contact-highlight">Training:</span> bookings@kmgenviro.co.za<br>
                                <span class="contact-highlight">Web:</span> www.kmgenviro.co.za
                            </p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="page-footer">
                <img src="{{ public_path('images/logo.png') }}" style="width: 120px; margin-bottom: 15px;">
                <div class="footer-tagline">Your Partner in Environmental Excellence</div>
                <div class="footer-company">KMG Environmental Solutions (Pty) Ltd</div>
            </div>
        </div>
    </div>

</body>
</html>
