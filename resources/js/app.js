require("./shortcuts");
require("./tribute");
require("./tippy");
require("./clipboard");
require("./site");
import { isInViewport } from "observe-element-in-viewport";
import "@github/markdown-toolbar-element";

document.addEventListener("DOMContentLoaded", async () => {
  // Pagination
  Livewire.hook("component.initialized", () => {
    window.addEventListener("scroll", () => {
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
      var loadMore = document.getElementById("load-more");
      if (scrollTop + window.innerHeight > document.documentElement.scrollHeight - 100) {
        if (loadMore != null) {
          loadMore.click();
          loadMore.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
          loadMore.disabled = true;
        }
      }
    });
  });

  // Initial Pagination
  var loadMore = document.getElementById("load-more");
  if (loadMore && await isInViewport(loadMore)) {
    if (loadMore != null) {
      loadMore.click();
      loadMore.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
      loadMore.disabled = true;
    }
  }
});

// Staff bar toggle in dropdown
var staffBar = document.getElementById("staff-bar-click");
if (staffBar) {
  staffBar.addEventListener("click", async () => {
    const res = await window.fetch("/site/staffbar");
    if (res.status === 200) {
      window.location.reload();
    }
  });
}

// Dark mode toggle in dropdown
var darkMode = document.getElementById("dark-mode");
if (darkMode) {
  darkMode.addEventListener("click", async () => {
    const res = await window.fetch("/darkmode");
    if (res.status === 200) {
      window.location.reload();
    }
  });
}

window.addEventListener("toast", event => {
  var toastElList = [].slice.call(document.querySelectorAll(".toast"));
  var toastList = toastElList.map(function (toastEl) {
    return new bootstrap.Toast(toastEl);
  });
  toastList.forEach(toast => toast.show());
  const toastIcon = document.getElementById("toast-icon");
  if (event.detail.type === "success") {
    toastIcon.innerHTML = `<svg width="21" height="21" viewBox="0 0 21 21" fill="#ffffff" class="transform transition-transform duration-500 ease-in-out"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>`;
    toastIcon.classList.remove("bg-danger");
    toastIcon.classList.add("bg-success");
  } else if (event.detail.type === "error") {
    toastIcon.innerHTML = `<svg width="21" height="21" viewBox="0 0 21 21" fill="#ffffff" class="transform transition-transform duration-500 ease-in-out"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>`;
    toastIcon.classList.remove("bg-success");
    toastIcon.classList.add("bg-danger");
  }
  document.getElementById("toast-body").innerHTML = event.detail.body;
});

var lightboxModal = document.getElementById('lightboxModal')
lightboxModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget
  var image = button.getAttribute('data-bs-whatever')
  document.getElementById("lightbox-img").src = image;
  document.getElementById("lightbox-src").href = image;
})