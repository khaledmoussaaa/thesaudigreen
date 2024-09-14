<form method="GET" action="{{ $route }}">
    @csrf
    <div class="tooltip">
        <button type="submit" class="{{ $class }}"  name="{{ $name }}" value="{{ $uid ?? $rid }}">
            <i class="{{ $icon }}"></i>
            <span>{{ $text }}</span>
            <div class="tooltiptext">{{ $text }}</div>
        </button>
    </div>
</form>
