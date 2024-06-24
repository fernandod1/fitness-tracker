<div id="registerActivityForm" style="display:none;">
  <h4 class="text-2xl font-bold dark:text-black">Register new fitness activity:</h4>
  <form action="{{ route('activity.store') }}" method="POST">
    @csrf
      <div class="mb-5">
        <label for="countries" class="block mb-2 text-sm font-medium">Activity type *</label>
        <select name="activity_type_id" class="bg-gray-0 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-0 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
          @foreach ($activityTypes as $activityType)
              <option value="{{$activityType->id}}"        
              {{ $activityType->name === $activityTypeName ? 'selected' : '' }}>{{$activityType->name}}</option>    
          @endforeach
        </select>
      </div>
      <div class="mb-5">
        <label class="block mb-2 text-sm font-medium">Activity date *</label>
        <input type="text" id="activity_date" name="activity_date" class="bg-gray-0 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-0 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choose date and time" />
      </div>
      <div class="mb-5">
        <label class="block mb-2 text-sm font-medium">Name activity *</label>
        <input type="text" name="name" class="bg-gray-0 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-0 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" />
      </div>
      <div class="mb-5">
        <label class="block mb-2 text-sm font-medium">Distance *</label>
        <input type="text" name="distance" class="bg-gray-0 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-0 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" />
      </div>
      <div class="mb-5">
        <label class="block mb-2 text-sm font-medium">Distance unit *</label>
        <select name="distance_unit" class="bg-gray-0 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-0 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option value="kilometers">kilometers</option>
          <option value="meters">meters</option>
          <option value="miles">miles</option>
        </select> 
      </div>
      <div class="mb-5">
        <label class="block mb-2 text-sm font-medium">Elapsed time (seconds) *</label>
        <input type="text" name="elapsed_time" class="bg-gray-0 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-0 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" />
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>  * Required.
    </form>
  </div>
