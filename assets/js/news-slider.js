(function() {
    const slides = document.querySelectorAll('.news-slide');
    if (slides.length === 0) return;

    let current = 0;
    const total = slides.length;
    const btnPrev = document.getElementById('btn-prev');
    const btnNext = document.getElementById('btn-next');
    const pageNumbers = document.getElementById('page-numbers');
    const pagination = document.getElementById('news-pagination');

    if (total <= 1) {
        if (pagination) pagination.style.display = 'none';
        if (btnPrev) btnPrev.style.display = 'none';
        if (btnNext) btnNext.style.display = 'none';
    }

    function showSlide(index) {
        slides.forEach(s => s.classList.add('hidden'));
        slides[index].classList.remove('hidden');
        current = index;
        renderPageNumbers();
    }

    function prev() {
        showSlide(current > 0 ? current - 1 : total - 1);
    }

    function next() {
        showSlide(current < total - 1 ? current + 1 : 0);
    }

    function renderPageNumbers() {
        if (!pageNumbers) return;
        pageNumbers.innerHTML = '';

        for (let i = 0; i < total; i++) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = i + 1;
            btn.setAttribute('aria-label', 'Voir l\'actualité ' + (i + 1));
            btn.setAttribute('aria-pressed', i === current ? 'true' : 'false');
            btn.className = 'flex items-center justify-center w-10 h-10 md:w-12 md:h-12 bg-primary-brown border-2 rounded-xl text-primary-white font-black text-lg md:text-xl cursor-pointer ' +
                (i === current ? 'border-primary-orange' : 'border-primary-orange/40');
            btn.addEventListener('click', () => showSlide(i));
            pageNumbers.appendChild(btn);
        }
    }

    if (btnPrev) btnPrev.addEventListener('click', prev);
    if (btnNext) btnNext.addEventListener('click', next);

    renderPageNumbers();
})();
