// ═══════════════════════════════════════════════════
//  TESTIMONIAL CAROUSEL (Alpine component)
// ═══════════════════════════════════════════════════

function testimonialCarousel() {
    return {
        current: 0,
        total: 0,
        paused: false,
        visibleCount: 2,
        intervalId: null,
        slideDuration: 4500,

        init() {
            const track = this.$el.querySelector('[data-carousel-track]');
            if (track) this.total = track.children.length;
            this.updateVisibleCount();
            window.addEventListener('resize', () => this.updateVisibleCount());
            this.startAuto();
        },

        updateVisibleCount() {
            this.visibleCount = window.innerWidth >= 1024 ? 3 : 2;
        },

        maxIndex() {
            return Math.max(0, this.total - this.visibleCount);
        },

        next() {
            this.current = this.current >= this.maxIndex() ? 0 : this.current + 1;
            this.resetAuto();
        },

        prev() {
            this.current = this.current <= 0 ? this.maxIndex() : this.current - 1;
            this.resetAuto();
        },

        goTo(i) {
            this.current = Math.min(i, this.maxIndex());
            this.resetAuto();
        },

        togglePause() {
            this.paused = !this.paused;
            this.paused ? clearInterval(this.intervalId) : this.startAuto();
        },

        startAuto() {
            clearInterval(this.intervalId);
            this.intervalId = setInterval(() => {
                if (!this.paused) this.next();
            }, this.slideDuration);
        },

        resetAuto() {
            if (!this.paused) this.startAuto();
        },
    };
}
