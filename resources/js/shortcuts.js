import hotkeys from "hotkeys-js";

// Admin Bar
hotkeys("`, p+b", async () => {
  const res = await window.fetch(`/admin/adminbar`);
  if (res.status === 200) {
    location.reload();
  }
});

// Dark Mode
hotkeys("d+m", async () => {
  const res = await window.fetch(`/darkmode`);
  if (res.status === 200) {
    location.reload();
  }
});

// Go to home
hotkeys("g+h", () => {
  window.location.href = "/";
});

// Go to products
hotkeys("g+p", () => {
  window.location.href = "/products";
});

// Go to settings
hotkeys("g+s", () => {
  window.location.href = "/settings";
});
