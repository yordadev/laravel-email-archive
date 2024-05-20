<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="relative shadow-xl rounded-lg overflow-hidden bg-white">
                <div class="flex items-center justify-between p-4">
                    <div class="flex">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                     fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                   placeholder="Search" required="">
                        </div>

                    </div>

                    <div class="flex space-x-3">
                        <div class="flex space-x-3 items-center">
                            <label class="w-32 text-sm text-gray-900 pl-1">Per Page</label>
                            <select wire:model.live="limit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                            </select>
                        </div>

                        <div class="flex space-x-3 items-center hidden md:flex">
                                <label class="w-32 text-sm text-gray-900">Sorting by</label>
                                <select wire:model.live="sortDir"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full">
                                    <option value="desc">Desc</option>
                                    <option value="asc">Asc</option>
                                </select>
                        </div>
                        <div class="flex space-x-3 items-center w-32">
                            <button wire:click="$dispatch('openModal', { component: 'import-email' })"
                                    class="rounded shadow px-3 py-1 bg-indigo-500 text-white text-sm">Import Email
                            </button>
                        </div>
                        <div>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="hidden px-3 py-3 text-left text-sm text-gray-900 sm:table-cell">Email Sender</th>
                            <th scope="col" class="hidden px-3 py-3 text-left text-sm text-gray-900 md:table-cell">Email Recipient</th>
                            <th scope="col" class="px-3 py-3 text-left text-sm text-gray-900">Email Subject</th>
                            <th scope="col" class="px-4 py-3 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($emails->isEmpty())
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-5 text-center" colspan="4">No emails imported</td>
                            </tr>
                        @endif
                        @foreach($emails as $email)
                            <tr wire:key="{{ $email->id }}" class="border-b dark:border-gray-700">
                                <td class="hidden px-4 py-3 sm:table-cell">{{ $email->detail->from }}</td>
                                <td class="hidden px-4 py-3 md:table-cell">{{ $email->detail->to }}</td>
                                <td class="px-4 py-3">{{ $email->detail->subject }}</td>
                                <td class="px-4 py-3 flex items-center justify-end space-x-2">
                                    <a href="{{ route('viewer', ['id' => $email->id]) }}"
                                       class="px-3 py-1 bg-indigo-500 text-white rounded text-sm">View</a>
                                    <button
                                        onclick="confirm('Are you sure you want to delete {{ $email->detail->subject }} ?') || event.stopImmediatePropagation()"
                                        wire:click="delete({{ $email->id }})"
                                        class="px-3 py-1 bg-red-500 text-white rounded text-sm">Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($emails->hasPages())
                <div class="py-4 px-3">
                    {{ $emails->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
