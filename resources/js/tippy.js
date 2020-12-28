import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";
import "tippy.js/animations/shift-away-subtle.css";
import "tippy.js/themes/light-border.css";

document.addEventListener("livewire:load", () => {
  const config = {
    allowHTML: true,
    maxWidth: 350,
    interactive: true,
    animation: "shift-away-subtle",
    theme: "light-border",
    delay: [200, 50],
    classList: "popover",
    content: `<div class="p-3"><div class="spinner-border spinner-border-sm text-dark"></div></div>`,
  };
  // User Popover
  tippy(".user-popover", {
    ...config,
    onShow(instance) {
      const id = instance.reference.getAttribute("data-id");
      window.fetch(`/popover/user/${id}`)
        .then((response) => response.text())
        .then((blob) => {
          instance.setContent(blob);
        })
        .catch((error) => {
          instance.setContent(`<div class="p-3">Something went wrong!</div>`);
        });
    },
    onHidden(instance) {
      instance.setContent(config.content);
      instance._src = null;
      instance._error = null;
    },
  });

  // Product Popover
  tippy(".product-popover", {
    ...config,
    onShow(instance) {
      const id = instance.reference.getAttribute("data-id");
      window.fetch(`/popover/product/${id}`)
        .then((response) => response.text())
        .then((blob) => {
          instance.setContent(blob);
        })
        .catch((error) => {
          instance.setContent(`<div class="p-3">Something went wrong!</div>`);
        });
    },
    onHidden(instance) {
      instance.setContent(config.content);
      instance._src = null;
      instance._error = null;
    },
  });

  tippy(".patron", {
    allowHTML: true,
    placement: "right",
    content: "Patron",
  });

  tippy(".verified", {
    allowHTML: true,
    placement: "right",
    content: "Verified",
  });

  tippy(".private", {
    allowHTML: true,
    placement: "right",
    content: "Private Profile",
  });
});
