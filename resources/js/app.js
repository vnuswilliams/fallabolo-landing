// ─────────────────────────────────────────────────────────────────────────────
// testimonialCarousel — Alpine.js component
// Infinite-loop scroll by DOM cloning (no visible seam), full-width track,
// auto-play with pause on hover / touch, swipe support.
//
// Usage : x-data="testimonialCarousel({{ count($testimonials) }})"
// ─────────────────────────────────────────────────────────────────────────────

document.addEventListener('alpine:init', () => {
    Alpine.data('testimonialCarousel', (total) => ({

        // ── State ─────────────────────────────────────────────────────────────
        total,                  // number of REAL cards (passed from Blade)
        current:    0,          // index in the REAL card range
        playing:    true,
        interval:   null,
        touchStartX: 0,
        touchDeltaX: 0,
        DELAY:      4500,       // ms between auto-slides
        DURATION:   520,        // ms CSS transition duration
        clonesBefore: 3,        // how many clones to prepend
        clonesAfter:  3,        // how many clones to append
        transitioning: false,

        // ── Boot ──────────────────────────────────────────────────────────────
        init() {
            this.$nextTick(() => {
                this._buildClones();
                this._render(false);     // no transition on first paint
            });

            this.play();

            // Pause when tab is hidden
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    this.pause();
                } else if (this.playing) {
                    this.play();
                }
            });

            // Re-render on resize without transition
            window.addEventListener('resize', () => this._render(false));
        },

        // ── Clone real cards before & after for seamless loop ────────────────
        _buildClones() {
            const track = this._track();
            if (!track) return;

            // Remove any previously injected clones (hot-reload safety)
            track.querySelectorAll('[data-clone]').forEach(el => el.remove());

            const originals = Array.from(track.querySelectorAll('.testimonial-card:not([data-clone])'));
            if (!originals.length) return;

            // Prepend last N originals (reversed)
            const before = originals.slice(-this.clonesBefore).reverse();
            before.forEach(el => {
                const clone = el.cloneNode(true);
                clone.setAttribute('data-clone', 'before');
                clone.setAttribute('aria-hidden', 'true');
                track.prepend(clone);
            });

            // Append first N originals
            const after = originals.slice(0, this.clonesAfter);
            after.forEach(el => {
                const clone = el.cloneNode(true);
                clone.setAttribute('data-clone', 'after');
                clone.setAttribute('aria-hidden', 'true');
                track.append(clone);
            });
        },

        // ── Core render ───────────────────────────────────────────────────────
        // realIndex = position in the *original* card list (0-based)
        // The DOM index of that card = clonesBefore + realIndex
        _render(animate = true) {
            const track = this._track();
            if (!track) return;

            const allCards = track.querySelectorAll('.testimonial-card');
            if (!allCards.length) return;

            const gap   = this._gap();
            const cardW = allCards[0].offsetWidth + gap;

            // DOM position of the "real" current card
            const domIndex = this.clonesBefore + this.current;

            // Offset so the active card is centred in the viewport
            const viewW  = track.parentElement.offsetWidth;
            const offset = (viewW / 2) - (allCards[0].offsetWidth / 2) - (domIndex * cardW);

            track.style.transition = animate
                ? `transform ${this.DURATION}ms cubic-bezier(.4,0,.2,1)`
                : 'none';
            track.style.transform = `translateX(${offset}px)`;
        },

        // ── Silent teleport for the infinite loop ─────────────────────────────
        // After sliding into a clone, we instantly jump to the real counterpart
        // with transition:none so the user never sees a seam.
        _checkBounds() {
            if (this.current < 0) {
                this.current = this.total - 1;
                this._render(false);
            } else if (this.current >= this.total) {
                this.current = 0;
                this._render(false);
            }
        },

        // ── Navigation ────────────────────────────────────────────────────────
        goTo(index) {
            if (this.transitioning) return;
            this.current = ((index % this.total) + this.total) % this.total;
            this._render(true);
            this._resetTimer();
        },

        next() {
            if (this.transitioning) return;
            this.transitioning = true;
            this.current += 1;
            this._render(true);

            setTimeout(() => {
                this._checkBounds();
                this.transitioning = false;
            }, this.DURATION);

            this._resetTimer();
        },

        prev() {
            if (this.transitioning) return;
            this.transitioning = true;
            this.current -= 1;
            this._render(true);

            setTimeout(() => {
                this._checkBounds();
                this.transitioning = false;
            }, this.DURATION);

            this._resetTimer();
        },

        // ── Auto-play ─────────────────────────────────────────────────────────
        play() {
            this.playing = true;
            this._clearTimer();
            this.interval = setInterval(() => this.next(), this.DELAY);
        },

        pause() {
            this.playing = false;
            this._clearTimer();
        },

        togglePlay() {
            this.playing ? this.pause() : this.play();
        },

        _clearTimer() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },

        _resetTimer() {
            if (this.playing) {
                this._clearTimer();
                this.interval = setInterval(() => this.next(), this.DELAY);
            }
        },

        // ── Touch / swipe ─────────────────────────────────────────────────────
        onTouchStart(e) {
            this.pause();
            this.touchStartX = e.touches[0].clientX;
            this.touchDeltaX = 0;
        },

        onTouchMove(e) {
            this.touchDeltaX = e.touches[0].clientX - this.touchStartX;
        },

        onTouchEnd() {
            const threshold = 48;
            if (Math.abs(this.touchDeltaX) > threshold) {
                this.touchDeltaX < 0 ? this.next() : this.prev();
            }
            this.play();
        },

        // ── Helpers ───────────────────────────────────────────────────────────
        _track() {
            return document.getElementById('testimonial-track');
        },

        _gap() {
            // Read the actual computed gap from the flex container
            const track = this._track();
            if (!track) return 20;
            const style = window.getComputedStyle(track);
            return parseFloat(style.gap || style.columnGap || '20') || 20;
        },
    }));
});
