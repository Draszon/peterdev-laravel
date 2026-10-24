@if (config('services.google_analytics.id'))
<div
    x-data="{
        show: false,
        init() {
            try { this.show = localStorage.getItem('cookie_consent') === null; }
            catch (e) { this.show = true; }
        },
        choose(value) {
            try { localStorage.setItem('cookie_consent', value); } catch (e) {}
            if (window.gtag) {
                gtag('consent', 'update', { analytics_storage: value });
            }
            this.show = false;
        }
    }"
    x-show="show"
    x-cloak
    x-transition.opacity
    class="fixed inset-x-4 bottom-4 z-50 mx-auto max-w-3xl rounded-xl border border-gray-200 bg-white p-4 shadow-xl sm:p-5"
    role="dialog"
    aria-label="Süti beállítások"
>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
        <p class="text-sm text-gray-700">
            Az oldalon anonim látogatottsági statisztikához Google Analytics sütiket használunk.
            Csak az engedélyed után kerülnek elhelyezésre.
            <a href="{{ url('/adatkezelesi-tajekoztato') }}" class="underline">Bővebben</a>
        </p>
        <div class="flex shrink-0 gap-2">
            <button type="button" @click="choose('denied')"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Elutasítom
            </button>
            <button type="button" @click="choose('granted')"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Elfogadom
            </button>
        </div>
    </div>
</div>
@endif