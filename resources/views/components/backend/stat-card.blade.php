@props(['value' => '0', 'label' => '', 'change' => null, 'changeType' => 'positive'])

<div class="stat-card">
    @if(isset($icon))
    <div class="stat-icon">{{ $icon }}</div>
    @endif

    <div class="stat-value">{{ $value }}</div>
    <div class="stat-label">{{ $label }}</div>

    @if($change)
    <div class="stat-change {{ $changeType }}">{{ $change }}</div>
    @endif
</div>
