import hotkeys from "hotkeys-js";

// Shortcut Modal
hotkeys("s+c", async () => {
    (new bootstrap.Modal(document.getElementById("shortcutsModal"))).show();
});

// Admin Bar
hotkeys("p+b, `", async () => {
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

// Go to user profile
hotkeys("g+u", () => {
  const username = document.getElementById("taskord-username").innerHTML.trim()
  window.location.href = "/@" + username;
});

// Go to products
hotkeys("g+p", () => {
  window.location.href = "/products";
});

// Go to questions
hotkeys("g+q", () => {
  window.location.href = "/questions";
});

// Go to notifications
hotkeys("g+n", () => {
  window.location.href = "/notifications";
});

// Go to settings
hotkeys("g+s", () => {
  window.location.href = "/settings";
});

// Create new issue in GitLab
hotkeys("n+i", () => {
  var nAgt = navigator.userAgent;
  var browserName = navigator.appName;
  var fullVersion = "" + parseFloat(navigator.appVersion);
  var nameOffset, verOffset, ix;

  // In Opera 15+, the true version is after "OPR/"
  if ((verOffset = nAgt.indexOf("OPR/")) != -1) {
    browserName = "Opera";
    fullVersion = nAgt.substring(verOffset + 4);
  }
  // In older Opera, the true version is after "Opera" or after "Version"
  else if ((verOffset = nAgt.indexOf("Opera")) != -1) {
    browserName = "Opera";
    fullVersion = nAgt.substring(verOffset + 6);
    if ((verOffset = nAgt.indexOf("Version")) != -1)
      fullVersion = nAgt.substring(verOffset + 8);
  }
  // In MSIE, the true version is after "MSIE" in userAgent
  else if ((verOffset = nAgt.indexOf("MSIE")) != -1) {
    browserName = "Microsoft Internet Explorer";
    fullVersion = nAgt.substring(verOffset + 5);
  }
  // In Chrome, the true version is after "Chrome"
  else if ((verOffset = nAgt.indexOf("Chrome")) != -1) {
    browserName = "Chrome";
    fullVersion = nAgt.substring(verOffset + 7);
  }
  // In Safari, the true version is after "Safari" or after "Version"
  else if ((verOffset = nAgt.indexOf("Safari")) != -1) {
    browserName = "Safari";
    fullVersion = nAgt.substring(verOffset + 7);
    if ((verOffset = nAgt.indexOf("Version")) != -1)
      fullVersion = nAgt.substring(verOffset + 8);
  }
  // In Firefox, the true version is after "Firefox"
  else if ((verOffset = nAgt.indexOf("Firefox")) != -1) {
    browserName = "Firefox";
    fullVersion = nAgt.substring(verOffset + 8);
  }
  // In most other browsers, "name/version" is at the end of userAgent
  else if ((nameOffset = nAgt.lastIndexOf(" ") + 1) <
    (verOffset = nAgt.lastIndexOf("/"))) {
    browserName = nAgt.substring(nameOffset, verOffset);
    fullVersion = nAgt.substring(verOffset + 1);
    if (browserName.toLowerCase() == browserName.toUpperCase()) {
      browserName = navigator.appName;
    }
  }
  // trim the fullVersion string at semicolon/space if present
  if ((ix = fullVersion.indexOf(";")) != -1)
    fullVersion = fullVersion.substring(0, ix);
  if ((ix = fullVersion.indexOf(" ")) != -1)
    fullVersion = fullVersion.substring(0, ix);

  const description = `
**Describe the bug**\n\n
**To Reproduce**\n\n
**Expected behaviour**\n\n
**Screenshots**\n\n
**Additional context**\n\n
**Browser Details**\n
${"```"}
Base URL: ${window.location.origin}
Taskord Version: ${document.getElementById("taskord-version").innerHTML.trim()}
Browser name: ${browserName}
Full version: ${fullVersion}
Platform: ${window.navigator.platform}
Language: ${window.navigator.language}
Cookie Enabled: ${window.navigator.cookieEnabled}
Online: ${window.navigator.onLine}
${"```"}

<sub>**Created via Taskord.com**</sub>`
  window.open("https://gitlab.com/taskord/taskord/-/issues/new?issue[description]=" + encodeURI(description));
});
