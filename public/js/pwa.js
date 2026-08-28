(() => {
    let installPrompt;
    const installButtons = document.querySelectorAll('[data-pwa-install]');

    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;

    const setButtonVisibility = (visible) => {
        installButtons.forEach((button) => {
            button.hidden = !visible;
        });
    };

    if (isStandalone) {
        setButtonVisibility(false);
    }

    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        installPrompt = event;
        setButtonVisibility(true);
    });

    installButtons.forEach((button) => {
        button.addEventListener('click', async () => {
            if (!installPrompt) {
                return;
            }

            installPrompt.prompt();
            const choice = await installPrompt.userChoice;
            if (choice.outcome === 'accepted') {
                setButtonVisibility(false);
            }
            installPrompt = null;
        });
    });

    window.addEventListener('appinstalled', () => {
        installPrompt = null;
        setButtonVisibility(false);
    });

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        });
    }
})();
