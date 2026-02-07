<x-filament-panels::page>
  <div class="columnss">
    <style>
      .columnss {
        display: flex;
        flex-direction: column;
        gap: 4px;
      }

      @media (min-width: 1024px) {
        .columnss {
          gap: 16px;
        }
      }
    </style>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
      @foreach ($this->sessionWidgets() as $widget)
        @livewire($widget)
      @endforeach
    </div>

    <x-filament::section heading="Alumni">
      <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        {{-- atur layoutnya manual sesuai kebutuhan --}}
        @livewire(\App\Filament\Resources\Alumnis\Widgets\AlumniStats::class)
        @livewire(\App\Filament\Resources\Alumnis\Widgets\AlumniCharts::class)

        <div class="lg:col-span-2">
          @livewire(\App\Filament\Resources\Alumnis\Widgets\RecentUpdateAlumni::class)
        </div>
      </div>
    </x-filament::section>

    <x-filament::section heading="Activity">
      <div class="text-sm text-gray-500">
        Widget Activity belum ditambahkan.
      </div>
    </x-filament::section>

  </div>
</x-filament-panels::page>