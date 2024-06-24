
# Fitness activities tracker

Small Laravel web project to track daily users fitness activities. Features:
 
- User registration and login.
- General listing of all activities.
- Filter by type option (cycling, running, swimming...).
- Online form to add new activities.

## Tech features

- Request form data validation on new activity.
- Data cache system on public dashboard.
- Observer to trigger update cache on new fitness activity.
- Event and Listener on new fitness activity and email feature.
- Email report of personal goals.
- Policy for specify resources by rol (Example: only admin can delete records).
- Broadcast (pusher) new activity added to rest of online users (php artisan queue:work)

## API features

Created API Rest with 3 endpoints:

- List activities.
- Add new activity.
- Filter by category activities (including total goals: distance and time elapsed).

## API Tech features

- Api Token authentication via Sanctum.
- Rate limiting feature enabled to prevent abuse (60 requests/minute).
- Block IPs feature enabled.

### Endpoint list activities

Endpoint: /api/v1/activities

Method: GET

> __Example response__:
```json
{
    "activities": {
        "data": [
            {
                "id": 2,
                "user_id": 1,
                "activity_type_id": 2,
                "activity_date": "07-06-2024 10:15",
                "name": "Roundtrip in mountain",
                "distance": 7,
                "distance_unit": "kilometers",
                "elapsed_time": 650,
                "activity_type": {
                    "id": 2,
                    "name": "Cycling"
                },
                "user": {
                    "id": 1,
                    "name": "Admin"
                }
            },
            {
                "id": 4,
                "user_id": 1,
                "activity_type_id": 1,
                "activity_date": "05-06-2024 09:17",
                "name": "Running with Matt",
                "distance": 10000,
                "distance_unit": "meters",
                "elapsed_time": 3000,
                "activity_type": {
                    "id": 1,
                    "name": "Running"
                },
                "user": {
                    "id": 1,
                    "name": "Admin"
                }
            }
        ],
        "path": "http://localhost/fitness-tracker/public/api/v1/activities",
        "per_page": 10,
        "next_cursor": null,
        "next_page_url": null,
        "prev_cursor": null,
        "prev_page_url": null
    },
    "success": true
}
```

### Endpoint add new activity

Endpoint: /api/v1/activities

Method: POST

> __Example payload__:
```json
{
    "activity_type_id": 1,
    "activity_date": "2022-02-03 10:11",
    "name": "Cycling to oldtown",
    "distance": 22,
    "distance_unit": "kilometers",
    "elapsed_time": "150"
}
```


> __Example response__:
```json
{
    "activities": {
        "activity_type_id": 1,
        "activity_date": "03-02-2022 10:11",
        "name": "Cycling to oldtown",
        "distance": 22,
        "distance_unit": "kilometers",
        "elapsed_time": "150",
        "id": 37
    },
    "success": true
}
```


### Endpoint filter by category and calculate total goals

Endpoint Example: /api/v1/activities/types/1

**(Note: number 1 in endpoint represents activity type ID field of ***activity_types*** table in database).**

Method: GET

> __Example response__:
```json
{
    "activities": {
        "data": [
            {
                "id": 2,
                "user_id": 1,
                "activity_type_id": 2,
                "activity_date": "07-06-2024 10:15",
                "name": "Roundtrip in mountain",
                "distance": 7,
                "distance_unit": "kilometers",
                "elapsed_time": 650,
                "activity_type": {
                    "id": 2,
                    "name": "Cycling"
                }
            },
            {
                "id": 3,
                "user_id": 1,
                "activity_type_id": 2,
                "activity_date": "04-06-2024 12:00",
                "name": "Central Park round",
                "distance": 3,
                "distance_unit": "kilometers",
                "elapsed_time": 400,
                "activity_type": {
                    "id": 2,
                    "name": "Cycling"
                }
            },
            {
                "id": 1,
                "user_id": 1,
                "activity_type_id": 2,
                "activity_date": "01-06-2024 12:00",
                "name": "Cycling around lake",
                "distance": 4,
                "distance_unit": "kilometers",
                "elapsed_time": 500,
                "activity_type": {
                    "id": 2,
                    "name": "Cycling"
                }
            }
        ],
        "path": "http://localhost/fitness-tracker/public/api/v1/activities/types/2",
        "per_page": 10,
        "next_cursor": null,
        "next_page_url": null,
        "prev_cursor": null,
        "prev_page_url": null
    },
    "total_goals": {
        "distanceMeters": 14000,
        "elapsedTimeSeconds": 1550
    },
    "success": true
}
```

Json key ***total_goals*** represents total distance and total elapsed time by category.

## PHPUnit tests

Includes some tests done to web service and API service.

# How to install project

1. ) Clone GitHub project and access to directory.
2. ) Install depedences writing ***compose install***
3. ) Copy ***.env.example*** file, rename to ***.env*** and configure database credentials.
4. ) Generate encryption key executing command: ***php artisan key:generate***
5. ) Configure desired admin email in: /config/admin.php
6. ) Configure desired API parameters in: config/api.php
7. ) Execute migration of database ***php artisan migrate***
8. ) Execute seeders of database ***php artisan db:seed***
9. ) Execute command ***npm run dev***
10. ) Activate queue service ***php artisan queue:work***
11. ) Load project in http://localhost/fitness-tracker/public/

## Screenshots

Main page displaying fitness activities cached pag for guests:

<img src=SCREENSHOTS/01.png width=600>

Fitness login page to personal statistics:

<img src=SCREENSHOTS/02.png width=300>

Fitness user activities:

<img src=SCREENSHOTS/03.png width=600>

Fitness user activities filtered by type:

<img src=SCREENSHOTS/04.png width=600>
