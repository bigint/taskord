import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import 'tippy.js/animations/shift-away-subtle.css';
import 'tippy.js/themes/light-border.css';

document.addEventListener("livewire:load", () => {
  const config = {
    allowHTML: true,
    interactive: true,
    animation: 'shift-away-subtle',
    theme: 'light-border',
    delay: [200, 50],
    content: '<div class="p-3"><div class="spinner-border spinner-border-sm text-dark"></div></div>',
  };
  // User Popover
  tippy('#user-hover', {
    ...config,
    onShow(instance) {
      const id = instance.reference.getAttribute('data-id');
      window.fetch(`/hovercard/user/${id}`)
        .then((response) => response.text())
        .then((blob) => {
          instance.setContent(blob);
        })
        .catch((error) => {
          instance.setContent(`<div class="p-3">Something went wrong!</div>`);
        });
    },
  });
  
  // Product Popover
  tippy('#product-hover', {
    ...config,
    onShow(instance) {
      const id = instance.reference.getAttribute('data-id');
      window.fetch(`/hovercard/product/${id}`)
        .then((response) => response.text())
        .then((blob) => {
          instance.setContent(blob);
        })
        .catch((error) => {
          instance.setContent(`<div class="p-3">Something went wrong!</div>`);
        });
    },
  });
});
