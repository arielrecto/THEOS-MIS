
@props([
    'chartId',
    'labels' => [],
    'datasets' => [],
    'options' => [],
    'height' => '300px',
    'type' => 'bar'
])

<div x-data="chartData({
        chartId: '{{ $chartId }}',
        labels: {{ json_encode($labels) }},
        datasets: {{ json_encode($datasets) }},
        options: {{ json_encode($options) }},
        type: '{{ $type }}'
    })"
    x-init="initChart()"
    class="w-full"
    style="height: {{ $height }}">
    <canvas x-ref="canvas"></canvas>
</div>


