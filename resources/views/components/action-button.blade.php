<button type="submit" class="{{ $class }}" wire:click="{{ $click }}">
    <i class="{{ $icon }}"></i>
</button>
<script>
    document.addEventListener("livewire:init", () => {
        Livewire.on("alert", user => {
            console.log(user);
            Swal.fire({
                title: user[2] === 'delete' ? `{{ __('translate.delete') }}` : user[3] === 'block' ? `{{ __('translate.activate') }}` : `{{ __('translate.block') }}`,
                text: user[2] === 'delete' ? `{{ __('translate.sureDeleteU') }}` : user[3] === 'block' ? `{{ __('translate.sureActivateU') }}` : `{{ __('translate.sureBlockU') }}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: user[2] === 'delete' ? `{{ __('translate.deletedIt') }}` : user[3] === 'block' ? `{{ __('translate.activatedIt') }}` : `{{ __('translate.blockedIt') }}`,
                cancelButtonText: "{{ __('translate.cancel') }}",
                heightAuto: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: user[2] === 'delete' ? `{{ __('translate.deleted') }}` : user[3] === 'block' ? `{{ __('translate.activated') }}` : `{{ __('translate.blockedd') }}`,
                        text: user[2] === 'delete' ? `{{ __('translate.userDeleted') }}` : user[3] === 'block' ? `{{ __('translate.userActivated') }}` : `{{ __('translate.userBlocked') }}`,
                        icon: "success",
                        heightAuto: false,
                    });
                    if (user[2] === 'delete') {
                        Livewire.dispatch('delete', {
                            id: user[0]
                        })
                    } else {
                        Livewire.dispatch('blockOrActive', {
                            id: user[0]
                        })
                    }
                }
            });
        });
    });
</script>