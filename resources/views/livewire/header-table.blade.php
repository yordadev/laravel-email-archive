<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between border-b py-3">
        <h1 class="text-base font-semibold text-gray-900">Headers ({{$headers->total()}})</h1>
        <div class="flex-none">
            <input wire:model.live.debounce.300ms="search" type="text"
                   class="bg-gray-50 shadow border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-3 p-2"
                   placeholder="Search headers" required="">
        </div>
    </div>
    <div class="overflow-x-auto py-4">
        <table class="w-full text-left border-collapse divide-y divide-gray-300">
            <thead>
            <tr class="divide-x divide-gray-200">
                <th class="py-3 text-sm font-semibold text-gray-900 border-b border-gray-200 sticky top-0 bg-white">Key</th>
                <th class="py-3 px-4 text-sm font-semibold text-gray-900 border-b border-gray-200 sticky top-0 bg-white">Value</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($headers as $header)
                <tr class="divide-x divide-gray-200">
                    <td class="py-4 pl-4 text-sm font-medium text-gray-900 border-b border-gray-100">{{ $header->key }}</td>
                    <td class="py-4 px-4 text-sm text-gray-500 break-all border-b border-gray-100">{{ $header->value }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="py-6" id="pagination-links">
        {{ $headers->links() }}
    </div>
</div>
