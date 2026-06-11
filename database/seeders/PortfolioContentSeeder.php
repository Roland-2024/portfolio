<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class PortfolioContentSeeder extends Seeder
{
    public function run(): void
    {
        PortfolioProfile::firstOrCreate(['id' => 1], [
            'name' => 'Roland Aga',
            'title' => 'Full Stack Software Developer',
            'location' => 'Tirana, Albania',
            'email' => 'info@rolandaga.com',
            'phone' => '+355 69 977 4907',
            'website' => 'https://rolandaga.com',
            'upwork_url' => 'https://upwork.com/freelancers/~01454dee02d79b14b8',
            'intro' => 'Full Stack Software Developer with 7+ years of web development experience building secure, maintainable web applications, e-commerce platforms, custom business systems, APIs, and cloud solutions.',
            'bio' => 'I am a Full Stack Web Developer specializing in PHP, WordPress, Laravel, React.js, Bootstrap, and Tailwind CSS.',
            'secondary_bio' => 'I build responsive websites, e-commerce platforms, custom web applications, and reliable business solutions from development through deployment and support.',
            'profile_image' => 'assets/profile/roland-cartoon.png',
            'years_experience' => 7,
            'full_stack_years' => 3,
            'availability' => 'Available on Upwork',
            'languages' => 'Albanian - Native; English - Professional working proficiency (B2)',
        ]);

        $skills = [
            'Backend' => ['PHP', 'Laravel', 'REST APIs', 'Microservices', 'JWT Authentication'],
            'Frontend' => ['JavaScript', 'jQuery', 'HTML5', 'CSS3 / SCSS', 'React', 'Responsive Design'],
            'CMS & E-Commerce' => ['WordPress', 'WooCommerce', 'Elementor', 'ACF', 'Custom Themes', 'Custom Plugins'],
            'Databases' => ['MySQL', 'MariaDB', 'SQL Server', 'PostgreSQL', 'PostGIS'],
            'Cloud & DevOps' => ['Microsoft Azure', 'Azure IoT Hub', 'Azure Event Hubs', 'Docker', 'Git', 'GitHub Actions', 'CI/CD Pipelines', 'Linux (Ubuntu)'],
            'Additional' => ['API Integrations', 'Third-Party Services Integration', 'Redis', 'Cloudflare', 'SEO Optimization', 'Performance Optimization', 'Server Management'],
        ];
        $sort = 0;
        foreach ($skills as $category => $items) {
            foreach ($items as $name) {
                Skill::firstOrCreate(compact('category', 'name'), ['sort_order' => $sort++]);
            }
        }

        $experiences = [
            ['Web Developer', '1UP LABS', 'Tirana', '2022-12-01', null, true, 'Develop and maintain websites and software applications, collaborate on priorities and requirements, deliver updates, troubleshoot issues, and review code for quality, standards, structure, and cross-platform compatibility.'],
            ['Web Developer', 'Eri Design Studio', 'Boston (Remote)', '2022-06-01', '2022-12-01', false, 'Designed, implemented, and managed websites; developed custom WordPress themes and plugins; delivered both front-end and back-end development.'],
            ['Web Developer', 'Municipality of Tirana', 'Tirana', '2019-06-01', '2022-12-01', false, 'Built websites, systems, and applications to support daily municipal operations and resolved performance and user-experience issues.'],
            ['Web Developer', 'Diaspora Publishing Center', 'Tirana', '2019-05-01', '2019-07-01', false, 'Developed and maintained organizational websites, optimized performance and user experience, implemented content and design updates, and supported connected website and server systems.'],
            ['Web Developer & Network Administrator', 'Regional Employment Service', 'Tirana', '2017-05-01', '2019-04-01', false, "Maintained the institution's official website, administered networks and IT equipment, standardized information-system technologies, managed users and access, and resolved technical issues."],
            ['Professional Internship', 'Albtelecom & Eagle Mobile', 'Tirana', '2016-05-01', '2016-08-01', false, 'Installed, configured, and maintained IP-TV systems; assisted with interfaces for network-management and online services; worked with networks, servers, databases, and testing environments.'],
        ];
        foreach ($experiences as $index => [$role, $company, $location, $startDate, $endDate, $isCurrent, $description]) {
            Experience::firstOrCreate(compact('role', 'company'), [
                'location' => $location, 'start_date' => $startDate, 'end_date' => $endDate,
                'is_current' => $isCurrent, 'description' => $description, 'sort_order' => $index,
            ]);
        }

        Education::firstOrCreate(
            ['qualification' => "Master's in Information Technology", 'institution' => 'Polytechnic University of Tirana'],
            ['start_year' => 2016, 'end_year' => 2017, 'sort_order' => 0]
        );
        Education::firstOrCreate(
            ['qualification' => "Bachelor's in Telecommunications Engineering", 'institution' => 'Polytechnic University of Tirana'],
            ['sort_order' => 1]
        );

        Project::firstOrCreate(
            ['title' => 'MediGreen Pharmacy E-commerce Website with Odoo Integration'],
            [
                'category' => 'E-Commerce',
                'description' => 'Built a custom WordPress theme from scratch for an online pharmacy/e-commerce website, using Tailwind CSS for the frontend and WooCommerce for product sales. Integrated the website with Odoo so products, stock, and pricing can sync from the ERP into the store. Developed a responsive, modern interface optimized for both desktop and mobile, with a custom design focused on usability, speed, and clean product presentation.',
                'url' => 'https://medigreen.al/',
                'image' => 'assets/projects/medigreen-mockup.webp',
                'color' => 'green',
                'sort_order' => -60,
                'is_published' => true,
            ]
        );

        Project::firstOrCreate(
            ['title' => 'FirstStore.al - WooCommerce E-commerce Platform'],
            [
                'category' => 'E-Commerce',
                'description' => 'Developed a custom WooCommerce e-commerce website for FirstStore, an online store focused on camping and outdoor products. Built and customized the WordPress theme, configured WooCommerce, optimized performance, and ensured a responsive shopping experience across devices. Integrated Odoo ERP with WooCommerce to sync products, stock levels, and orders, enabling centralized inventory and order management. Implemented a scalable, SEO-friendly setup to support smooth and reliable online sales operations.',
                'url' => 'https://firststore.al/',
                'image' => 'assets/projects/firststore-mockup.webp',
                'color' => 'blue',
                'sort_order' => -50,
                'is_published' => true,
            ]
        );

        Project::firstOrCreate(
            ['title' => 'Custom WordPress Website for UK Accounting Firm (AL-TAX LTD)'],
            [
                'category' => 'WordPress',
                'description' => 'Developed a bespoke WordPress theme for AL-TAX LTD, a UK-based accounting firm. Delivered a fast, SEO-optimized site featuring custom post types for services and projects, Google reCAPTCHA-secured forms, and GDPR-ready cookie policy integration. Implemented caching, schema, responsive layout, and multilingual readiness using lightweight plugins. Client now has full CMS control.',
                'url' => 'https://al-tax.co.uk/',
                'image' => 'assets/projects/al-tax-mockup.webp',
                'color' => 'green',
                'sort_order' => -40,
                'is_published' => true,
            ]
        );

        Project::firstOrCreate(
            ['title' => 'Euronews Albania'],
            [
                'category' => 'WordPress',
                'description' => 'Developed a custom WordPress theme from scratch for Euronews Albania, a high-traffic editorial news platform. Implemented YouTube integration for video and live content, and connected Google Analytics (GA4) via API for tracking user behavior and performance. Focused on PHP-based WordPress development, performance optimization, SEO-friendly structure, and improving the editorial publishing workflow to ensure speed, stability, and scalability across desktop and mobile under heavy traffic.',
                'url' => 'https://euronews.al/',
                'image' => 'assets/projects/euronews-albania-mockup.webp',
                'color' => 'blue',
                'sort_order' => -30,
                'is_published' => true,
            ]
        );

        Project::firstOrCreate(
            ['title' => 'Football Betting Tips & Predictions Website'],
            [
                'category' => 'WordPress',
                'description' => 'Designed and developed a fully dynamic football betting tips website using WordPress. Built custom post types for matches, integrated Advanced Custom Fields (ACF) for intuitive content management, and optimized site performance for speed and SEO. Implemented structured data, Cloudflare performance enhancements, and responsive design, resulting in increased user engagement, improved search rankings, and higher organic traffic.',
                'url' => 'https://betprofe.com/',
                'image' => 'assets/projects/betprofe-mockup.webp',
                'color' => 'orange',
                'sort_order' => -10,
                'is_published' => true,
            ]
        );

        Project::firstOrCreate(
            ['title' => 'DasWeltAuto - Certified Used Cars Platform (Albania)'],
            [
                'category' => 'Full-Stack Web Development',
                'description' => "DasWeltAuto is Volkswagen Group's certified used car platform in Albania. As a Full-Stack Developer, I built a fast, responsive, and SEO-optimized website where users can browse and compare guaranteed vehicles. I handled both front-end and back-end development, integrated RESTful APIs, and ensured seamless data flow, strong performance, and a modern user experience across all devices.",
                'url' => 'https://dasweltauto.al/',
                'image' => 'assets/projects/dasweltauto-mockup.webp',
                'color' => 'orange',
                'sort_order' => -20,
                'is_published' => true,
            ]
        );

        $links = [
            ['instagram', 'Instagram', 'https://www.instagram.com/roland_aga/'],
            ['github', 'GitHub', 'https://github.com/Roland-2024'],
            ['linkedin', 'LinkedIn', 'https://www.linkedin.com/in/roland-aga-a74906146/'],
            ['upwork', 'Upwork', 'https://upwork.com/freelancers/~01454dee02d79b14b8'],
            ['website', 'rolandaga.com', 'https://rolandaga.com'],
            ['whatsapp', 'WhatsApp', 'https://wa.me/355699774907'],
        ];
        foreach ($links as $index => [$platform, $label, $url]) {
            SocialLink::firstOrCreate(compact('platform'), compact('label', 'url') + ['sort_order' => $index]);
        }
    }
}
