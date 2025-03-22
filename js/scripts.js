document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            const password = document.getElementById('senha');
            const confirmPassword = document.getElementById('confirmaSenha');

            if (password && confirmPassword && password.value !== confirmPassword.value) {
                e.preventDefault();
                alert('As senhas não correspondem. Por favor, verifique.');
            }
        });
    }
});
