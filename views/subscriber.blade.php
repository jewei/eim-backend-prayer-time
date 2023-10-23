<!DOCTYPE html>
<html>
  <head>
    <title>Subscriber - Demo</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="antialiased">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-3xl">
        <div class="mt-12    sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ $subscriber->name }}</h1>
            <p class="mt-2 text-sm text-gray-700">A list of the subscribed music boxes.</p>
          </div>
        </div>
        <ul role="list" class="mt-8 grid grid-cols-1 gap-x-6 gap-y-8 xl:gap-x-8">
          @foreach ($subscriber->subscriptions as $subscription)
          <li class="overflow-hidden rounded-xl border border-gray-200">
            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
              <div class="text-sm font-medium leading-6 text-gray-900">ID: <strong>{{ $subscription->musicbox->id }}</strong></div>
              <div class="text-sm font-medium text-gray-900">Zone: <strong>{{ $subscription->musicbox->prayer_timezone->name }}</strong></div>
            </div>
            <div class="px-6 py-4 text-sm leading-6">
              @foreach ($subscription->musicbox->songs as $song)
              <p><span class="text-gray-500">{{ $loop->iteration }}.</span> {{ $song->name }}</p>
              @endforeach
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </body>
</html>