<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="A playful desktop-inspired developer portfolio.">
  <title>Roland OS | Portfolio</title>
  <link rel="icon" href="{{ asset('assets/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body class="startup-pending">
  <section class="boot-screen" id="boot-screen" aria-label="Roland OS is starting">
    <button class="startup-skip" id="startup-skip" type="button">Skip startup</button>
    <div class="boot-loading">
      <div class="os-brand" aria-label="Roland OS">
        <span class="os-symbol"><img src="{{ asset('assets/boot/loading.webp') }}" alt=""></span>
        <span class="os-name">Roland<em>OS</em></span>
        <span class="os-tagline">portfolio system</span>
      </div>
      <div class="boot-progress" aria-label="Loading">
        <span></span><span></span><span></span>
      </div>
    </div>
    <div class="boot-tip"><span>For the best experience</span><strong>Turn your sound on</strong></div>
    <img class="boot-wordmark" src="{{ asset('assets/boot/boot-wordmark.webp') }}" alt="">
  </section>

  <section class="login-overlay" id="login-screen" aria-label="Log in to Roland OS">
    <div class="login-panel">
      <div class="login-copy">
        <div class="os-brand" aria-label="Roland OS">
          <span class="os-symbol"><img src="{{ asset('assets/boot/loading.webp') }}" alt=""></span>
          <span class="os-name">Roland<em>OS</em></span>
          <span class="os-tagline">portfolio system</span>
        </div>
        <p>To begin, click on <strong>Roland</strong> to log in</p>
      </div>
      <div class="login-divider" aria-hidden="true"></div>
      <button class="login-user" id="login-user" type="button">
        <img src="{{ asset('assets/start-menu/userlogin.gif') }}" alt="">
        <span><strong>Roland</strong><small>Web Developer</small></span>
      </button>
    </div>
    <button class="login-restart" id="login-restart" type="button">
      <img src="{{ asset('assets/start-menu/restart.webp') }}" alt="">
      <span>Restart System</span>
    </button>
    <p class="login-detail">After you log on, the system is yours to explore.</p>
  </section>

  <div class="welcome-screen" id="welcome-screen" aria-live="polite">welcome</div>

  <main class="desktop" id="desktop">
    <h1 class="sr-only">Roland's developer portfolio</h1>

    <section class="desktop-icons" aria-label="Desktop applications">
      <button class="desktop-icon" data-open="about">
        <img src="{{ asset('assets/desktop/about.webp') }}" alt="">
        <span class="desktop-icon-label">About Me</span>
      </button>
      <button class="desktop-icon" data-open="resume">
        <img src="{{ asset('assets/desktop/resume.webp') }}" alt="">
        <span class="desktop-icon-label">My Resume</span>
      </button>
      <button class="desktop-icon" data-open="projects">
        <img src="{{ asset('assets/desktop/projects.webp') }}" alt="">
        <span class="desktop-icon-label">My Projects</span>
      </button>
      <button class="desktop-icon" data-open="contact">
        <img src="{{ asset('assets/desktop/contact.webp') }}" alt="">
        <span class="desktop-icon-label">Contact Me</span>
      </button>
    </section>

    <section class="window" id="window-about" data-window="about" aria-label="About Me window">
      <div class="titlebar">
        <img class="title-icon" src="{{ asset('assets/desktop/about.webp') }}" alt=""><strong>About Me</strong>
        <div class="window-actions">
          <button data-action="minimize" aria-label="Minimize">_</button>
          <button data-action="maximize" aria-label="Maximize">□</button>
          <button data-action="close" aria-label="Close">×</button>
        </div>
      </div>
      <div class="menu-bar"><span>File</span><span>Edit</span><span>View</span><span>Favorites</span><span>Help</span></div>
      <div class="toolbar">
        <button class="soft-button">← <span>Back</span></button>
        <button class="soft-button">→ <span>Forward</span></button>
        <button class="soft-button" data-open="projects">🌐 <span>Projects</span></button>
        <button class="soft-button" data-open="resume">📄 <span>Resume</span></button>
      </div>
      <div class="address-bar"><span>Address</span><div>🟢 About Me</div><button>Go</button></div>
      <div class="window-content about-content">
        <aside class="sidebar">
          <div class="side-card">
            <h3>Social Links <span>⌃</span></h3>
            <a href="#">◎ Instagram</a><a href="#">◉ Github</a><a href="#">in LinkedIn</a>
          </div>
          <div class="side-card">
            <h3>Skills <span>⌃</span></h3>
            <p>✦ Front-end development</p><p>✦ UI / UX design</p><p>✦ Creative coding</p><p>✦ Design systems</p><p>✦ Problem solving</p>
          </div>
          <div class="side-card">
            <h3>Toolbox <span>⌃</span></h3>
            <p>VS Code</p><p>Figma</p><p>React</p><p>TypeScript</p>
          </div>
        </aside>
        <article class="about-main">
          <p class="eyebrow">Welcome to my corner of the web</p>
          <h2>About Me</h2>
          <p><span class="pixel-person">👨‍💻</span>I'm Roland, a developer and designer who likes turning complex ideas into useful, characterful digital products.</p>
          <p><span class="pixel-person">🛠️</span>I care about thoughtful details, accessible interfaces, and code that remains pleasant to work with after launch day.</p>
          <div class="stat-grid">
            <div><strong>6+</strong><span>Years building</span></div>
            <div><strong>24</strong><span>Projects shipped</span></div>
            <div><strong>∞</strong><span>Ideas queued</span></div>
          </div>
        </article>
      </div>
      <div class="statusbar">Welcome. Have a look around.</div>
    </section>

    <section class="window" id="window-projects" data-window="projects" aria-label="Projects window">
      <div class="titlebar">
        <img class="title-icon" src="{{ asset('assets/desktop/projects.webp') }}" alt=""><strong>My Projects</strong>
        <div class="window-actions">
          <button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">□</button><button data-action="close" aria-label="Close">×</button>
        </div>
      </div>
      <div class="menu-bar"><span>File</span><span>Edit</span><span>View</span><span>Favorites</span><span>Help</span></div>
      <div class="toolbar"><button class="soft-button">← Back</button><button class="soft-button">→ Forward</button><button class="soft-button">🔍 Search</button><button class="soft-button">📁 Folders</button></div>
      <div class="address-bar"><span>Address</span><div>🌐 portfolio.local/projects</div><button>Go</button></div>
      <div class="window-content projects-content">
        <div class="projects-heading"><div><p class="eyebrow">Selected work</p><h2>Things I've built</h2></div><span class="online-pill">● Available for work</span></div>
        <div class="project-grid">
          <article class="project-card blue"><span>01 / PRODUCT</span><h3>Atlas Dashboard</h3><p>A calm command center for busy operations teams.</p><a href="#">View case study →</a></article>
          <article class="project-card orange"><span>02 / EXPERIENCE</span><h3>Signal Studio</h3><p>A playful browser-based audio visualizer.</p><a href="#">View case study →</a></article>
          <article class="project-card green"><span>03 / PLATFORM</span><h3>Local Notes</h3><p>A privacy-first notebook made for focused work.</p><a href="#">View case study →</a></article>
          <article class="project-card purple"><span>04 / EXPERIMENT</span><h3>Tiny Weather</h3><p>A compact forecast that feels like a postcard.</p><a href="#">View case study →</a></article>
        </div>
      </div>
      <div class="statusbar">4 objects</div>
    </section>

    <section class="window compact-window" id="window-resume" data-window="resume" aria-label="Resume window">
      <div class="titlebar"><span class="title-icon">📄</span><strong>My Resume</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">□</button><button data-action="close" aria-label="Close">×</button></div></div>
      <div class="menu-bar"><span>File</span><span>View</span><span>Document</span><span>Help</span></div>
      <div class="resume-content">
        <header><div><p class="eyebrow">Curriculum vitae</p><h2>Roland Developer</h2><p>Designer-minded front-end engineer</p></div><button class="xp-button" onclick="window.print()">Print / Save PDF</button></header>
        <hr>
        <section><h3>Profile</h3><p>I build polished web products with a focus on interface quality, performance, and maintainability.</p></section>
        <section><h3>Experience</h3><div class="resume-row"><strong>Senior Product Developer</strong><span>2023 — Now</span></div><p>Led product interface work from prototype through production.</p><div class="resume-row"><strong>Front-end Developer</strong><span>2020 — 2023</span></div><p>Built responsive experiences and reusable component systems.</p></section>
        <section><h3>Education</h3><div class="resume-row"><strong>BSc, Digital Craft</strong><span>2016 — 2020</span></div></section>
      </div>
      <div class="statusbar">Page 1 of 1</div>
    </section>

    <section class="window compact-window" id="window-contact" data-window="contact" aria-label="Contact window">
      <div class="titlebar"><span class="title-icon">✉</span><strong>Contact Me</strong><div class="window-actions"><button data-action="minimize" aria-label="Minimize">_</button><button data-action="maximize" aria-label="Maximize">□</button><button data-action="close" aria-label="Close">×</button></div></div>
      <div class="menu-bar"><span>File</span><span>Edit</span><span>View</span><span>Help</span></div>
      <div class="contact-content">
        <div class="contact-intro"><span class="big-mail">✉</span><div><p class="eyebrow">New message</p><h2>Let's make something useful.</h2><p>Tell me about the idea, problem, or opportunity.</p></div></div>
        <form id="contact-form">
          <label>Your name<input required name="name" placeholder="Jane Smith"></label>
          <label>Your email<input required type="email" name="email" placeholder="jane@example.com"></label>
          <label>Message<textarea required name="message" rows="5" placeholder="Hello Roland..."></textarea></label>
          <button class="xp-button" type="submit">Send message</button>
          <span id="form-status" role="status"></span>
        </form>
      </div>
      <div class="statusbar">Ready</div>
    </section>

    <aside class="start-menu" id="start-menu" aria-label="Start menu">
      <header><span class="start-avatar">R</span><strong>Roland</strong></header>
      <div class="start-columns">
        <div class="start-left">
          <button data-open="projects"><span>🌐</span><b>My Projects<small>View my work</small></b></button>
          <button data-open="contact"><span>✉</span><b>Contact Me<small>Send a message</small></b></button>
          <hr>
          <button data-open="about"><span>🟢</span>About Me</button><button><span>🎵</span>Music Player</button><button><span>🎨</span>Paint</button>
          <strong class="all-programs">All Programs ▶</strong>
        </div>
        <div class="start-right">
          <a href="#">◎ Instagram</a><a href="#">◉ Github</a><a href="#">in LinkedIn</a><hr><button data-open="resume">📄 My Resume</button><button>💻 Command Prompt</button><button>🖼 Image Viewer</button>
        </div>
      </div>
      <footer><button id="logoff-button">🔑 Log Off</button><button id="shutdown-button">⏻ Shut Down</button></footer>
    </aside>

    <nav class="taskbar" aria-label="Taskbar">
      <button class="start-button" id="start-button" aria-expanded="false"><span>✦</span> start</button>
      <div class="task-items" id="task-items"></div>
      <div class="system-tray"><button id="crt-toggle" title="Toggle CRT effect">◉</button><button id="welcome-button" title="Show welcome">?</button><span id="clock">00:00</span></div>
    </nav>
    <div class="crt-overlay" aria-hidden="true"></div>
    <div class="toast" id="toast" role="status">Welcome to Roland OS.</div>
  </main>
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
