{{-- resources/views/welcome.blade.php --}}
@php
    $appName = config('app.name', 'IKA SMA 6');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $appName }}</title>

    {{-- Quick “keren” styling without setting up a build pipeline --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['ui-sans-serif', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji'],
                    },
                }
            }
        }
    </script>

    <style>
        /* subtle grid */
        .bg-grid {
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, .06) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, .06) 1px, transparent 1px);
            background-size: 36px 36px;
        }
    </style>
</head>

<body class="h-full bg-slate-950 text-slate-100 antialiased">
    <div class="relative min-h-full overflow-hidden">
        {{-- Decorative background --}}
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-40"></div>
        <div class="pointer-events-none absolute -top-24 -left-24 h-96 w-96 rounded-full bg-fuchsia-500/20 blur-3xl">
        </div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-cyan-500/20 blur-3xl">
        </div>

        {{-- Top bar --}}
        <header class="relative">
            <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-6">
                <a href="/" class="group inline-flex items-center gap-3">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/15">
                        {{-- simple logo mark --}}
                        <svg class="h-5 w-5 text-white/90" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2l9 5v10l-9 5-9-5V7l9-5Z" stroke="currentColor" stroke-width="1.6" />
                            <path d="M12 7v10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            <path d="M7.5 9.5 12 7l4.5 2.5" stroke="currentColor" stroke-width="1.6"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <div class="leading-tight">
                        <div class="text-sm font-semibold tracking-wide">{{ $appName }}</div>
                        <div class="text-xs text-slate-300/80">Admin Panel · Public API</div>
                    </div>
                </a>

                <div class="flex items-center gap-2">
                    <a href="/docs"
                        class="hidden sm:inline-flex rounded-xl bg-white/5 px-4 py-2 text-sm font-medium ring-1 ring-white/10 hover:bg-white/10">
                        API
                    </a>
                    <a href="/admin"
                        class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-slate-100">
                        Dashboard
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                            <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </nav>
        </header>

        {{-- Main --}}
        <main class="relative mx-auto max-w-6xl px-6 pb-16 pt-10 sm:pt-14">
            {{-- Hero --}}
            <section class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white/5 px-4 py-2 text-xs font-medium text-slate-200 ring-1 ring-white/10">
                        <span class="inline-block h-2 w-2 rounded-full bg-emerald-400"></span>
                        Laravel + Filament · Sanctum Ready
                    </div>

                    <h1 class="mt-6 text-4xl font-semibold tracking-tight sm:text-5xl">
                        Manajemen Sistem
                        <span class="text-white/70">IKA SMA 6 Makassar</span>
                    </h1>

                    <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-300">
                        Kelola data alumni dan kebutuhan sistem dalam satu panel</p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="/admin"
                            class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 hover:bg-slate-100">
                            Masuk Dashboard
                        </a>
                    </div>

                    <div class="mt-10 grid grid-cols-3 gap-4 text-xs text-slate-300/90">
                        <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                            <div class="text-slate-100 font-semibold">Alumni</div>
                            <div class="mt-1">Profil + foto + filter angkatan</div>
                        </div>
                        <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                            <div class="text-slate-100 font-semibold">Activity</div>
                            <div class="mt-1">Rich text + cover image + jadwal</div>
                        </div>
                        <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10">
                            <div class="text-slate-100 font-semibold">API v1</div>
                            <div class="mt-1">Public GET + auth untuk admin</div>
                        </div>
                    </div>
                </div>

                {{-- Preview card --}}
                <div class="relative">
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold">System Status</div>
                            <div
                                class="rounded-full bg-emerald-400/15 px-3 py-1 text-xs font-medium text-emerald-200 ring-1 ring-emerald-400/20">
                                Online
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3">
                            <div class="rounded-2xl bg-slate-900/60 p-4 ring-1 ring-white/10">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-sm font-semibold">Admin Panel</div>
                                        <div class="mt-1 text-xs text-slate-300">Filament resources untuk Alumni &
                                            Activity</div>
                                    </div>
                                    <a href="/admin" class="text-xs font-semibold text-white/90 hover:text-white">/admin
                                        →</a>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-900/60 p-4 ring-1 ring-white/10">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-sm font-semibold">API Base</div>
                                        <div class="mt-1 text-xs text-slate-300">Versi endpoint: <span
                                                class="text-slate-100">/api/v1</span></div>
                                    </div>
                                    <a href="/docs"
                                        class="text-xs font-semibold text-white/90 hover:text-white">/docs →</a>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-900/60 p-4 ring-1 ring-white/10">
                                <div class="text-sm font-semibold">Build Info</div>
                                <div class="mt-2 grid grid-cols-2 gap-3 text-xs text-slate-300">
                                    <div class="rounded-xl bg-white/5 p-3 ring-1 ring-white/10">
                                        <div class="text-slate-100 font-medium">Laravel</div>
                                        <div class="mt-1">{{ Illuminate\Foundation\Application::VERSION }}</div>
                                    </div>
                                    <div class="rounded-xl bg-white/5 p-3 ring-1 ring-white/10">
                                        <div class="text-slate-100 font-medium">PHP</div>
                                        <div class="mt-1">{{ PHP_VERSION }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="pointer-events-none absolute -inset-1 -z-10 rounded-3xl bg-gradient-to-r from-fuchsia-500/20 via-cyan-500/15 to-emerald-500/20 blur-xl">
                    </div>
                </div>
            </section>
            {{-- CTA --}}
            <!-- <section class="mt-16">
                <div
                    class="rounded-3xl bg-gradient-to-r from-white/10 via-white/5 to-white/10 p-8 ring-1 ring-white/10 sm:p-10">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-xl font-semibold">Mulai dari Admin Panel</h3>
                            <p class="mt-2 text-sm text-slate-300">
                                Login lalu kelola data Alumni dan Activity dalam satu dashboard.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="/admin"
                                class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 hover:bg-slate-100">
                                Go to /admin
                            </a>
                            <a href="/api/v1"
                                class="inline-flex items-center justify-center rounded-2xl bg-white/5 px-5 py-3 text-sm font-semibold text-slate-100 ring-1 ring-white/10 hover:bg-white/10">
                                Lihat /api/v1
                            </a>
                        </div>
                    </div>
                </div>
            </section> -->

            <footer class="mt-14 pb-6 text-xs text-slate-400">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        © {{ now()->year }} {{ $appName }} · Built with Laravel & Filament
                    </div>
                </div>
            </footer>
        </main>
    </div>
</body>

</html>