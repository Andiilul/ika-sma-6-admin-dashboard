<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Session</x-slot>

        <style>
            /* ===== Layout (NO Tailwind) ===== */
            .ika-grid-3 {
                display: grid;
                grid-template-columns: 1fr; /* mobile: 1 kolom */
                gap: 16px;
            }

            @media (min-width: 1024px) {
                .ika-grid-3 {
                    grid-template-columns: repeat(3, minmax(0, 1fr)); /* desktop: 3 kolom */
                }
            }

            /* ===== Card style ===== */
            .ika-card {
                min-width: 0; /* penting biar text panjang (email) gak ngerusak grid */
                border: 1px solid rgba(255, 255, 255, .08);
                background: rgba(255, 255, 255, .03);
                border-radius: 16px;
                padding: 18px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, .18);
                min-height: 140px;
            }

            .ika-title {
                font-size: 13px;
                font-weight: 600;
                color: rgba(255, 255, 255, .75);
                letter-spacing: .2px;
            }

            .ika-value {
                margin-top: 10px;
                font-size: 34px;
                font-weight: 700;
                color: #fff;
                line-height: 1.1;
                word-break: break-word;
            }

            .ika-row {
                margin-top: 10px;
                display: flex;
                align-items: center;
                gap: 10px;
                color: #34d399;
                font-size: 13px;
                font-weight: 600;
                min-width: 0;
            }

            .ika-icon {
                width: 22px;
                height: 22px;
                border-radius: 999px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: rgba(52, 211, 153, .14);
                flex: 0 0 auto;
            }

            .ika-icon svg {
                width: 14px;
                height: 14px;
                display: block;
            }

            .ika-sub {
                margin-top: 6px;
                font-size: 12px;
                color: rgba(255, 255, 255, .55);
            }

            .ika-truncate {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                max-width: 100%;
            }
        </style>

        <div
            x-data="{
                now: new Date(),
                loginAt: {{ $loginAt ? "new Date('{$loginAt->toIso8601String()}')" : "null" }},
                tick() { this.now = new Date(); },
                timeOnly() {
                    return this.now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                },
                dateOnly() {
                    return this.now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                },
                duration() {
                    if (!this.loginAt) return '-';
                    const diff = Math.max(0, this.now - this.loginAt);
                    let s = Math.floor(diff / 1000);
                    const h = Math.floor(s / 3600); s %= 3600;
                    const m = Math.floor(s / 60); s %= 60;
                    return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
                },
            }"
            x-init="setInterval(() => tick(), 1000)"
        >
            <div class="ika-grid-3">
                {{-- CARD 1: Welcome --}}
                <div class="ika-card">
                    <div class="ika-title">IKA SMAN 6 Dashboard</div>
                    <div class="ika-value">Welcome</div>

                    <div class="ika-row">
                        <span class="ika-icon" aria-hidden="true">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9 13.414l4.707-4.707z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        Panel admin siap digunakan
                    </div>

                    <div class="ika-sub">
                        Kelola alumni & activity secara terstruktur.
                    </div>
                </div>

                {{-- CARD 2: Account --}}
                <div class="ika-card">
                    <div class="ika-title">Account</div>

                    <div class="ika-value ika-truncate">
                        {{ \Filament\Facades\Filament::auth()->user()?->name ?? 'User' }}
                    </div>

                    <div class="ika-row">
                        <span class="ika-icon" aria-hidden="true">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 10a3 3 0 100-6 3 3 0 000 6z" />
                                <path fill-rule="evenodd"
                                    d="M.458 16.042C1.732 13.943 4.522 12 8 12h4c3.478 0 6.268 1.943 7.542 4.042A1 1 0 0118.707 18H1.293a1 1 0 01-.835-1.958z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="ika-truncate">{{ $userEmail ?? '-' }}</span>
                    </div>

                    <div class="ika-sub">
                        Login sejak:
                        <span style="color: rgba(255,255,255,.8); font-weight: 600;">
                            {{ $loginAt ? $loginAt->format('d M Y, H:i:s') : '-' }}
                        </span>
                    </div>
                </div>

                {{-- CARD 3: Time --}}
                <div class="ika-card">
                    <div class="ika-title">Time</div>

                    <div class="ika-value" x-text="timeOnly()"></div>

                    <div class="ika-row">
                        <span class="ika-icon" aria-hidden="true">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-12a.75.75 0 00-1.5 0v4.25c0 .25.125.484.333.624l2.5 1.667a.75.75 0 10.834-1.248L10.75 9.85V6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        Durasi login:
                        <span style="color: rgba(255,255,255,.8); font-weight: 700;" x-text="duration()"></span>
                    </div>

                    <div class="ika-sub" x-text="dateOnly()"></div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
