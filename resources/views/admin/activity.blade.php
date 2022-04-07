@extends( (Auth::user()->hasRole('Admin')) ? 'admin.dashboard' : 'user.dashboard')

@section(Auth::user()->hasRole('Admin') ? 'kontenUserAdmin' : 'kontenUserPengguna')
<div class="block-content">
  <table class="table table-borderless table-stripped table-vcenter font-size-sm">
    <tbody>
      @foreach ($log as $item)
      <tr>
        <td class="font-w600 text-center" style="width: 100px">
            <span class="badge badge-primary">{{ ($item->username) }}</span>
        </td>
        <td class="font-w600 text-center" style="width: 100px">
            <span class="badge badge-success">{{ $item->description }}</span>
        </td>
        <td class="font-w600 text-center" style="width: 100px">
            <span class="badge badge-warning">{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
        </td>
      </tr>
          
      @endforeach
    </tbody>
  </table>
</div>
@endsection