require("./bootstrap");
require("./shortcuts");
require("./tribute");
import { isInViewport } from "observe-element-in-viewport";
import lightbox from "lightbox2/dist/js/lightbox";

window.lightbox = lightbox;
window.lightbox.option({
  disableScrolling: true,
  fadeDuration: 100,
  imageFadeDuration: 100,
  resizeDuration: 300,
  fitImagesInViewport: true,
  maxWidth: 1000,
});

$(document).ready(() => {
  (async () => {
    const target = document.querySelector("#load-more");
    if (await isInViewport(target)) {
      $("#load-more").click();
      $("#load-more").html("Loading");
      $("#load-more").prop("disabled", true);
    }
  })();
});

$(window).scroll(() => {
  if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
    $("#load-more").click();
    $("#load-more").html("Loading");
    $("#load-more").prop("disabled", true);
  }
});

// Admin Bar toggle in dropdown
$("#admin-bar-click").click(() => {
  $.get("/admin/adminbar", (data, status) => {
    if (data === "enabled" || data === "disabled") {
      if (status === "success") {
        location.reload();
      }
    }
  });
});

// Dark mode toggle in dropdown
$("#dark-mode").click(() => {
  $.get("/darkmode", (data, status) => {
    if (data === "enabled" || data === "disabled") {
      if (status === "success") {
        location.reload();
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
$("body").on("click", (_event) => {
  $("ul").remove(".search-dropdown");
});

$(() => {
  $("[data-toggle='tooltip']").tooltip();
});
