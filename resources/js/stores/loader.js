import { defineStore } from 'pinia';

// Delay before the bar actually appears, so very fast requests don't cause
// a single-frame flash on screen.
const SHOW_DELAY_MS = 120;
// Minimum time the bar stays visible once it *is* shown, so it doesn't
// snap off the screen the moment a request finishes.
const MIN_VISIBLE_MS = 400;

export const useLoaderStore = defineStore('loader', {
    state: () => ({
        pending: 0,
        visible: false,
        _showTimer: null,
        _hideTimer: null,
        _shownAt: 0,
    }),
    getters: {
        active: (state) => state.visible,
    },
    actions: {
        start() {
            this.pending++;
            // If we're already visible, nothing else to do.
            if (this.visible) return;
            // Cancel any pending hide — we're active again.
            if (this._hideTimer) {
                clearTimeout(this._hideTimer);
                this._hideTimer = null;
            }
            // Schedule the bar to appear only if the request hasn't finished
            // within SHOW_DELAY_MS. This hides flashes on fast requests.
            if (!this._showTimer) {
                this._showTimer = setTimeout(() => {
                    this._showTimer = null;
                    if (this.pending > 0) {
                        this.visible = true;
                        this._shownAt = Date.now();
                    }
                }, SHOW_DELAY_MS);
            }
        },
        stop() {
            this.pending = Math.max(0, this.pending - 1);
            if (this.pending > 0) return;
            this._scheduleHide();
        },
        reset() {
            this.pending = 0;
            this._scheduleHide();
        },
        _scheduleHide() {
            // If the bar never became visible, cancel the pending show and
            // bail out — user never saw anything.
            if (this._showTimer && !this.visible) {
                clearTimeout(this._showTimer);
                this._showTimer = null;
                return;
            }
            if (!this.visible) return;
            // Ensure the bar stays visible for at least MIN_VISIBLE_MS so
            // it doesn't flicker off instantly on the last response.
            const elapsed = Date.now() - this._shownAt;
            const wait = Math.max(0, MIN_VISIBLE_MS - elapsed);
            if (this._hideTimer) clearTimeout(this._hideTimer);
            this._hideTimer = setTimeout(() => {
                this._hideTimer = null;
                // Only actually hide if nothing new started in the meantime.
                if (this.pending === 0) {
                    this.visible = false;
                }
            }, wait);
        },
    },
});
