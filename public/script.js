const desktop = document.querySelector("#desktop");
const startButton = document.querySelector("#start-button");
const startMenu = document.querySelector("#start-menu");
const allProgramsButton = document.querySelector("#all-programs-button");
const allProgramsMenu = document.querySelector("#all-programs-menu");
const taskItems = document.querySelector("#task-items");
const toast = document.querySelector("#toast");
const windows = [...document.querySelectorAll(".window")];
let topZ = 30;
let allProgramsCloseTimer = null;
let navigationHistory = [];
let navigationIndex = -1;

const names = {
  about: "About Me",
  resume: "My Resume",
  projects: "My Projects",
  contact: "Contact Me",
  music: "Music Player",
  media: "Media Player",
  paint: "Paint",
  minesweeper: "Minesweeper",
  jsonstudio: "JSON Studio",
  terminal: "Command Prompt",
  viewer: "Image Viewer"
};
const iconPaths = {
  about: "/assets/desktop/about.webp",
  resume: "/assets/desktop/resume.webp",
  projects: "/assets/desktop/projects.webp",
  contact: "/assets/desktop/contact.webp",
  music: "/assets/start-menu/music.webp",
  media: "/assets/start-menu/mediaPlayer.webp",
  paint: "/assets/start-menu/paint.webp",
  minesweeper: "/assets/start-menu/minesweeper.svg",
  jsonstudio: "/assets/start-menu/json-studio.svg",
  terminal: "/assets/start-menu/cmd.webp",
  viewer: "/assets/start-menu/photos.webp"
};
const appAliases = {
  about: "about",
  "about me": "about",
  home: "about",
  projects: "projects",
  "my projects": "projects",
  resume: "resume",
  "my resume": "resume",
  contact: "contact",
  "contact me": "contact",
  music: "music",
  "music player": "music",
  media: "media",
  "media player": "media",
  paint: "paint",
  minesweeper: "minesweeper",
  mines: "minesweeper",
  json: "jsonstudio",
  "json studio": "jsonstudio",
  jsonstudio: "jsonstudio",
  terminal: "terminal",
  cmd: "terminal",
  "command prompt": "terminal",
  viewer: "viewer",
  photos: "viewer",
  "image viewer": "viewer"
};
const bootScreen = document.querySelector("#boot-screen");
const loginScreen = document.querySelector("#login-screen");
const loginUser = document.querySelector("#login-user");
const loginRestart = document.querySelector("#login-restart");
const welcomeScreen = document.querySelector("#welcome-screen");
const startupSkip = document.querySelector("#startup-skip");
const logoffButton = document.querySelector("#logoff-button");
const shutdownButton = document.querySelector("#shutdown-button");
const loginSound = new Audio("/assets/sounds/login.wav");
const logoffSound = new Audio("/assets/sounds/logoff.wav");
const balloonSound = new Audio("/assets/sounds/balloon.wav");
const startupTimers = new Set();
let desktopReady = false;
let loginInProgress = false;

[loginSound, logoffSound, balloonSound].forEach(sound => {
  sound.preload = "auto";
});

function scheduleStartup(callback, delay) {
  const timer = setTimeout(() => {
    startupTimers.delete(timer);
    callback();
  }, delay);
  startupTimers.add(timer);
}

function clearStartupTimers() {
  startupTimers.forEach(timer => clearTimeout(timer));
  startupTimers.clear();
}

function playSound(sound, volume = 1) {
  sound.pause();
  sound.currentTime = 0;
  sound.volume = volume;
  sound.play().catch(() => {});
}

function revealDesktop({ remember = true, welcome = false } = {}) {
  clearStartupTimers();
  bootScreen.classList.add("is-hidden");
  loginScreen.classList.remove("is-visible", "is-leaving");
  welcomeScreen.classList.remove("is-visible");
  document.body.classList.remove("startup-pending");
  if (remember) sessionStorage.setItem("roland-os-logged-in", "true");
  if (!desktopReady) {
    desktopReady = true;
    scheduleStartup(showToast, welcome ? 700 : 350);
  }
}

function showLogin() {
  bootScreen.classList.add("is-hidden");
  loginScreen.classList.add("is-visible");
  loginScreen.classList.remove("is-leaving");
}

function restartStartup() {
  clearStartupTimers();
  loginInProgress = false;
  sessionStorage.removeItem("roland-os-logged-in");
  document.body.classList.add("startup-pending");
  welcomeScreen.classList.remove("is-visible");
  loginScreen.classList.remove("is-visible", "is-leaving");
  bootScreen.classList.remove("is-hidden");
  scheduleStartup(showLogin, 3400);
}

