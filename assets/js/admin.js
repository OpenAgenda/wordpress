document.addEventListener('DOMContentLoaded', () => {
    const passwordToggles = document.querySelectorAll('.password-toggle [type="checkbox"]');
    if (!passwordToggles) return;

    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', e => {
            const inputId = toggle.dataset.input;
            const input = inputId ? document.querySelector(`#${inputId}`) : null;
            if (input) input.setAttribute('type', toggle.checked ? 'text' : 'password');
        });
    });
});