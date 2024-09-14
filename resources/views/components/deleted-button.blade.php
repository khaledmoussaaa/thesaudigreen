

<div class="tooltip">
    <button type="submit" class="button hoverButton danger" name="delete" wire:click="{{ $click }}">
        <i class="bi bi-trash bt-icon"></i>
        <span>{{ __('translate.delete') }}</span>
        <div class="tooltiptext">{{ __('translate.delete') }}</div>
    </button>
</div>

<script>
    document.addEventListener("livewire:init", () => {
        Livewire.on("alert", id => {
            Swal.fire({
                title: "{{ __('translate.sureDeleteR') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ __('translate.deletedIt') }}",
                cancelButtonText: "{{ __('translate.cancel') }}",
                heightAuto: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "{{ __('translate.deleted') }}",
                        text: "{{ __('translate.theRequestDeleted') }}",
                        icon: "success",
                        heightAuto: false,
                    });
                    Livewire.dispatch('delete', {
                        id: id
                    })
                }
            });
        });
    });
</script>