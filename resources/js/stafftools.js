import { getLCP, getFID, getCLS, getFCP } from "web-vitals";

console.log(
  `%c🚀 Taskord stafftools turned on`,
  "color: #38c172; font-family: monospace; font-size: 20px; font-weight: bold"
);

function logVitalsInConsole({ name, delta }) {
  console.log(
    `%c[${name}] %c${parseFloat(name === "CLS" ? delta * 1000 : delta).toFixed(2)}`,
    "color: #6a63ec; font-family: monospace; font-size: 15px; font-weight: bold",
    "font-family: monospace; font-size: 15px; font-weight: bold",
  );
}

function logInConsole({ key, value }) {
  console.log(
    `%c[${key}] %c${value}`,
    "color: #6a63ec; font-family: monospace; font-size: 15px; font-weight: bold",
    "font-family: monospace; font-size: 15px; font-weight: bold",
  );
}

// Collect vital values
getCLS(logVitalsInConsole);
getFID(logVitalsInConsole);
getLCP(logVitalsInConsole);
getFCP(logVitalsInConsole);

// Log Git SHA in console
logInConsole({
  key: "Site SHA",
  value: document.getElementById("site-sha").innerHTML
});

// Toggle stats in adminbar
var expandStats = document.getElementById("expand-stats");
if (expandStats) {
  expandStats.addEventListener("click", async () => {
    document.getElementById("staffbar-stats").classList.toggle("d-none");
  });
}
