<script>
    window.addEventListener('load', function() {
        document.querySelectorAll('.status-container').forEach(statusContainer => {
            Sortable.create(statusContainer, {
                group: statusContainer.dataset.{{ $sortableBetweenStatuses ? 'statusGroup' : 'statusId' }},
                animation: 300,
                ghostClass: '{{ $ghostClass }}',
                setData: function(dataTransfer, dragEl) {
                    dataTransfer.setData('id', dragEl.id);
                },
                onEnd: function(evt) {
                    const sameContainer = evt.from === evt.to;
                    const orderChanged = evt.oldIndex !== evt.newIndex;

                    if (sameContainer && !orderChanged) {
                        return;
                    }

                    const recordId = evt.item.id;

                    const fromStatusId = evt.from.dataset.statusId;
                    const fromOrderedIds = [].slice.call(evt.from.children).map(child => child.id);

                    if (sameContainer) {
                        @this.call('onStatusSorted', recordId, fromStatusId, fromOrderedIds);
                        return;
                    }

                    const toStatusId = evt.to.dataset.statusId;
                    const toOrderedIds = [].slice.call(evt.to.children).map(child => child.id);

                    @this.call('onStatusChanged', recordId, toStatusId, fromOrderedIds, toOrderedIds);
                },
            });
        })
    });
</script>