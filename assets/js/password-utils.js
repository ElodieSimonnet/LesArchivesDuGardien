document.addEventListener('DOMContentLoaded', () => {

    
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

    
    document.querySelectorAll('.password-strength-input').forEach(input => {
        const container = document.getElementById(input.dataset.strength);
        if (!container) return;

        const bars  = container.querySelectorAll('.strength-bar');
        const label = container.querySelector('.strength-label');

        let hintsList = container.querySelector('.strength-hints');
        if (!hintsList) {
            hintsList = document.createElement('ul');
            hintsList.className = 'strength-hints mt-1 flex flex-wrap gap-x-3 gap-y-1';
            container.appendChild(hintsList);
        }

        const criteria = [
            { test: v => v.length >= 12,          label: '12 caractères minimum' },
            { test: v => /[A-Z]/.test(v),          label: '1 majuscule' },
            { test: v => /[a-z]/.test(v),          label: '1 minuscule' },
            { test: v => /[0-9]/.test(v),          label: '1 chiffre' },
            { test: v => /[^A-Za-z0-9]/.test(v),  label: '1 caractère spécial' },
        ];

        input.addEventListener('input', () => {
            const val = input.value;

            if (!val) {
                container.classList.add('hidden');
                return;
            }
            container.classList.remove('hidden');

            let score = 0;
            criteria.forEach(c => { if (c.test(val)) score++; });

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

            hintsList.innerHTML = '';
            criteria.forEach(c => {
                const met = c.test(val);
                const li = document.createElement('li');
                li.className = `text-xs flex items-center gap-1 ${met ? 'text-green-400' : 'text-red-400'}`;
                li.innerHTML = `<span aria-hidden="true">${met ? '✓' : '✗'}</span> ${c.label}`;
                hintsList.appendChild(li);
            });
        });
    });

    document.querySelectorAll('.password-confirm-input').forEach(confirmInput => {
        const mainInput = document.getElementById(confirmInput.dataset.confirmFor);
        if (!mainInput) return;

        const feedback = document.createElement('p');
        feedback.className = 'text-xs font-bold mt-1 hidden';
        confirmInput.closest('div').parentElement.after(feedback);

        function checkMatch() {
            if (!confirmInput.value) { feedback.classList.add('hidden'); return; }
            const match = confirmInput.value === mainInput.value;
            feedback.classList.remove('hidden', 'text-green-400', 'text-red-400');
            feedback.classList.add(match ? 'text-green-400' : 'text-red-400');
            feedback.textContent = match ? '✓ Les mots de passe correspondent' : '✗ Les mots de passe ne correspondent pas';
        }

        confirmInput.addEventListener('input', checkMatch);
        mainInput.addEventListener('input', checkMatch);
    });

});
