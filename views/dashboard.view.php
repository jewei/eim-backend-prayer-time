<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard - Demo</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript" charset="utf-8">
      let a, time;
      setInterval(() => {
        a = new Date();
        time = a.getHours() + ':' + a.getMinutes() + ':' + a.getSeconds();
        document.getElementById('time').innerHTML = time;
      }, 1000);
    </script>
  </head>
  <body class="antialiased">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-3xl">
        <div class="mt-8 flow-root">
          <div class="-mx-4 my-12 overflow-x-auto sm:-mx-6 lg:-mx-8 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
              <div class="py-4 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                  <h1 class="text-base font-semibold leading-6 text-gray-900">Upcoming Prayer Times</h1>
                  <p class="mt-2 text-sm text-gray-700">Only showing the latest 20 entries. The system should notify the music player to play the voice over when the time is up.</p>
                </div>
                <div class="">
                  <p class="mt-2 mx-6 text-sm text-gray-700"><span id="time"></span></p>
                </div>
              </div>
              <table class="min-w-full divide-y divide-gray-300">
                <thead>
                  <tr>
                    <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Zone</th>
                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Time</th>
                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">When</th>
                    <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Location</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white"> 
                  <?php foreach ($prayerTimes as $prayerTime) { ?>
                    <tr>
                      <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                        <?php echo $prayerTime->timezone->name; ?>
                      </td>
                      <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                        <?php echo $prayerTime->waktu->name; ?>
                      </td>
                      <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                        <?php echo $prayerTimes[0]->start->format('M d'); ?>
                      </td>
                      <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                        <?php echo $prayerTimes[0]->start->format('H:i'); ?>
                      </td>
                      <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                        <?php echo diff_for_humans($prayerTimes[0]->start); ?>
                      </td>
                      <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-500">
                        <?php echo $prayerTime->timezone->locations(); ?>
                      </td>
                    </tr> 
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all the users and their subscriptions to music boxes.</p>
          </div>
        </div>
        <div class="mt-8 mb-12 flow-root">
          <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
              <table class="min-w-full divide-y divide-gray-300">
                <thead>
                  <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Active Subscriptions</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"></th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <?php foreach ($subscribers as $subscriber) { ?>
                    <tr class="even:bg-gray-50">
                      <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">
                        <?php echo $subscriber->name; ?>
                      </td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <?php echo $subscriber->email; ?>
                      </td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <?php echo \count($subscriber->subscriptions); ?>
                      </td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-blue-700">
                        <a href="/subscriber?id=<?php echo $subscriber->id; ?>">View →</a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>