import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

document.addEventListener("livewire:load", () => {
  // User Popover
  tippy('#user-hover', {
    allowHTML: true,
    interactive: true,
    animation: 'scale',
    content: '<div class="p-3"><div class="spinner-border spinner-border-sm text-light"></div></div>',
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
    allowHTML: true,
    interactive: true,
    animation: 'scale',
    content: '<div class="p-3"><div class="spinner-border spinner-border-sm text-light"></div></div>',
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
