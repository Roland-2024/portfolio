<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ $profile->intro }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $profile->name }} OS | Portfolio</title>
  <link rel="icon" href="{{ asset('assets/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body class="startup-pending">
  <section class="boot-screen" id="boot-screen" aria-label="Roland OS is starting">
    <button class="startup-skip" id="startup-skip" type="button">Skip startup</button>
    <div class="boot-loading">
      <div class="os-brand"><span class="os-symbol"><img src="{{ asset('assets/boot/loading.webp') }}" alt=""></span><span class="os-name">Roland<em>OS</em></span><span class="os-tagline">portfolio system</span></div>
      <div class="boot-progress" aria-label="Loading"><span></span><span></span><span></span></div>
    </div>
    <div class="boot-tip"><span>For the best experience</span><strong>Turn your sound on</strong></div>
    <img class="boot-wordmark" src="{{ asset('assets/boot/boot-wordmark.webp') }}" alt="">
  </section>

  <section class="login-overlay" id="login-screen" aria-label="Log in to Roland OS">
    <div class="login-panel">
      <div class="login-copy">
        <div class="os-brand"><span class="os-symbol"><img src="{{ asset('assets/boot/loading.webp') }}" alt=""></span><span class="os-name">Roland<em>OS</em></span><span class="os-tagline">portfolio system</span></div>
        <p>To begin, click on <strong>{{ $profile->name }}</strong> to log in</p>
      </div>
      <div class="login-divider" aria-hidden="true"></div>
      <button class="login-user" id="login-user" type="button"><img src="{{ $profile->profile_image_url }}" alt="Portrait of {{ $profile->name }}"><span><strong>{{ $profile->name }}</strong><small>{{ $profile->title }}</small></span></button>
    </div>
    <button class="login-restart" id="login-restart" type="button"><img src="{{ asset('assets/start-menu/restart.webp') }}" alt=""><span>Restart System</span></button>
    <p class="login-detail">After you log on, the system is yours to explore.</p>
  </section>

  <div class="welcome-screen" id="welcome-screen" aria-live="polite">welcome</div>

  <main class="desktop" id="desktop">
    <h1 class="sr-only">{{ $profile->name }} developer portfolio</h1>
    <section class="desktop-icons" aria-label="Desktop applications">
      <button class="desktop-icon" data-open="about"><img src="{{ asset('assets/desktop/about.webp') }}" alt=""><span class="desktop-icon-label">About Me</span></button>
      <button class="desktop-icon" data-open="resume"><img src="{{ asset('assets/desktop/resume.webp') }}" alt=""><span class="desktop-icon-label">My Resume</span></button>
      <button class="desktop-icon" data-open="projects"><img src="{{ asset('assets/desktop/projects.webp') }}" alt=""><span class="desktop-icon-label">My Projects</span></button>
      <button class="desktop-icon" data-open="contact"><img src="{{ asset('assets/desktop/contact.webp') }}" alt=""><span class="desktop-icon-label">Contact Me</span></button>
    </section>

    <section class="window" id="window-about" data-window="about" aria-label="About Me window">
      <div class="titlebar"><img class="title-icon" src="{{ asset('assets/desktop/about.webp') }}" alt=""><strong>About Me</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="edit">Edit</button><button data-menu="view">View</button><button data-menu="favorites">Favorites</button><button data-menu="help">Help</button></div>
      <div class="toolbar"><button class="soft-button" data-history="-1">&larr; <span>Back</span></button><button class="soft-button" data-history="1">&rarr; <span>Forward</span></button><button class="soft-button" data-open="projects"><span>Projects</span></button><button class="soft-button" data-open="resume"><span>Resume</span></button></div>
      <div class="address-bar"><span>Address</span><input class="address-input" value="roland://about" aria-label="About address"><button data-address-go>Go</button></div>
      <div class="window-content about-content">
        <aside class="sidebar">
          <div class="side-card"><button class="side-card-title" data-collapse-panel>Links & Contact <span>^</span></button><div class="side-card-body">@foreach($socialLinks as $link)<a href="{{ $link->url }}" target="_blank" rel="noopener">{{ $link->label }}</a>@endforeach<a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a></div></div>
          <div class="side-card"><button class="side-card-title" data-collapse-panel>Skills <span>^</span></button><div class="side-card-body">@foreach($skills->keys()->take(5) as $category)<p>{{ $category }}</p>@endforeach</div></div>
          <div class="side-card"><button class="side-card-title" data-collapse-panel>Toolbox <span>^</span></button><div class="side-card-body">@foreach($skills->flatten()->take(8) as $skill)<p>{{ $skill->name }}</p>@endforeach</div></div>
        </aside>
        <article class="about-main">
          <img class="profile-portrait" src="{{ $profile->profile_image_url }}" alt="Portrait of {{ $profile->name }}">
          <p class="eyebrow">{{ $profile->title }}</p><h2>{{ $profile->name }}</h2><p>{{ $profile->bio }}</p>@if($profile->secondary_bio)<p>{{ $profile->secondary_bio }}</p>@endif
          <div class="stat-grid"><div><strong>{{ $profile->years_experience }}+</strong><span>Years in web development</span></div><div><strong>{{ $profile->full_stack_years }}+</strong><span>Years full stack</span></div><div><strong>{{ $skills->flatten()->count() }}</strong><span>Technologies & capabilities</span></div></div>
        </article>
      </div>
      <div class="statusbar">Welcome. Have a look around.</div>
    </section>

    <section class="window" id="window-projects" data-window="projects" aria-label="Projects window">
      <div class="titlebar"><img class="title-icon" src="{{ asset('assets/desktop/projects.webp') }}" alt=""><strong>My Projects</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="edit">Edit</button><button data-menu="view">View</button><button data-menu="favorites">Favorites</button><button data-menu="help">Help</button></div>
      <div class="toolbar"><button class="soft-button" data-open="about">Home</button><button class="soft-button" data-history="-1">&larr; Back</button><button class="soft-button" data-history="1">&rarr; Forward</button><button class="soft-button" data-project-search>Search</button><button class="soft-button" data-project-folders>Folders</button></div>
      <div class="address-bar"><span>Address</span><input class="address-input" value="roland://projects" aria-label="Projects address"><button data-address-go>Go</button></div>
      <div class="window-content projects-content">
        <div class="project-tools" id="project-tools">
          <label class="project-search">Search projects<input id="project-search-input" type="search" placeholder="Type a title, category, or skill"></label>
          <div class="project-folders" id="project-folders"><button data-project-filter="all">All Projects</button>@foreach($projects->pluck('category')->unique() as $category)<button data-project-filter="{{ Str::slug($category) }}">{{ $category }}</button>@endforeach</div>
        </div>
        <div class="projects-heading"><div><p class="eyebrow">Professional capabilities</p><h2>Solutions I build</h2></div>@if($profile->upwork_url)<a class="online-pill" href="{{ $profile->upwork_url }}" target="_blank" rel="noopener">{{ $profile->availability ?: 'Available on Upwork' }}</a>@endif</div>
        <div class="project-grid">
          @foreach($projects as $project)<article class="project-card {{ $project->color }}" data-project-card data-category="{{ Str::slug($project->category) }}">@if($project->image_url)<img class="project-image" src="{{ $project->image_url }}" alt="">@endif<span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ strtoupper($project->category) }}</span><h3>{{ $project->title }}</h3><p>{{ $project->description }}</p>@if($project->url)<a href="{{ $project->url }}" target="_blank" rel="noopener">Open project &rarr;</a>@endif</article>@endforeach
        </div>
      </div>
      <div class="statusbar">{{ $projects->count() }} objects</div>
    </section>

    <section class="window compact-window" id="window-resume" data-window="resume" aria-label="Resume window">
      <div class="titlebar"><span class="title-icon">&#128196;</span><strong>My Resume</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="edit">Edit</button><button data-menu="view">View</button><button data-menu="favorites">Favorites</button><button data-menu="help">Help</button></div>
      <div class="toolbar"><button class="soft-button" data-history="-1">&larr; Back</button><button class="soft-button" data-history="1">&rarr; Forward</button><button class="soft-button" data-command="print">Print</button><button class="soft-button" data-open="contact">Contact</button></div>
      <div class="address-bar"><span>Address</span><input class="address-input" value="roland://resume" aria-label="Resume address"><button data-address-go>Go</button></div>
      <div class="resume-content">
        <header><div><p class="eyebrow">Curriculum vitae</p><h2>{{ $profile->name }}</h2><p>{{ $profile->title }} &middot; {{ $profile->location }}</p></div><button class="xp-button" onclick="window.print()">Print / Save PDF</button></header><hr>
        <section><h3>Profile</h3><p>{{ $profile->intro }}</p></section>
        <section><h3>Core Technologies</h3><p>{{ $skills->flatten()->pluck('name')->join(', ') }}.</p></section>
        <section class="experience-list"><h3>Professional Experience</h3>@foreach($experiences as $experience)<div class="resume-row"><strong>{{ $experience->role }} &middot; {{ $experience->company }}@if($experience->location), {{ $experience->location }}@endif</strong><span>{{ $experience->date_range }}</span></div><p>{{ $experience->description }}</p>@endforeach</section>
        <section><h3>Education</h3>@foreach($education as $item)<div class="resume-row"><strong>{{ $item->qualification }} &middot; {{ $item->institution }}</strong><span>{{ $item->date_range }}</span></div>@if($item->description)<p>{{ $item->description }}</p>@endif @endforeach</section>
        <section><h3>Languages</h3><p>{{ $profile->languages }}</p></section>
        <section><h3>Contact</h3><p><a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>@if($profile->website) &middot; <a href="{{ $profile->website }}" target="_blank" rel="noopener">{{ parse_url($profile->website, PHP_URL_HOST) }}</a>@endif @if($profile->phone) &middot; {{ $profile->phone }}@endif</p></section>
      </div>
      <div class="statusbar">Page 1 of 1</div>
    </section>

    <section class="window compact-window" id="window-contact" data-window="contact" aria-label="Contact window">
      <div class="titlebar"><span class="title-icon">&#9993;</span><strong>Contact Me</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="edit">Edit</button><button data-menu="view">View</button><button data-menu="favorites">Favorites</button><button data-menu="help">Help</button></div>
      <div class="toolbar"><button class="soft-button" data-history="-1">&larr; Back</button><button class="soft-button" data-history="1">&rarr; Forward</button><button class="soft-button" data-open="about">About</button><button class="soft-button" data-command="focus-contact">Write Message</button></div>
      <div class="address-bar"><span>Address</span><input class="address-input" value="roland://contact" aria-label="Contact address"><button data-address-go>Go</button></div>
      <div class="contact-content">
        <div class="contact-intro"><span class="big-mail">&#9993;</span><div><p class="eyebrow">Contact {{ $profile->name }}</p><h2>Let's build something useful.</h2><p>Email me at <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>, or use the form below.</p></div></div>
        <form id="contact-form" action="{{ route('contact.store') }}"><label>Your name<input required name="name" placeholder="Jane Smith"></label><label>Your email<input required type="email" name="email" placeholder="jane@example.com"></label><label>Message<textarea required name="message" rows="5" placeholder="Hello Roland..."></textarea></label><button class="xp-button" type="submit">Send message</button><span id="form-status" role="status"></span></form>
      </div>
      <div class="statusbar">Ready</div>
    </section>

    <section class="window compact-window utility-window" id="window-music" data-window="music" aria-label="Music Player window">
      <div class="titlebar"><img class="title-icon" src="{{ asset('assets/start-menu/music.webp') }}" alt=""><strong>Music Player</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="view">View</button><button data-menu="favorites">Favorites</button><button data-menu="help">Help</button></div>
      <div class="toolbar"><button class="soft-button" data-history="-1">&larr; Back</button><button class="soft-button" data-history="1">&rarr; Forward</button><button class="soft-button" data-open="media">Media Player</button></div>
      <div class="address-bar"><span>Address</span><input class="address-input" value="roland://music" aria-label="Music address"><button data-address-go>Go</button></div>
      <div class="utility-content music-player"><h2>Roland OS Sounds</h2><p>Select a system sound to preview it.</p><div class="playlist"><button data-audio-src="{{ asset('assets/sounds/login.wav') }}">Startup sound</button><button data-audio-src="{{ asset('assets/sounds/balloon.wav') }}">Notification sound</button><button data-audio-src="{{ asset('assets/sounds/logoff.wav') }}">Logoff sound</button></div><audio id="music-audio" controls></audio></div>
      <div class="statusbar">Ready to play</div>
    </section>

    <section class="window compact-window utility-window" id="window-media" data-window="media" aria-label="Media Player window">
      <div class="titlebar"><img class="title-icon" src="{{ asset('assets/start-menu/mediaPlayer.webp') }}" alt=""><strong>Media Player</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="view">View</button><button data-menu="favorites">Favorites</button><button data-menu="help">Help</button></div>
      <div class="toolbar"><button class="soft-button" data-history="-1">&larr; Back</button><button class="soft-button" data-history="1">&rarr; Forward</button><button class="soft-button" data-media-action="play">Play</button><button class="soft-button" data-media-action="stop">Stop</button></div>
      <div class="address-bar"><span>Address</span><input class="address-input" value="roland://media" aria-label="Media address"><button data-address-go>Go</button></div>
      <div class="utility-content media-player"><div class="media-screen"><img id="media-preview" data-src="{{ asset('assets/start-menu/userlogin.gif') }}" src="{{ asset('assets/start-menu/userlogin.gif') }}" alt="Roland OS animated media"></div><h2>Roland OS Welcome Animation</h2><p>Use the toolbar to play or stop the animation.</p></div>
      <div class="statusbar">Playing</div>
    </section>

    <section class="window utility-window" id="window-paint" data-window="paint" aria-label="Paint window">
      <div class="titlebar"><img class="title-icon" src="{{ asset('assets/start-menu/paint.webp') }}" alt=""><strong>Paint</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="edit">Edit</button><button data-menu="view">View</button><button data-menu="help">Help</button></div>
      <div class="toolbar paint-toolbar"><button class="soft-button" data-paint-action="clear">New</button><label>Color <input id="paint-color" type="color" value="#075aca"></label><label>Brush <input id="paint-size" type="range" min="2" max="24" value="5"></label><button class="soft-button" data-paint-action="save">Save Image</button></div>
      <div class="address-bar"><span>Address</span><input class="address-input" value="roland://paint" aria-label="Paint address"><button data-address-go>Go</button></div>
      <div class="paint-content"><canvas id="paint-canvas" width="900" height="500" aria-label="Drawing canvas"></canvas></div>
      <div class="statusbar">Drag on the canvas to draw</div>
    </section>

    <section class="window compact-window utility-window" id="window-terminal" data-window="terminal" aria-label="Command Prompt window">
      <div class="titlebar"><img class="title-icon" src="{{ asset('assets/start-menu/cmd.webp') }}" alt=""><strong>Command Prompt</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="edit">Edit</button><button data-menu="view">View</button><button data-menu="help">Help</button></div>
      <div class="terminal-content"><pre id="terminal-output">Roland OS Command Prompt
