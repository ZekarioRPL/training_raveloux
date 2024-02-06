<div class="flex">
    @if (auth()->user()->can("view-$route"))
        @if (!in_array('show', $exceptActions ?? []))
            <a href="{{ $route }}/{{ $id }}" class='btn-action-table hover:text-sky-400'>
                <i class='bi bi-eye-fill'></i>
            </a>
        @endif
    @endif
    @if (auth()->user()->can("update-$route"))
        @if (!in_array('edit', $exceptActions ?? []))
            <a href="{{ $route }}/{{ $id }}/edit" class='btn-action-table hover:text-yellow-400'>
                <i class='bi bi-gear-fill'></i>
            </a>
        @endif
    @endif
    @if (auth()->user()->can("delete-$route"))
        @if (!in_array('destroy', $exceptActions ?? []))
            <form action="{{ $route }}/{{ $id }}"
                onsubmit="return confirm('Apakah anda benar-benar ingin menghapus data ini?')" method="post">
                @csrf
                @method('DELETE')
                <button class='btn-action-table hover:text-red-600'>
                    <i class='bi bi-trash'></i>
                </button>
            </form>
        @endif
    @endif
</div>

{{-- <script>
    feather.replace();
</script> --}}