function completeLogin() {
  if (loginInProgress) return;
  loginInProgress = true;
  loginUser.classList.add("active");
  playSound(loginSound);
  scheduleStartup(() => {
    loginScreen.classList.add("is-leaving");
    welcomeScreen.classList.add("is-visible");
  }, 350);
  scheduleStartup(() => {
    revealDesktop({ welcome: true });
    playSound(balloonSound, 0.5);
  }, 1900);
}

function logOff() {
  closeStart();
  loginInProgress = false;
  playSound(logoffSound);
  document.body.classList.add("startup-pending");
  loginScreen.classList.add("is-visible");
  loginScreen.classList.remove("is-leaving");
  loginUser.classList.remove("active");
  sessionStorage.removeItem("roland-os-logged-in");
}

const forceBoot = new URLSearchParams(window.location.search).get("boot") === "1";
if (sessionStorage.getItem("roland-os-logged-in") === "true" && !forceBoot) {
  revealDesktop({ remember: false });
} else {
  scheduleStartup(showLogin, 3400);
}

startupSkip.addEventListener("click", () => revealDesktop());
loginUser.addEventListener("click", completeLogin);
loginRestart.addEventListener("click", restartStartup);
logoffButton.addEventListener("click", logOff);
shutdownButton.addEventListener("click", restartStartup);
const icons = { about: "🟢", resume: "📄", projects: "🌐", contact: "✉" };

function activateWindow(win) {
  windows.forEach(item => item.classList.remove("active"));
  document.querySelectorAll(".task-item").forEach(item => item.classList.remove("active"));
  win.classList.add("active");
  win.style.zIndex = ++topZ;
  document.querySelector(`.task-item[data-task="${win.dataset.window}"]`)?.classList.add("active");
}

function recordNavigation(name) {
  if (navigationHistory[navigationIndex] === name) return;
  navigationHistory = navigationHistory.slice(0, navigationIndex + 1);
  navigationHistory.push(name);
  navigationIndex = navigationHistory.length - 1;
}

function openWindow(name, { record = true } = {}) {
  const win = document.querySelector(`[data-window="${name}"]`);
  if (!win) return;
  win.classList.add("open");
  win.style.display = "";
  if (!document.querySelector(`[data-task="${name}"]`)) {
    const task = document.createElement("button");
    task.className = "task-item";
    task.dataset.task = name;
    task.innerHTML = `<img src="${iconPaths[name]}" alt=""> ${names[name]}`;
    task.addEventListener("click", () => {
      if (win.style.display === "none" || !win.classList.contains("active")) {
        win.style.display = "";
        activateWindow(win);
      } else {
        win.style.display = "none";
        task.classList.remove("active");
      }
    });
    taskItems.append(task);
  }
  activateWindow(win);
  if (name === "media") loadYouTubePlayer();
  if (record) recordNavigation(name);
  closeStart();
}

function navigateHistory(direction) {
  const nextIndex = navigationIndex + direction;
  if (nextIndex < 0 || nextIndex >= navigationHistory.length) {
    showToast(direction < 0 ? "There are no previous apps." : "There are no newer apps.");
    return;
  }
  navigationIndex = nextIndex;
  openWindow(navigationHistory[navigationIndex], { record: false });
}

function closeWindow(win) {
  win.classList.remove("open", "active", "maximized");
  win.style.display = "";
  document.querySelector(`[data-task="${win.dataset.window}"]`)?.remove();
}

