<div id="registerActivityForm" style="display:none;">
<h3>Register new fitness activity:</h3>
  <form action="{{ route('activity.store') }}" method="POST">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Activity type *</label>
        <select class="form-control" name="activity_type_id">
          @foreach ($activityTypes as $activityType)
              <option value="{{$activityType->id}}"        
              {{ $activityType->name === $activityTypeName ? 'selected' : '' }}>{{$activityType->name}}</option>    
          @endforeach
        </select>  
      </div>
      <div class="form-group col-md-6">
        <label>Activity date *</label>
        <input  type="text" class="form-control" id="activity_date" name="activity_date" placeholder="Choose date and time" />
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Name activity *</label>
        <input type="text" class="form-control" name="name" /> 
      </div>
      <div class="form-group col-md-3">
        <label>Distance *</label>
        <input type="text" class="form-control" name="distance" />
      </div>
      <div class="form-group col-md-3">
        <label>Units *</label>
        <select class="form-control" name="distance_unit">
          <option value="kilometers">kilometers</option>
          <option value="meters">meters</option>
          <option value="miles">miles</option>
        </select> 
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label>Elapsed time (seconds) *</label>
        <input type="text" class="form-control" name="elapsed_time" />
      </div>
    </div>
    <input type="submit" class="btn btn-primary mb-2" value="Submit"> * Required.
    </div>
  </form>
</div>