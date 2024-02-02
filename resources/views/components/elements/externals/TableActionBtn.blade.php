<div class="flex">
    @if (!in_array('show', $exceptActions ?? []))
        <a href="{{ $route }}/{{ $id }}" class='btn-action-table hover:text-sky-400'>
           <i data-feather="eye" width="18"></i>
        </a>
    @endif
    @if (!in_array('edit', $exceptActions ?? []))
        <a href="{{ $route }}/{{ $id }}/edit" class='btn-action-table hover:text-yellow-400'>
            <i data-feather="settings" width="18"></i>
        </a>
    @endif
    @if (!in_array('destroy', $exceptActions ?? []))
        <form action="{{ $route }}/{{ $id }}"
            onsubmit="return confirm('Apakah anda benar-benar ingin menghapus data ini?')" method="post">
            @csrf
            @method('DELETE')
            <button class='btn-action-table hover:text-red-600'>
                <i data-feather="trash-2" width="18"></i>
            </button>
        </form>
    @endif
</div>

<script>
    feather.replace();
</script>