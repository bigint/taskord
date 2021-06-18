// Load shortcuts
var shortcutsModal = document.getElementById("shortcutsModal");
shortcutsModal.addEventListener("shown.bs.modal", async () => {
  var shortcutsModalBody = document.getElementById("shortcutsModalBody");
  const res = await window.fetch(`/site/shortcuts`);
  shortcutsModalBody.innerHTML = await res.text();
});

// Load Data from GitLab
var deployModal = document.getElementById("deployModal");
if (deployModal) {
  // Load Commit Data
  deployModal.addEventListener("shown.bs.modal", async () => {
    var deployModalCommitBody = document.getElementById("deployModalCommitBody");
    const res = await window.fetch(`/site/commits-data`);
    deployModalCommitBody.innerHTML = await res.text();
  });

  // Load CI Data
  deployModal.addEventListener("shown.bs.modal", async () => {
    var deployModalCIBody = document.getElementById("deployModalCIBody");
    const res = await window.fetch(`/site/ci-data`);
    deployModalCIBody.innerHTML = await res.text();
  });
}
