<div class="tooltip">
    <button type="{{ $type }}" class="{{ $class }}" name="{{ $name }}" wire:click="{{ $click }}" @if($confirm) wire:confirm="{{ $confirm }}" @endif>
        <i class="{{ $icon }}"></i>
        <span>{{ $text }}</span>
        <div class="tooltiptext">{{ $text }}</div>
    </button>
</div>