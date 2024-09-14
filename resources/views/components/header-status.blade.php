<div class="header">
    <i class="{{ $icon }}"> {{ $text }}</i>
    @if($status || $status == 0)
    <div class="status @switch($status) @case(0) orange @break @case(1) || @case(6) gray  @break @case(2) || @case(7) red @break @case(3) green @break @case(4) dark @break @case(5) lightBlue @endswitch">
        {{ __('translate.' . ['pending', 'inprocess', 'declined', 'inprogress', 'finished', 'completed','firstApproval','firstReject'][$status]) }}
    </div>
    @endif
</div>