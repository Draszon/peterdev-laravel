<footer class="border-t border-border-main py-10 text-center font-family-mono text-[11px] sm:text-xs text-text-dark px-4 space-y-4">
    <div class="flex justify-center items-center space-x-6 text-text-secondary">
        @foreach ($socialLinks as $link)
            <a href="{{ $link->formattedUrl }}" target="_blank" rel="noopener noreferrer" class="hover:text-accent-light transition-colors flex items-center gap-1.5">
                <span>// {{ $link->contact_name }}</span>
            </a>
        @endforeach
    </div>
    <div
        x-data="{
            currentYear: new Date().getFullYear(),
        }"
    >
    <p>&copy; <span x-text="currentYear"></span> &lt; PÉTER_DEV /&gt;. Minden jog fenntartva.</p>
    </div>
</footer>