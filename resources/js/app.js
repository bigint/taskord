require("./shortcuts");
require("./tribute");
// require("./tippy");
import { isInViewport } from "observe-element-in-viewport";
import "livewire-turbolinks";
import TurbolinksPrefetch from "turbolinks-prefetch";

var Turbolinks = require("turbolinks");
Turbolinks.start();
TurbolinksPrefetch.start();

// Pagination
document.addEventListener("DOMContentLoaded", () => {
  Livewire.hook('component.initialized', () => {
    window.addEventListener("scroll", () => {
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
      if (scrollTop + window.innerHeight > document.documentElement.scrollHeight - 100) {
        document.getElementById("load-more").click();
        document.getElementById("load-more").innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        document.getElementById("load-more").disabled = true;
      }
    });
  })
});

document.addEventListener("turbolinks:load", async () => {
  // Initial Pagination
  const target = document.querySelector("#load-more");
  if (await isInViewport(target)) {
    document.getElementById("load-more").click();
    document.getElementById("load-more").innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
    document.getElementById("load-more").disabled = true;
  }

  // Admin Bar toggle in dropdown
  document.getElementById("admin-bar-click").addEventListener("click", async () => {
    const res = await window.fetch(`/admin/adminbar`);
    if (res.status === 200) {
      location.reload();
    }
  });

  // Dark mode toggle in dropdown
  document.getElementById("dark-mode").addEventListener("click", async () => {
    const res = await window.fetch(`/darkmode`);
    if (res.status === 200) {
      location.reload();
    }
  });

  // Load shortcuts
  var shortcutsModal = document.getElementById("shortcutsModal")
  shortcutsModal.addEventListener("shown.bs.modal", async () => {
    var shortcutsModalBody = document.getElementById("shortcutsModalBody");
    const res = await window.fetch(`/site/shortcuts`);
    shortcutsModalBody.innerHTML = await res.text();
  });
});