function resolveAddress(rawAddress) {
  const address = rawAddress.trim();
  const normalized = address.toLowerCase().replace(/^roland:\/\//, "").replace(/^portfolio\.local\//, "");
  if (appAliases[normalized]) {
    openWindow(appAliases[normalized]);
    return;
  }
  if (/^(https?:\/\/|mailto:|tel:)/i.test(address)) {
    window.open(address, "_blank", "noopener");
    return;
  }
  showToast(`Roland OS could not find "${address}".`);
}

function closeWindowMenus() {
  document.querySelectorAll(".window-menu-popup").forEach(menu => menu.remove());
  document.querySelectorAll(".menu-bar button").forEach(button => button.classList.remove("active"));
}

const windowMenus = {
  game: [
    ["New game", "new-minesweeper"],
    ["Close", "close"]
  ],
  file: [
    ["Open About Me", "open:about"],
    ["Open Projects", "open:projects"],
    ["Print", "print"],
    ["Close", "close"]
  ],
  edit: [
    ["Copy app address", "copy-address"],
    ["Write a message", "focus-contact"]
  ],
  view: [
    ["Maximize / Restore", "maximize"],
    ["Toggle CRT effect", "crt"],
    ["Full screen", "fullscreen"]
  ],
  favorites: [
    ["About Me", "open:about"],
    ["My Projects", "open:projects"],
    ["My Resume", "open:resume"],
    ["Contact Me", "open:contact"]
  ],
  help: [
    ["About Roland OS", "about-os"],
    ["Navigation help", "navigation-help"],
    ["Open Dashboard", "dashboard"]
  ]
};

async function runCommand(command, win) {
  if (command.startsWith("open:")) {
    openWindow(command.split(":")[1]);
  } else if (command === "close") {
    closeWindow(win);
  } else if (command === "print") {
    openWindow("resume");
    setTimeout(() => window.print(), 150);
  } else if (command === "copy-address") {
    const value = win.querySelector(".address-input")?.value || `roland://${win.dataset.window}`;
    try {
      await navigator.clipboard.writeText(value);
      showToast(`Copied ${value}`);
    } catch {
      showToast(value);
    }
  } else if (command === "focus-contact") {
    openWindow("contact");
    setTimeout(() => document.querySelector('#contact-form input[name="name"]')?.focus(), 100);
  } else if (command === "new-minesweeper") {
    startMinesweeper();
  } else if (command === "maximize") {
    win.classList.toggle("maximized");
  } else if (command === "crt") {
    desktop.classList.toggle("crt-off");
  } else if (command === "fullscreen") {
    if (document.fullscreenElement) document.exitFullscreen?.();
    else document.documentElement.requestFullscreen?.();
  } else if (command === "about-os") {
    showToast("Roland OS is an interactive Laravel portfolio inspired by Windows XP.");
  } else if (command === "navigation-help") {
    showToast("Double-click desktop icons, use app toolbars, type roland://app in an address bar, or open Start.");
  } else if (command === "dashboard") {
    window.open("/admin", "_blank", "noopener");
  }
  closeWindowMenus();
}

function openWindowMenu(button) {
  const win = button.closest(".window");
  const menuName = button.dataset.menu;
  const items = windowMenus[menuName] || windowMenus.help;
  const wasActive = button.classList.contains("active");
  closeWindowMenus();
  if (wasActive) return;

  const popup = document.createElement("div");
  popup.className = "window-menu-popup";
  items.forEach(([label, command]) => {
    const item = document.createElement("button");
    item.type = "button";
    item.textContent = label;
    item.addEventListener("click", event => {
      event.stopPropagation();
      runCommand(command, win);
    });
    popup.append(item);
  });
  button.classList.add("active");
  button.parentElement.append(popup);
  popup.style.left = `${button.offsetLeft}px`;
}

function closeStart() {
  closeAllPrograms();
  startMenu.classList.remove("open");
  startButton.setAttribute("aria-expanded", "false");
}

function openAllPrograms() {
  clearTimeout(allProgramsCloseTimer);
  allProgramsMenu.classList.add("open");
  allProgramsButton.classList.add("active");
  allProgramsButton.setAttribute("aria-expanded", "true");
}

function closeAllPrograms() {
  clearTimeout(allProgramsCloseTimer);
  allProgramsMenu.classList.remove("open");
  allProgramsButton.classList.remove("active");
  allProgramsButton.setAttribute("aria-expanded", "false");
}

function scheduleAllProgramsClose() {
  clearTimeout(allProgramsCloseTimer);
  allProgramsCloseTimer = setTimeout(closeAllPrograms, 180);
}

document.querySelectorAll("[data-open]").forEach(button => {
  button.addEventListener("dblclick", () => openWindow(button.dataset.open));
  button.addEventListener("click", event => {
    if (!button.classList.contains("desktop-icon")) openWindow(button.dataset.open);
    event.stopPropagation();
  });
});

document.querySelectorAll("[data-history]").forEach(button => {
  button.addEventListener("click", event => {
    event.stopPropagation();
    navigateHistory(Number(button.dataset.history));
  });
});

document.querySelectorAll("[data-command]").forEach(button => {
  button.addEventListener("click", event => {
    event.stopPropagation();
    runCommand(button.dataset.command, button.closest(".window"));
  });
});

document.querySelectorAll(".menu-bar [data-menu]").forEach(button => {
  button.addEventListener("click", event => {
    event.stopPropagation();
    openWindowMenu(button);
  });
});

document.querySelectorAll("[data-address-go]").forEach(button => {
  button.addEventListener("click", () => resolveAddress(button.closest(".address-bar").querySelector(".address-input").value));
});

document.querySelectorAll(".address-input").forEach(input => {
  input.addEventListener("keydown", event => {
    if (event.key === "Enter") resolveAddress(input.value);
  });
});

document.querySelectorAll("[data-collapse-panel]").forEach(button => {
  button.addEventListener("click", () => {
    const card = button.closest(".side-card");
    card.classList.toggle("collapsed");
    button.querySelector("span").textContent = card.classList.contains("collapsed") ? "v" : "^";
  });
});

const projectSearchButton = document.querySelector("[data-project-search]");
const projectFoldersButton = document.querySelector("[data-project-folders]");
const projectSearchInput = document.querySelector("#project-search-input");
const projectCards = [...document.querySelectorAll("[data-project-card]")];
let projectCategory = "all";

function filterProjects() {
  const query = projectSearchInput.value.trim().toLowerCase();
  let visible = 0;
  projectCards.forEach(card => {
    const matchesQuery = !query || card.textContent.toLowerCase().includes(query);
    const matchesCategory = projectCategory === "all" || card.dataset.category === projectCategory;
    const show = matchesQuery && matchesCategory;
    card.hidden = !show;
    if (show) visible += 1;
  });
  document.querySelector("#window-projects .statusbar").textContent = `${visible} objects`;
}

projectSearchButton?.addEventListener("click", () => {
  document.querySelector("#project-tools").classList.toggle("show-search");
  if (document.querySelector("#project-tools").classList.contains("show-search")) projectSearchInput.focus();
});
projectFoldersButton?.addEventListener("click", () => document.querySelector("#project-tools").classList.toggle("show-folders"));
projectSearchInput?.addEventListener("input", filterProjects);
document.querySelectorAll("[data-project-filter]").forEach(button => {
  button.addEventListener("click", () => {
    projectCategory = button.dataset.projectFilter;
    document.querySelectorAll("[data-project-filter]").forEach(item => item.classList.toggle("active", item === button));
    filterProjects();
  });
});

allProgramsButton.addEventListener("click", event => {
  event.stopPropagation();
  if (allProgramsMenu.classList.contains("open")) closeAllPrograms();
  else openAllPrograms();
});
allProgramsButton.addEventListener("pointerenter", openAllPrograms);
allProgramsButton.addEventListener("focus", openAllPrograms);
allProgramsButton.addEventListener("pointerleave", scheduleAllProgramsClose);
allProgramsMenu.addEventListener("pointerenter", openAllPrograms);
allProgramsMenu.addEventListener("pointerleave", scheduleAllProgramsClose);

windows.forEach(win => {
  win.addEventListener("pointerdown", () => activateWindow(win));
  win.querySelector('[data-action="close"]').addEventListener("click", () => closeWindow(win));
  win.querySelector('[data-action="minimize"]').addEventListener("click", () => {
    win.style.display = "none";
    document.querySelector(`[data-task="${win.dataset.window}"]`)?.classList.remove("active");
  });
  win.querySelector('[data-action="maximize"]').addEventListener("click", () => win.classList.toggle("maximized"));

  const titlebar = win.querySelector(".titlebar");
  let drag = null;
  titlebar.addEventListener("pointerdown", event => {
    if (event.target.closest("button") || win.classList.contains("maximized")) return;
    drag = { x: event.clientX, y: event.clientY, left: win.offsetLeft, top: win.offsetTop };
    titlebar.setPointerCapture(event.pointerId);
  });
  titlebar.addEventListener("pointermove", event => {
    if (!drag) return;
    win.style.left = `${Math.max(0, drag.left + event.clientX - drag.x)}px`;
    win.style.top = `${Math.max(0, drag.top + event.clientY - drag.y)}px`;
  });
  titlebar.addEventListener("pointerup", () => drag = null);
  titlebar.addEventListener("dblclick", () => win.classList.toggle("maximized"));
});

document.querySelectorAll("[data-audio-src]").forEach(button => {
  button.addEventListener("click", async () => {
    const audio = document.querySelector("#music-audio");
    const status = document.querySelector("#window-music .statusbar");
    audio.src = button.dataset.audioSrc;
    audio.currentTime = 0;
    try {
      await audio.play();
      status.textContent = `Playing: ${button.textContent}`;
    } catch {
      status.textContent = `${button.textContent} loaded. Press Play in the audio controls.`;
    }
  });
});

document.querySelectorAll("[data-media-action]").forEach(button => {
  button.addEventListener("click", () => {
    const isPlay = button.dataset.mediaAction === "play";
    if (isPlay) loadYouTubePlayer(true);
    else stopYouTubePlayer();
  });
});

function youtubeEmbedUrl(autoplay = false) {
  const player = document.querySelector("#media-youtube");
  const params = new URLSearchParams({
    autoplay: autoplay ? "1" : "0",
    rel: "0",
    enablejsapi: "1",
    origin: window.location.origin
  });
  if (autoplay) params.set("mute", "1");
  return `https://www.youtube.com/embed/${player.dataset.videoId}?${params}`;
}

function loadYouTubePlayer(autoplay = false) {
  const player = document.querySelector("#media-youtube");
  const placeholder = document.querySelector("#media-placeholder");
  if (!player) return;
  const nextUrl = youtubeEmbedUrl(autoplay);
  player.onload = () => {
    if (autoplay) {
      player.contentWindow?.postMessage(JSON.stringify({ event: "command", func: "playVideo", args: [] }), "*");
    }
  };
  if (player.src !== nextUrl) player.src = nextUrl;
  player.classList.add("playing");
  placeholder.hidden = true;
  document.querySelector("#window-media .statusbar").textContent = autoplay ? "Playing YouTube video muted" : "YouTube video ready";
}

function stopYouTubePlayer() {
  const player = document.querySelector("#media-youtube");
  const placeholder = document.querySelector("#media-placeholder");
  player.src = "";
  player.classList.remove("playing");
  placeholder.hidden = false;
  placeholder.innerHTML = "<strong>Video stopped</strong><span>Click Play to load it again.</span>";
  document.querySelector("#window-media .statusbar").textContent = "Stopped";
}

const paintCanvas = document.querySelector("#paint-canvas");
if (paintCanvas) {
  const paintContext = paintCanvas.getContext("2d");
  let drawing = false;
  paintContext.fillStyle = "#ffffff";
  paintContext.fillRect(0, 0, paintCanvas.width, paintCanvas.height);

  function paintPoint(event) {
    const rect = paintCanvas.getBoundingClientRect();
    const x = (event.clientX - rect.left) * (paintCanvas.width / rect.width);
    const y = (event.clientY - rect.top) * (paintCanvas.height / rect.height);
    paintContext.lineTo(x, y);
    paintContext.stroke();
  }

  paintCanvas.addEventListener("pointerdown", event => {
    drawing = true;
    paintCanvas.setPointerCapture(event.pointerId);
    const rect = paintCanvas.getBoundingClientRect();
    paintContext.beginPath();
    paintContext.moveTo(
      (event.clientX - rect.left) * (paintCanvas.width / rect.width),
      (event.clientY - rect.top) * (paintCanvas.height / rect.height)
    );
    paintContext.strokeStyle = document.querySelector("#paint-color").value;
    paintContext.lineWidth = Number(document.querySelector("#paint-size").value);
    paintContext.lineCap = "round";
  });
  paintCanvas.addEventListener("pointermove", event => {
    if (drawing) paintPoint(event);
  });
  paintCanvas.addEventListener("pointerup", () => {
    drawing = false;
    paintContext.closePath();
  });
  document.querySelectorAll("[data-paint-action]").forEach(button => {
    button.addEventListener("click", () => {
      if (button.dataset.paintAction === "clear") {
        paintContext.fillStyle = "#ffffff";
        paintContext.fillRect(0, 0, paintCanvas.width, paintCanvas.height);
      } else {
        const link = document.createElement("a");
        link.download = "roland-os-paint.png";
        link.href = paintCanvas.toDataURL("image/png");
        link.click();
      }
    });
  });
}

const mineBoard = document.querySelector("#mine-board");
const mineCounter = document.querySelector("#mine-counter");
const mineTimer = document.querySelector("#mine-timer");
const mineReset = document.querySelector("#mine-reset");
const mineStatus = document.querySelector("#mine-status");
const mineRows = 9;
const mineColumns = 9;
const mineTotal = 10;
let mineCells = [];
let mineStarted = false;
let mineGameOver = false;
let mineFlags = 0;
let mineSeconds = 0;
let mineTimerId = null;

function formatMineDisplay(value) {
  return String(Math.max(-99, Math.min(999, value))).padStart(3, "0");
}

function mineNeighbors(index) {
  const row = Math.floor(index / mineColumns);
  const column = index % mineColumns;
  const neighbors = [];
  for (let rowOffset = -1; rowOffset <= 1; rowOffset += 1) {
    for (let columnOffset = -1; columnOffset <= 1; columnOffset += 1) {
      if (rowOffset === 0 && columnOffset === 0) continue;
      const nextRow = row + rowOffset;
      const nextColumn = column + columnOffset;
      if (nextRow >= 0 && nextRow < mineRows && nextColumn >= 0 && nextColumn < mineColumns) {
        neighbors.push(nextRow * mineColumns + nextColumn);
      }
    }
  }
  return neighbors;
}

function updateMineDisplays() {
  mineCounter.value = formatMineDisplay(mineTotal - mineFlags);
  mineCounter.textContent = mineCounter.value;
  mineTimer.value = formatMineDisplay(mineSeconds);
  mineTimer.textContent = mineTimer.value;
}

function placeMines(safeIndex) {
  const available = mineCells.map((_, index) => index).filter(index => index !== safeIndex);
  for (let index = available.length - 1; index > 0; index -= 1) {
    const randomIndex = Math.floor(Math.random() * (index + 1));
    [available[index], available[randomIndex]] = [available[randomIndex], available[index]];
  }
  available.slice(0, mineTotal).forEach(index => {
    mineCells[index].mine = true;
  });
  mineCells.forEach((cell, index) => {
    cell.count = mineNeighbors(index).filter(neighbor => mineCells[neighbor].mine).length;
  });
}

function startMineTimer() {
  clearInterval(mineTimerId);
  mineTimerId = setInterval(() => {
    mineSeconds = Math.min(999, mineSeconds + 1);
    updateMineDisplays();
  }, 1000);
}

function renderMineCell(cell) {
  const button = cell.button;
  button.className = "mine-cell";
  button.removeAttribute("data-count");
  if (cell.revealed) {
    button.classList.add("revealed");
    if (cell.mine) {
      button.textContent = "✹";
      button.setAttribute("aria-label", "Mine");
    } else if (cell.count) {
      button.textContent = String(cell.count);
      button.dataset.count = String(cell.count);
      button.setAttribute("aria-label", `${cell.count} nearby mines`);
    } else {
      button.textContent = "";
      button.setAttribute("aria-label", "Empty revealed cell");
    }
  } else if (cell.flagged) {
    button.classList.add("flagged");
    button.textContent = "⚑";
    button.setAttribute("aria-label", "Flagged hidden cell");
  } else {
    button.textContent = "";
    button.setAttribute("aria-label", "Hidden cell");
  }
}

function finishMinesweeper(won, hitIndex = -1) {
  mineGameOver = true;
  clearInterval(mineTimerId);
  mineCells.forEach((cell, index) => {
    if (cell.mine) cell.revealed = true;
    renderMineCell(cell);
    if (!won && index === hitIndex) cell.button.classList.add("mine-hit");
  });
  mineReset.textContent = won ? "😎" : "😵";
  mineStatus.textContent = won ? `You cleared the field in ${mineSeconds} seconds!` : "Game over. Click the face to try again.";
}

function checkMinesweeperWin() {
  if (mineCells.filter(cell => cell.revealed && !cell.mine).length === mineRows * mineColumns - mineTotal) {
    finishMinesweeper(true);
  }
}

function revealMineCell(index) {
  const cell = mineCells[index];
  if (mineGameOver || cell.revealed || cell.flagged) return;
  if (!mineStarted) {
    mineStarted = true;
    placeMines(index);
    startMineTimer();
    mineStatus.textContent = "Game in progress";
  }
  cell.revealed = true;
  renderMineCell(cell);
  if (cell.mine) {
    finishMinesweeper(false, index);
    return;
  }
  if (cell.count === 0) mineNeighbors(index).forEach(revealMineCell);
  checkMinesweeperWin();
}

function flagMineCell(index) {
  const cell = mineCells[index];
  if (mineGameOver || cell.revealed || (!cell.flagged && mineFlags >= mineTotal)) return;
  cell.flagged = !cell.flagged;
  mineFlags += cell.flagged ? 1 : -1;
  renderMineCell(cell);
  updateMineDisplays();
}

function startMinesweeper() {
  clearInterval(mineTimerId);
  mineStarted = false;
  mineGameOver = false;
  mineFlags = 0;
  mineSeconds = 0;
  mineReset.textContent = "🙂";
  mineStatus.textContent = "Beginner: 9 × 9 board, 10 mines";
  mineBoard.replaceChildren();
  mineCells = Array.from({ length: mineRows * mineColumns }, (_, index) => {
    const button = document.createElement("button");
    button.type = "button";
    button.className = "mine-cell";
    button.dataset.index = String(index);
    button.setAttribute("role", "gridcell");
    button.setAttribute("aria-label", "Hidden cell");
    button.addEventListener("click", () => revealMineCell(index));
    button.addEventListener("contextmenu", event => {
      event.preventDefault();
      flagMineCell(index);
    });
    button.addEventListener("keydown", event => {
      if (event.key === "Enter" && event.shiftKey) {
        event.preventDefault();
        flagMineCell(index);
      }
    });
    mineBoard.append(button);
    return { button, mine: false, count: 0, revealed: false, flagged: false };
  });
  updateMineDisplays();
}

mineReset?.addEventListener("click", startMinesweeper);
if (mineBoard) startMinesweeper();

const jsonInput = document.querySelector("#json-input");
const jsonOutput = document.querySelector("#json-output");
const jsonStatus = document.querySelector("#json-status");
const jsonSample = {
  developer: "Roland Aga",
  role: "Full Stack Web Developer",
  technologies: ["PHP", "Laravel", "WordPress", "WooCommerce", "React.js", "Tailwind CSS"],
  availableForProjects: true,
  portfolio: {
    website: "https://rolandaga.com",
    github: "https://github.com/Roland-2024"
  }
};

function parseJsonStudioInput() {
  const source = jsonInput.value.trim();
  if (!source) throw new Error("Input is empty.");
  return { source, value: JSON.parse(source) };
}

function setJsonStudioStatus(message, valid = true) {
  jsonStatus.textContent = message;
  jsonStatus.classList.toggle("error", !valid);
}

function runJsonStudioAction(action) {
  if (action === "clear") {
    jsonInput.value = "";
    jsonOutput.value = "";
    setJsonStudioStatus("Cleared. Paste JSON or load the sample.");
    jsonInput.focus();
    return;
  }
  if (action === "sample") {
    jsonInput.value = JSON.stringify(jsonSample, null, 2);
    jsonOutput.value = "";
    setJsonStudioStatus("Sample JSON loaded. Click Format or Minify.");
    return;
  }
  if (action === "copy") {
    if (!jsonOutput.value) {
      setJsonStudioStatus("There is no output to copy.", false);
      return;
    }
    navigator.clipboard.writeText(jsonOutput.value)
      .then(() => setJsonStudioStatus(`Copied ${jsonOutput.value.length} characters to the clipboard.`))
      .catch(() => setJsonStudioStatus("Clipboard access is unavailable. Select the output manually.", false));
    return;
  }

  try {
    const { source, value } = parseJsonStudioInput();
    if (action === "validate") {
      jsonOutput.value = JSON.stringify(value, null, 2);
      setJsonStudioStatus(`Valid JSON. ${source.length} characters parsed successfully.`);
    } else if (action === "minify") {
      jsonOutput.value = JSON.stringify(value);
      setJsonStudioStatus(`Minified from ${source.length} to ${jsonOutput.value.length} characters.`);
    } else {
      jsonOutput.value = JSON.stringify(value, null, 2);
      setJsonStudioStatus(`Formatted successfully. ${jsonOutput.value.split("\n").length} lines.`);
    }
  } catch (error) {
    jsonOutput.value = "";
    setJsonStudioStatus(`Invalid JSON: ${error.message}`, false);
  }
}

document.querySelectorAll("[data-json-action]").forEach(button => {
  button.addEventListener("click", () => runJsonStudioAction(button.dataset.jsonAction));
});

jsonInput?.addEventListener("keydown", event => {
  if (event.key === "Enter" && (event.ctrlKey || event.metaKey)) {
    event.preventDefault();
    runJsonStudioAction("format");
  }
  if (event.key === "Tab") {
    event.preventDefault();
    const start = jsonInput.selectionStart;
    const end = jsonInput.selectionEnd;
    jsonInput.setRangeText("  ", start, end, "end");
  }
});

const terminalForm = document.querySelector("#terminal-form");
const terminalInput = document.querySelector("#terminal-input");
const terminalOutput = document.querySelector("#terminal-output");
const terminalCommands = {
  help: "Available commands: about, skills, projects, contact, resume, clear, date",
  about: "Roland Aga - Full Stack Web Developer specializing in PHP, WordPress, Laravel, React.js, Bootstrap, and Tailwind CSS.",
  skills: "PHP, Laravel, WordPress, WooCommerce, React.js, JavaScript, Bootstrap, Tailwind CSS, SQL, Docker, Azure",
  projects: "Opening My Projects...",
  contact: "Opening Contact Me...",
  resume: "Opening My Resume...",
  date: () => new Date().toString()
};

terminalForm?.addEventListener("submit", event => {
  event.preventDefault();
  const command = terminalInput.value.trim().toLowerCase();
  terminalOutput.textContent += `\nC:\\Portfolio> ${terminalInput.value}`;
  if (command === "clear") {
    terminalOutput.textContent = "";
  } else {
    const result = terminalCommands[command];
    terminalOutput.textContent += `\n${typeof result === "function" ? result() : (result || `"${command}" is not recognized. Type "help".`)}`;
    if (["projects", "contact", "resume", "about"].includes(command)) openWindow(command);
  }
  terminalInput.value = "";
  terminalOutput.parentElement.scrollTop = terminalOutput.parentElement.scrollHeight;
});
terminalInput?.addEventListener("keydown", event => {
  if (event.key === "Enter") {
    event.preventDefault();
    terminalForm.requestSubmit();
  }
});

const viewerContent = document.querySelector(".viewer-content");
if (viewerContent) {
  const viewerImages = JSON.parse(viewerContent.dataset.images);
  const viewerImageAlts = JSON.parse(viewerContent.dataset.imageAlts);
  const viewerImage = document.querySelector("#viewer-image");
  let viewerIndex = 0;
  document.querySelectorAll("[data-viewer-action]").forEach(button => {
    button.addEventListener("click", () => {
      viewerIndex = (viewerIndex + Number(button.dataset.viewerAction) + viewerImages.length) % viewerImages.length;
      viewerImage.src = viewerImages[viewerIndex];
      viewerImage.alt = viewerImageAlts[viewerIndex];
      document.querySelector("#viewer-status").textContent = `Image ${viewerIndex + 1} of ${viewerImages.length}`;
    });
  });
}

startButton.addEventListener("click", event => {
  event.stopPropagation();
  closeAllPrograms();
  startMenu.classList.toggle("open");
  startButton.setAttribute("aria-expanded", String(startMenu.classList.contains("open")));
});

document.addEventListener("click", event => {
  if (!event.target.closest(".start-menu") && !event.target.closest(".all-programs-menu")) closeStart();
  if (!event.target.closest(".menu-bar") && !event.target.closest(".window-menu-popup")) closeWindowMenus();
});

document.addEventListener("keydown", event => {
  if (event.key === "Escape") {
    closeStart();
    closeWindowMenus();
  }
  if (event.key === "F1") {
    event.preventDefault();
    showToast("Double-click desktop icons or use Start. Every toolbar, menu, and address bar is interactive.");
  }
});

document.querySelector("#crt-toggle").addEventListener("click", () => desktop.classList.toggle("crt-off"));
document.querySelector("#welcome-button").addEventListener("click", showToast);
document.querySelector("#fullscreen-toggle").addEventListener("click", () => runCommand("fullscreen", desktop));
document.querySelector("#contact-form").addEventListener("submit", async event => {
  event.preventDefault();
  const formElement = event.currentTarget;
  const status = document.querySelector("#form-status");
  const submitButton = formElement.querySelector('button[type="submit"]');
  status.textContent = "Sending...";
  submitButton.disabled = true;

  try {
    const response = await fetch(formElement.action, {
      method: "POST",
      headers: {
        Accept: "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
      },
      body: new FormData(formElement)
    });
    const result = await response.json();
    if (!response.ok) {
      const errors = result.errors ? Object.values(result.errors).flat().join(" ") : result.message;
      throw new Error(errors || "Your message could not be sent.");
    }
    status.textContent = result.message;
    formElement.reset();
  } catch (error) {
    status.textContent = error.message || "Your message could not be sent. Please try again.";
  } finally {
    submitButton.disabled = false;
  }
});

function showToast(message = "Welcome to Roland OS.") {
  if (typeof message === "string") toast.textContent = message;
  toast.classList.add("show");
  setTimeout(() => toast.classList.remove("show"), 3500);
}

function updateClock() {
  document.querySelector("#clock").textContent = new Intl.DateTimeFormat([], { hour: "2-digit", minute: "2-digit" }).format(new Date());
}

updateClock();
setInterval(updateClock, 30000);
