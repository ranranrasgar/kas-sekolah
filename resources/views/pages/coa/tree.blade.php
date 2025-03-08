<tr class="{{ $coa->isRoot() ? 'text-danger fw-bold' : '' }}">
    <td>{{ $coa->id }}</td>
    <td>{{ $coa->code }}</td>
    <td>
        {!! str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $coa->level()) !!}
        @if ($coa->isRoot())
            <i class="fas fa-folder text-danger"></i>
        @else
            <i class="fas fa-sign-out-alt text-primary"></i>
        @endif
        {{ $coa->name }}
    </td>
    <td>{{ $coa->coaType->name ?? 'N/A' }}</td>
    <td>{{ $coa->coaType->description ?? '-' }}</td>
    <td>
        <div class="d-flex">
            <a href="{{ route('coa.edit', $coa->id) }}" class="btn btn-link btn-primary btn-sm me-2" title="Edit">
                <i class="fa fa-edit"></i>
            </a>
            <form id="deleteForm-{{ $coa->id }}" action="{{ route('coa.destroy', $coa->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-link btn-danger btn-sm delete-btn" data-id="{{ $coa->id }}"
                    title="Hapus">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>

@if (!$coa->isRoot() && !empty($coa->children) && $coa->level() < 5)
    @foreach ($coa->children as $child)
        @include('pages.coa.tree', ['coa' => $child])
    @endforeach
@endif
