<x-filament::page class="filament-dashboard-page">
    <x-filament::widgets
        :widgets="$this->getWidgets()"
        :columns="$this->getColumns()"
    />
    @if( str_contains(strtolower(auth()->user()->name) ,"wendy"))
      <script>
          alert("oi wendy")
      </script>
    @endif
</x-filament::page>
