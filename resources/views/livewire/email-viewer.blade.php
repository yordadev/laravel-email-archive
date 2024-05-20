<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="relative shadow-xl rounded-lg overflow-hidden bg-white">
                <div class="relative mx-5 py-5 px-4 sm:px-6">
                    <div class="py-5 border-b border-gray-200">
                        <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-2 text-center">
                                <h1 class="text-base font-semibold leading-6 text-gray-900">Email Viewer</h1>
                            </div>
                            <div class="ml-4 mt-2 text-right">
                                <div class="flex space-x-3 items-center">
                                    <a href="/" class="rounded shadow px-3 py-1 bg-indigo-500 text-white text-sm">Go
                                        Back</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="mt-3">
                        <livewire:header-table id="{{ $email->id }}"/>
                    </div>
                    <div class="flex items-center justify-between border-b py-3">
                        <h1 class="text-base font-semibold text-gray-900">Details </h1>
                        <div class="flex-none">

                        </div>
                    </div>
                    <div class="mt-3">
                        <dl class="grid grid-cols-1 sm:grid-cols-2">
                            <div class="border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Message ID:</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2">{{ $email->detail->message_id }}</dd>
                            </div>
                            <div class="border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900"> Subject:</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2">{{ $email->detail->subject }}</dd>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Sender:</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2">{{ $email->detail->from }}</dd>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Receiver:</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2">{{ $email->detail->to }}</dd>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Reply To:</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2">{{ $email->headers->where('key', 'reply-to')->first()?->value }}</dd>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-6 sm:col-span-1 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Date:</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:mt-2">{{$email->headers->where('key', 'date')->first()?->value }}</dd>
                            </div>
                            <div class="border-t border-gray-100 px-4 py-6 sm:col-span-2 sm:px-0">
                                <dt class="text-sm font-medium text-gray-900">Content</dt>
                                <dd class="mt-1 text-sm text-gray-700 sm:mt-2 max-w-screen"
                                    style="white-space: pre-wrap; overflow-y: auto; max-height: 400px;">
                                    {!! $email->body->content !!}
                                </dd>
                            </div>

                        </dl>
                    </div>
                    <div class="border-t border-gray-100 px-4 py-6 sm:col-span-2 sm:px-0 mt-3">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Attachments</dt>
                        <dd class="mt-2 text-sm text-gray-900">
                            <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                    <div class="flex w-0 flex-1 items-center">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20"
                                             fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                    <span
                                                        class="truncate font-medium">resume_back_end_developer.pdf</span>
                                            <span class="flex-shrink-0 text-gray-400">2.4mb</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="#"
                                           class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                    </div>
                                </li>
                                <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                    <div class="flex w-0 flex-1 items-center">
                                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20"
                                             fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <span class="truncate font-medium">coverletter_back_end_developer.pdf</span>
                                            <span class="flex-shrink-0 text-gray-400">4.5mb</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="#"
                                           class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                    </div>
                                </li>
                            </ul>
                        </dd>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
