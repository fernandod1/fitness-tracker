Hello,
<br><br>
your new activity has been added. Your actual records numbers are:
<br><br>
Total distance: {{ $activityService->CalculateActivityTotalGoals()["distanceMeters"] }} meters<br>
Total time elapsed: {{ gmdate("H:i:s", $activityService->CalculateActivityTotalGoals()["elapsedTimeSeconds"]) }} seconds
<br><br>
Thank you.
