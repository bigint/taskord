require("./shortcuts");
require("./tribute");
require("./tippy");
require('./clipboard');
import { isInViewport } from "observe-element-in-viewport";

// Greetings
console.log(
  "%cTaskord",
  `
    color:#6a63ec;
    font-size: 50px;
    font-weight: bold;
    -webkit-text-stroke: 0.5px white;
  `
);

document.addEventListener("DOMContentLoaded", async () => {
  // Pagination
  Livewire.hook("component.initialized", () => {
    window.addEventListener("scroll", () => {
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
      if (scrollTop + window.innerHeight > document.documentElement.scrollHeight - 100) {
        document.getElementById("load-more").click();
        document.getElementById("load-more").innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        document.getElementById("load-more").disabled = true;
      }
    });
  });

  // Initial Pagination
  const target = document.querySelector("#load-more");
  if (target && await isInViewport(target)) {
    document.getElementById("load-more").click();
    document.getElementById("load-more").innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    document.getElementById("load-more").disabled = true;
  }
});

// Admin Bar toggle in dropdown
var adminBar = document.getElementById("admin-bar-click");
if (adminBar) {
  adminBar.addEventListener("click", async () => {
    const res = await window.fetch(`/admin/adminbar`);
    if (res.status === 200) {
      window.location.reload();
    }
  });
}

// Dark mode toggle in dropdown
var darkMode = document.getElementById("dark-mode");
if (darkMode) {
  darkMode.addEventListener("click", async () => {
    const res = await window.fetch(`/darkmode`);
    if (res.status === 200) {
      window.location.reload();
    }
  });
}

// Load shortcuts
var shortcutsModal = document.getElementById("shortcutsModal");
shortcutsModal.addEventListener("shown.bs.modal", async () => {
  var shortcutsModalBody = document.getElementById("shortcutsModalBody");
  const res = await window.fetch(`/site/shortcuts`);
  shortcutsModalBody.innerHTML = await res.text();
});

// Load Cache
var cacheModal = document.getElementById("cacheModal");
if (cacheModal) {
  cacheModal.addEventListener("shown.bs.modal", async () => {
    var cacheModalBody = document.getElementById("cacheModalBody");
    const res = await window.fetch(`/site/cache-hits`);
    cacheModalBody.innerHTML = await res.text();
  });
}