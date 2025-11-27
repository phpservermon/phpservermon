(function () {
    const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function buildAmbientGrid() {
        const main = document.querySelector('.app-main');
        if (!main || main.querySelector('.ambient-grid')) return;

        const grid = document.createElement('div');
        grid.className = 'ambient-grid';
        ['blue', 'teal', 'purple'].forEach((tone) => {
            const orb = document.createElement('span');
            orb.className = `orb orb-${tone}`;
            grid.appendChild(orb);
        });

        main.prepend(grid);
    }

    function decorateHero() {
        const hero = document.querySelector('.page-hero');
        if (!hero || hero.querySelector('.hero-aurora')) return;

        const aurora = document.createElement('div');
        aurora.className = 'hero-aurora';
        hero.prepend(aurora);
    }

    function addFrostedQuickActions() {
        const actions = document.querySelector('.nav-quick-actions');
        if (!actions) return;
        actions.classList.add('frosted-panel');
    }

    function animateEntrances() {
        if (prefersReducedMotion()) return;

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('animate-visible');
                    observer.unobserve(entry.target);
                });
            },
            { threshold: 0.2 }
        );

        document.querySelectorAll('.surface-card, .page-hero, .alert, .metric-card').forEach((element) => {
            element.classList.add('animate-on-scroll');
            observer.observe(element);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        buildAmbientGrid();
        decorateHero();
        addFrostedQuickActions();
        animateEntrances();
    });
})();
