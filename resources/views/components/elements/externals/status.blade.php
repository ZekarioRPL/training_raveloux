@if ($status == 'open')
    <div class='p-2 text-sm rounded-lg text-yellow-600 bg-yellow-200 text-center'>
        <span class='font-semibold capitalize'>{{ $status }}</span>
    </div>
@endif
@if ($status == 'on')
    <div class='p-2 text-sm rounded-lg text-blue-600 bg-blue-200 text-center'>
        <span class='font-semibold capitalize' >{{ $status }}</span>
    </div>
@endif
@if ($status == 'off')
    <div class='p-2 text-sm rounded-lg text-red-600 bg-red-200 text-center'>
        <span class='font-semibold capitalize'>{{ $status }}</span>
    </div>
@endif
@if ($status == 'done')
    <div class='p-2 text-sm rounded-lg text-green-600 bg-green-200 text-center'>
        <span class='font-semibold capitalize'>{{ $status }}</span>
    </div>
@endif