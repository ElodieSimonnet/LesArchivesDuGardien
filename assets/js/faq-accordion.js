const faqTriggers = document.querySelectorAll('.faq-trigger');

faqTriggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
        const container = trigger.closest('.group');
        const content = document.getElementById(trigger.getAttribute('aria-controls'));
        const icon = trigger.querySelector('.arrow-icon');
        const isOpen = trigger.getAttribute('aria-expanded') === 'true';

        if (isOpen) {
            
            trigger.setAttribute('aria-expanded', 'false');
            content.style.maxHeight = '0px';
            icon.style.transform = 'rotate(0deg)';
            
            
            trigger.classList.remove('bg-primary-orange', 'text-primary-black');
            container.classList.remove('is-active');
        } else {
            
            trigger.setAttribute('aria-expanded', 'true');
        
            content.style.maxHeight = content.scrollHeight + "px";
            icon.style.transform = 'rotate(180deg)';
            
            
            trigger.classList.add('bg-primary-orange', 'text-primary-black');
            container.classList.add('is-active');
        }
    });
});
