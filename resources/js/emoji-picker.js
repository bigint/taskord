import { EmojiButton } from "@joeattardi/emoji-button";

const trigger = document.querySelector(".trigger");
const picker = new EmojiButton({
  showPreview: false
});
picker.on("emoji", selection => {
  trigger.innerHTML = selection.emoji;
  document.getElementById("emoji_input").value = selection.emoji;
});
trigger.addEventListener("click", () => picker.togglePicker(trigger));
