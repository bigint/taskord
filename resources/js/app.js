require("./bootstrap");
require("./shortcuts");
require("./tribute");
import { isInViewport } from "observe-element-in-viewport";
import lightbox from "lightbox2/dist/js/lightbox";
import "livewire-turbolinks";
var Turbolinks = require("turbolinks");
Turbolinks.start();

window.lightbox = lightbox;
window.lightbox.option({
  disableScrolling: true,
  fadeDuration: 100,
  imageFadeDuration: 100,
  resizeDuration: 300,
  fitImagesInViewport: true,
  maxWidth: 1000,
});

document.addEventListener('DOMContentLoaded', function() {
  (async () => {
    const target = document.querySelector("#load-more");
    if (await isInViewport(target)) {
      document.getElementById("load-more").click();
      document.getElementById("load-more").innerHTML = "Loading";
      document.getElementById("load-more").disabled = true;
    }
  })();
}, false);

$(window).scroll(() => {
  if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
    document.getElementById("load-more").click();
    document.getElementById("load-more").innerHTML = "Loading";
    document.getElementById("load-more").disabled = true;
  }
});

// Admin Bar toggle in dropdown
document.getElementById("admin-bar-click").addEventListener("click", () => {
  $.get("/admin/adminbar", (data, status) => {
    if (data === "enabled" || data === "disabled") {
      if (status === "success") {
        window.location.reload();
      }
    }
  });
});

// Dark mode toggle in dropdown
document.getElementById("dark-mode").addEventListener("click", () => {
  $.get("/darkmode", (data, status) => {
    if (data === "enabled" || data === "disabled") {
      if (status === "success") {
        window.location.reload();
      }
    }
  });
});

// Hide Alert
document.addEventListener("livewire:load", () => {
  window.Livewire.hook("element.updated", () => {
    setTimeout(() => {
      $(".fade").fadeOut("fast");
    }, 2000);
  });
});

// Hide search dropdown on clicking the body
document.body.addEventListener("click", () => {
  $("ul").remove(".search-dropdown");
});

$(() => {
  $("[data-toggle='tooltip']").tooltip();
});
