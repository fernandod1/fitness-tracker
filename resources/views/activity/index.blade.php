@php
$activityTypeName = "";
if(Request()->activity_type_id){
  foreach($activityTypes as $activityType){
    if($activityType->id == Request()->activity_type_id)
      $activityTypeName = $activityType->name;
  }
}
@endphp

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        @auth
          {{ __('Dashboard') }}
        @else 
        {{ __('Last tracks of users') }}
        @endauth
      </h2>
      @include('messages.activities')
      @include('messages.pusher')
      @auth
        <button type="button"  onclick="showRegisterActivityForm()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">New activity</button>
        @include('forms.search_activity2')      
        @include('forms.register_activity2')
      @endauth
      <h3>{{$activityTypeName}} Fitness activities records</h3>
      @if(Request()->activity_type_id)
        <div class="form-row">
        <div>Total distance {{$activityTypeName}}: 
          <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{$totalGoals["distanceMeters"] ?? 0 }}</span> meters</div>
        <div>Total elapsed time {{$activityTypeName}}:  <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{$totalGoals["elapsedTimeSeconds"] ?? 0}}</span> seconds</div>
        </div>
      @endif
  </x-slot>

                  







  <div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right ">
        <thead class="text-xs uppercase">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Distance
                </th>
                <th scope="col" class="px-6 py-3">
                  Unit
                </th>
                <th scope="col" class="px-6 py-3">
                Elapsed time
                </th>
                <th scope="col" class="px-6 py-3">                  
                </th>
            </tr>
        </thead>
        <tbody>
          @foreach ($activities as $activity)
            <tr class="bg-white border-b">
              <td class="px-6 py-4">{{$activity->activity_type->name}}</td>
              <td class="px-6 py-4">{{$activity->activity_date}}</td>
              <td class="px-6 py-4">{{$activity->name}}</td>
              <td class="px-6 py-4">{{$activity->distance}}</td>
              <td class="px-6 py-4">{{$activity->distance_unit}}</td>
              <td class="px-6 py-4">{{date("H:i:s", $activity->elapsed_time)}}</td>
              <td>
                @can('delete', $activity)
                  @include('forms.delete')
                @endcan
              </td>
            </tr>
          @endforeach
        </tbody>
    </table>
    {{ $activities->appends(request()->query())->links() }}
                
    @if ($activities->count() < 1 )
      Not results found.        
    @else
      @if(Request()->activity_type_id)
        @include('charts.byactivitytype')
      @endif
    @endif
  </div>
</x-app-layout>