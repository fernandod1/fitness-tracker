<canvas id="acquisitions" style="margin: 0 auto;min-width:600px;width:auto;"></canvas>
<script>
    new Chart(document.getElementById("acquisitions"), {
    type : 'line',
    data : {
        labels :   [@foreach ($activities as $activity)"{{date("d/m H:i", strtotime($activity->activity_date)).'h'}}", @endforeach],
        datasets : [
                {
                    data : [@foreach ($activities as $activity)
                    @if($activity->distance_unit=="kilometers")
                        "{{$activity->distance*1000}}", 
                    @elseif($activity->distance_unit=="miles")
                        "{{$activity->distance*1609.34}}",
                    @else
                        "{{$activity->distance}}", 
                    @endif
                    
                    @endforeach],
                    label : "{{$activityTypeName}}",
                    borderColor : "#2576f7",
                    fill : false
                }]
    },
    options : {
        title : {
            display : true,
            text : 'Chart by activity type'
        }
    }
    });
</script>

<style>
    canvas{
    margin: 0 auto;
    }
</style>