Type "help" to see available commands.</pre><form id="terminal-form"><label>C:\Portfolio&gt; <input id="terminal-input" autocomplete="off" spellcheck="false"></label></form></div>
      <div class="statusbar">Commands: help, about, skills, projects, contact, clear, date</div>
    </section>

    <section class="window compact-window utility-window" id="window-viewer" data-window="viewer" aria-label="Image Viewer window">
      <div class="titlebar"><img class="title-icon" src="{{ asset('assets/start-menu/photos.webp') }}" alt=""><strong>Image Viewer</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">&#9633;</button><button data-action="close" aria-label="Close">&times;</button></div></div>
      <div class="menu-bar"><button data-menu="file">File</button><button data-menu="view">View</button><button data-menu="favorites">Favorites</button><button data-menu="help">Help</button></div>
      <div class="toolbar"><button class="soft-button" data-viewer-action="-1">&larr; Previous</button><button class="soft-button" data-viewer-action="1">Next &rarr;</button><button class="soft-button" data-command="fullscreen">Full Screen</button></div>
      <div class="address-bar"><span>Address</span><input class="address-input" value="roland://viewer" aria-label="Viewer address"><button data-address-go>Go</button></div>
      <div class="viewer-content" data-images='@json([asset("assets/profile/roland-cartoon.png"), asset("assets/wallpaper/roland-portfolio.png"), asset("assets/boot/boot-wordmark.webp")])'><img id="viewer-image" src="{{ asset('assets/profile/roland-cartoon.png') }}" alt="Portfolio image"></div>
      <div class="statusbar" id="viewer-status">Image 1 of 3</div>
    </section>

    <aside class="start-menu" id="start-menu" aria-label="Start menu">
      <header><span class="start-avatar" style="background-image:url('{{ $profile->profile_image_url }}')">R</span><strong>{{ $profile->name }}</strong></header>
      <div class="start-columns">
        <div class="start-left">
          <button data-open="projects"><span></span><b>My Projects<small>View my work</small></b></button><button data-open="contact"><span></span><b>Contact Me<small>Send a message</small></b></button><hr>
          <button data-open="about"><span></span>About Me</button><button data-open="music"><span></span>Music Player</button><button data-open="media"><span></span>Media Player</button><button data-open="paint"><span></span>Paint</button>
          <button class="all-programs" id="all-programs-button" type="button" aria-expanded="false" aria-controls="all-programs-menu"><strong>All Programs</strong><img src="{{ asset('assets/start-menu/arrow.webp') }}" alt=""></button>
        </div>
        <div class="start-right">@foreach($socialLinks->take(4) as $link)<a href="{{ $link->url }}" target="_blank" rel="noopener">{{ $link->label }}</a>@endforeach<hr><button data-open="resume">My Resume</button><button data-open="terminal">Command Prompt</button><button data-open="viewer">Image Viewer</button></div>
      </div>
      <footer><button id="logoff-button">Log Off</button><button id="shutdown-button">Shut Down</button></footer>
    </aside>

    <aside class="all-programs-menu" id="all-programs-menu" aria-label="All Programs">
      <button data-open="about"><img src="{{ asset('assets/desktop/about.webp') }}" alt=""><span>About Me</span></button><button data-open="projects"><img src="{{ asset('assets/desktop/projects.webp') }}" alt=""><span>My Projects</span></button><button data-open="contact"><img src="{{ asset('assets/desktop/contact.webp') }}" alt=""><span>Contact Me</span></button><button data-open="resume"><img src="{{ asset('assets/desktop/resume.webp') }}" alt=""><span>My Resume</span></button><hr>
      <button data-open="music"><img src="{{ asset('assets/start-menu/music.webp') }}" alt=""><span>Music Player</span></button><button data-open="media"><img src="{{ asset('assets/start-menu/mediaPlayer.webp') }}" alt=""><span>Media Player</span></button><button data-open="paint"><img src="{{ asset('assets/start-menu/paint.webp') }}" alt=""><span>Paint</span></button><button data-open="viewer"><img src="{{ asset('assets/start-menu/photos.webp') }}" alt=""><span>Image Viewer</span></button><button data-open="terminal"><img src="{{ asset('assets/start-menu/cmd.webp') }}" alt=""><span>Command Prompt</span></button>
    </aside>

    <nav class="taskbar" aria-label="Taskbar"><button class="start-button" id="start-button" aria-expanded="false"><span></span>start</button><div class="task-items" id="task-items"></div><div class="system-tray"><button id="welcome-button" title="Show welcome"></button><button id="crt-toggle" title="Toggle CRT effect"></button><button id="fullscreen-toggle" title="Toggle fullscreen"></button><span id="clock">00:00</span></div></nav>
    <div class="crt-overlay" aria-hidden="true"></div><div class="toast" id="toast" role="status">Welcome to Roland OS.</div>
  </main>
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
