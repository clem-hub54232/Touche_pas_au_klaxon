'use strict';
// Confirmation progressive avant suppression. Les POST restent protégés par CSRF.
document.addEventListener('submit', function (event) {
  const form = event.target;
  if (form instanceof HTMLFormElement && form.dataset.confirm) {
    if (!window.confirm(form.dataset.confirm)) event.preventDefault();
  }
});
