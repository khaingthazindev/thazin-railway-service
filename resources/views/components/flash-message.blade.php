@if (count($errors) > 0)
   <div
      class="tw-flex tw-p-4 tw-mb-4 tw-text-sm tw-text-red-800 tw-border tw-rounded-lg tw-border-red-300 tw-bg-red-50 dark:tw-bg-gray-800 dark:tw-text-red-400"
      role="alert">
      <svg class="shrink-0 tw-inline tw-w-4 tw-h-4 me-3 mt-[2px] tw-mt-1 tw-mr-1" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
      </svg>
      <span class="tw-sr-only">Danger</span>
      <div>
        <span class="tw-font-medium">Ensure that these requirements are met:</span>
        <ul class="tw-mt-1.5 tw-list-disc tw-list-inside">
          @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
         @endforeach
        </ul>
      </div>
   </div>
@endif