@if (config('services.google_analytics.id'))
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}

        // Alapértelmezés: minden tiltva, amíg a felhasználó nem fogad el
        gtag('consent', 'default', {
            ad_storage: 'denied',
            ad_user_data: 'denied',
            ad_personalization: 'denied',
            analytics_storage: 'denied'
        });

        // Korábbi elfogadás visszaállítása
        try {
            if (localStorage.getItem('cookie_consent') === 'granted') {
                gtag('consent', 'update', { analytics_storage: 'granted' });
            }
        } catch (e) {}

        gtag('js', new Date());
        gtag('config', '{{ config('services.google_analytics.id') }}');
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
@endif