document.addEventListener("DOMContentLoaded", async () => {
  const clipboardActions = document.querySelectorAll('.js-clipboard');

  for (const action of clipboardActions) {
    action.addEventListener('click', () => {
      const inputId = action.getAttribute('data-for');

      if (!inputId) {
        return;
      }

      const input = document.querySelector(inputId);

      if (input) {
        input.select();
        input.setSelectionRange(0, input.value.length);
        document.execCommand('copy');

        if (!input.classList.contains('is-valid')) {
          // visual feedback
          input.classList.add('is-valid');
          setTimeout(() => input.classList.remove('is-valid'), 800);
        }
      }
    });
  }
});