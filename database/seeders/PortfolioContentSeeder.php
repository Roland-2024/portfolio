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

        $projects = [
            ['Custom Business Systems', 'Web Applications', 'Maintainable Laravel applications tailored to business workflows.', 'https://github.com/Roland-2024', 'blue'],
            ['WordPress & WooCommerce', 'E-Commerce', 'Custom themes, plugins, ACF integrations, online stores, and performance improvements.', 'https://rolandaga.com', 'orange'],
            ['Scalable Integrations', 'Cloud & APIs', 'REST APIs, microservices, third-party integrations, Azure services, and IoT platforms.', 'https://upwork.com/freelancers/~01454dee02d79b14b8', 'green'],
            ['Deployment & Optimization', 'DevOps', 'Docker, Linux servers, CI/CD pipelines, Cloudflare, security, SEO, and performance.', 'mailto:info@rolandaga.com', 'purple'],
        ];
        foreach ($projects as $index => [$title, $category, $description, $url, $color]) {
            Project::firstOrCreate(compact('title'), compact('category', 'description', 'url', 'color') + ['sort_order' => $index]);
        }

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
