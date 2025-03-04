@php $no = 1; @endphp
@foreach ($children as $child)
    <tr data-parent="{{ $child->parent_id }}" style="display: none;">
        <td>{{ $no++ }}</td>
        <td style="padding-left: {{ $level * 20 }}px;">{{ $child->code }}</td>
        <td>{{ $child->name }}</td>
        <td>{{ $child->coaType->name ?? 'N/A' }}</td>
        <td>{{ $child->coaType->description ?? '-' }}</td>
        <td>
            <a href="{{ route('coa.edit', $child->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
            <form action="{{ route('coa.destroy', $child->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
            </form>
        </td>
    </tr>
    @include('pages.coa.tree', ['children' => $child->children, 'level' => $level + 1])
@endforeach
