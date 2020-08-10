import hotkeys from 'hotkeys-js';

// Admin Bar
hotkeys('`, p+b', () => {
  $.get("/admin/adminbar", (data, status) => {
    if(data === "enabled" || data === "disabled") {
      if (status === "success") {
        location.reload();
      }
    }
  });
});

// Dark Mode
hotkeys('d+m', () => {
  $.get("/darkmode", (data, status) => {
    if(data === "enabled" || data === "disabled") {
      if (status === "success") {
        location.reload();
      }
    }
  });
});

// Go to home
hotkeys('g+h', () => {
  window.location.href = "/";
});

// Go to products
hotkeys('g+p', () => {
  window.location.href = "/products";
});

// Go to settings
hotkeys('g+s', () => {
  window.location.href = "/settings";
});
