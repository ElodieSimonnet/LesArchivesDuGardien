document.addEventListener('DOMContentLoaded', () => {

    // --- Afficher / masquer le mot de passe ---
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.previousElementSibling;
            const eyeOpen   = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        });
    });

    // --- Indicateur de force du mot de passe ---
    document.querySelectorAll('.password-strength-input').forEach(input => {
        const container = document.getElementById(input.dataset.strength);
        if (!container) return;

        const bars  = container.querySelectorAll('.strength-bar');
        const label = container.querySelector('.strength-label');

        input.addEventListener('input', () => {
            const val = input.value;

            if (!val) {
                container.classList.add('hidden');
                return;
            }
            container.classList.remove('hidden');

            let score = 0;
            if (val.length >= 12)        score++;
            if (/[A-Z]/.test(val))       score++;
            if (/[a-z]/.test(val))       score++;
            if (/[0-9]/.test(val))       score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            let level, barColor, labelColor, filled;
            if (score <= 2) {
                level = 'Faible'; barColor = 'bg-red-500';    labelColor = 'text-red-400';    filled = 1;
            } else if (score <= 4) {
                level = 'Moyen';  barColor = 'bg-orange-400'; labelColor = 'text-orange-400'; filled = 2;
            } else {
                level = 'Fort';   barColor = 'bg-green-500';  labelColor = 'text-green-400';  filled = 3;
            }

            bars.forEach((bar, i) => {
                bar.className = `strength-bar h-1.5 flex-1 rounded transition-all duration-300 ${i < filled ? barColor : 'bg-gray-700'}`;
            });
            label.textContent = level;
            label.className   = `strength-label text-xs font-bold ${labelColor}`;
        });
    });

});
