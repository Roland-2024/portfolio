const desktop = document.querySelector("#desktop");
const startButton = document.querySelector("#start-button");
const startMenu = document.querySelector("#start-menu");
const taskItems = document.querySelector("#task-items");
const toast = document.querySelector("#toast");
const windows = [...document.querySelectorAll(".window")];
let topZ = 30;

const names = { about: "About Me", resume: "My Resume", projects: "My Projects", contact: "Contact Me" };
const iconPaths = {
  about: "/assets/desktop/about.webp",
  resume: "/assets/desktop/resume.webp",
  projects: "/assets/desktop/projects.webp",
  contact: "/assets/desktop/contact.webp"
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

function openWindow(name) {
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
  closeStart();
}

function closeWindow(win) {
  win.classList.remove("open", "active", "maximized");
  win.style.display = "";
  document.querySelector(`[data-task="${win.dataset.window}"]`)?.remove();
}

function closeStart() {
  startMenu.classList.remove("open");
  startButton.setAttribute("aria-expanded", "false");
}

document.querySelectorAll("[data-open]").forEach(button => {
  button.addEventListener("dblclick", () => openWindow(button.dataset.open));
  button.addEventListener("click", event => {
    if (!button.classList.contains("desktop-icon")) openWindow(button.dataset.open);
    event.stopPropagation();
  });
});

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

startButton.addEventListener("click", event => {
  event.stopPropagation();
  startMenu.classList.toggle("open");
  startButton.setAttribute("aria-expanded", String(startMenu.classList.contains("open")));
});

document.addEventListener("click", event => {
  if (!event.target.closest(".start-menu")) closeStart();
});

document.querySelector("#crt-toggle").addEventListener("click", () => desktop.classList.toggle("crt-off"));
document.querySelector("#welcome-button").addEventListener("click", showToast);
document.querySelector("#contact-form").addEventListener("submit", event => {
  event.preventDefault();
  document.querySelector("#form-status").textContent = "Message staged. Connect this form to your email service.";
});

function showToast() {
  toast.classList.add("show");
  setTimeout(() => toast.classList.remove("show"), 3500);
}

function updateClock() {
  document.querySelector("#clock").textContent = new Intl.DateTimeFormat([], { hour: "2-digit", minute: "2-digit" }).format(new Date());
}

updateClock();
setInterval(updateClock, 30000);
